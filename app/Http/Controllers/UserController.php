<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const USER_ARTICLES_LIMIT = 5;

    public function show(int $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return abort(404, 'User not found, id: ' . $id);

        $userInfo = [
            'id' => $id,
            'username' => $user->username,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'is_admin' => $user->is_admin,
            'avatar' => $user->avatar,
            'is_suspended' => $user->is_suspended,
            'reputation' => $user->reputation,
        ];

        $follows = false;
        $isOwner = false;
        if (Auth::check()) {
            $follows = Auth::user()->isFollowing($id);
            $isOwner = Auth::id() == $userInfo['id'];
        }


        $followerCount = count($user->followers);

        $articles = $user->articles()->map(fn ($article) => $article
            ->only('id', 'title', 'thumbnail', 'body', 'published_date', 'likes', 'dislikes', 'author'))
            ->sortByDesc('published_date');

        $canLoadMore = count($articles) > $this::USER_ARTICLES_LIMIT;

        return view('pages.user.profile', [
            'user' => $userInfo,
            'follows' => $follows,
            'followerCount' => $followerCount,
            'articles' => $articles->take($this::USER_ARTICLES_LIMIT),
            'canLoadMore' => $canLoadMore,
            'date_of_birth' => date('F j, Y', strtotime($userInfo['date_of_birth'])),
            'age' => date_diff(date_create($userInfo['date_of_birth']), date_create(date('d-m-Y')))->format('%y'),
            'isOwner' => $isOwner,
        ]);
    }

    public function delete(Request $request, int $id): RedirectResponse
    {
        $user = User::find($id);
        if (is_null($user))
            return redirect()->back()->withErrors(['user' => 'User not found, id: ' . $id]);

        $this->authorize('delete', $user);

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|password'
        ]);

        

        $deleted = $user->delete();
        if ($deleted)
            return redirect('/');
        else
            return redirect()->back()->withErrors(['user' => 'Failed to delete user account. Try again later']);
    }

    public function edit(int $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return abort(404, 'User not found, id: ' . $id);

        $this->authorize('update', $user);

        $userInfo = [
            'id' => $id,
            'username' => $user->username,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'is_admin' => $user->is_admin,
            'avatar' => $user->avatar,
            'is_suspended' => $user->is_suspended,
            'reputation' => $user->reputation,
        ];


        $followerCount = count($user->followers);

        $favoriteTopics = $user->favoriteTopics->map(fn ($topic) => $topic->only('id'));

        $topics = Topic::listTopicsbyStatus(TopicController::topicStatus['accepted'])
            ->map(fn ($topic) => $topic->only('id', 'subject'));

        return view('pages.user.editProfile', [
            'user' => $userInfo,
            'followerCount' => $followerCount,
            'date_of_birth' => date('d-m-Y', strtotime($userInfo['date_of_birth'])),
            'topics' => $topics,
            'favoriteTopics' => $favoriteTopics,
        ]);
    }

    public function report(Request $request, int $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'User not found, id: ' . $id,
                'errors' => ['user' => 'User not found, id: ' . $id]
            ], 404);

        $this->authorize('report', $user);

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|min:5|max:200',
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'Reason must have a number of characters between 5 and 200.',
                'errors' => $validator->errors(),
            ], 400);

        $report = new Report();
        $report->reason = $request->reason;
        $report->reported_id = $id;
        $report->reporter_id = Auth::id();
        $report->reported_at = gmdate('Y-m-d H:i:s');
        $report->save();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Successful user report',
            'id' => $report->id
        ], 200);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::find($id);
        if (is_null($user))
            return redirect()->back()->withErrors(['user' => 'User not found, id: ' . $id]);

        $this->authorize('update', $user);

        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:authenticated_user',
            'password' => 'required_with:new_password,email|string|password',
            'new_password' => 'nullable|string|min:6|confirmed',
            // Minimum: 12 years old
            'date_of_birth' => 'nullable|string|date_format:Y-m-d|before_or_equal:'.date('Y-m-d', strtotime('-12 years')),
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
            'favoriteTopics' => 'nullable|array',
            'favoriteTopics.*' => [
                'integer',
                Rule::exists('topic', 'id')->where('status', 'ACCEPTED')
            ], // max 5MB
        ], ['before_or_equal' => 'You must be at least 12 years old']);

        
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                if (str_contains($key, 'favoriteTopics'))
                    $key = 'favoriteTopics';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            
            return redirect()->back()->withInput()->withErrors($errors);
        }

        if (isset($request->username)) $user->username = $request->username;
        if (isset($request->email)) $user->email = $request->email;
        if (isset($request->new_password)) $user->password = bcrypt($request->new_password);
        if (isset($request->date_of_birth)) $user->date_of_birth = $request->date_of_birth;

        if (isset($request->avatar)) {
            $newAvatar = $request->avatar;
            $oldAvatar = $user->avatar;

            $imgName = round(microtime(true)*1000) . '.' . $newAvatar->extension();
            $newAvatar->storeAs('public/avatars', $imgName);
            $user->avatar = $imgName;

            if (!is_null($oldAvatar))
                Storage::delete('public/thumbnails/' . $oldAvatar);
        }

        $user->save();
        $user->favoriteTopics()->sync($request->favoriteTopics);

        return redirect("/user/${id}");
    }

    public function followed(int $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return abort(404, 'User not found, id: ' . $id);

        $this->authorize('followed', $user);

        $followedUsers = $user->following->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'is_admin' => $user->is_admin,
                'reputation' => $user->reputation,
                'is_suspended' => $user->is_suspended,
                'followed' => true,
            ];
        });

        return view('pages.user.followedUsers', [
            'users' => $followedUsers,
        ]);
    }

    public function follow(int $id)
    {
        $userToFollow = User::find($id);
        if (is_null($userToFollow))
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'User not found, id: ' . $id,
                'errors' => ['user' => 'User not found, id: ' . $id]
            ], 404);

        $this->authorize('follow', $userToFollow);

        if (Auth::user()->isFollowing($id))
            return response()->json([
                'status' => 'OK',
                'msg' => 'User already followed',
                'id' => $id,
            ], 200);

        $userToFollow->followers()->attach(Auth::id());

        return response()->json([
            'status' => 'OK',
            'msg' => 'Successful user follow',
            'id' => $id,
        ], 200);
    }

    public function unfollow(int $id)
    {
        $userToUnfollow = User::find($id);
        if (is_null($userToUnfollow))
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'User not found, id: ' . $id,
                'errors' => ['user' => 'User not found, id: ' . $id]
            ], 404);

        $this->authorize('unfollow', $userToUnfollow);

        if (!Auth::user()->isFollowing($id))
            return response()->json([
                'status' => 'OK',
                'msg' => 'User already not followed',
                'id' => $id,
            ], 200);

        $userToUnfollow->followers()->detach(Auth::id());

        return response()->json([
            'status' => 'OK',
            'msg' => 'Successful user unfollow',
            'id' => $id,
        ], 200);
    }
}