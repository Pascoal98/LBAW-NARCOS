<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    const topicStatus = [
        'accepted' => 'ACCEPTED',
        'rejected' => 'REJECTED',
        'pending' => 'PENDING'
    ];

    public function show(int $topic_id) {

        $topic = Topic::find($topic_id);

        $articles = $topic->articles()->map(fn ($article) => $article
        ->only('id', 'title', 'thumbnail', 'body', 'published_date', 'likes', 'dislikes'))
        ->sortByDesc('published_date');

        return view('partials.post.articles', [
            'articles' => $articles,
        ]);
    }

    public function showAll() {

        $topics = Topic::listTopicsByStatus('ACCEPTED');
        
        return view('pages.listTopics', [
            'topics' => $topics,
        ]);
    }
    
    public function accept(int $topic_id)
    {
        $this->authorize('accept', Topic::class);

        $topic = Topic::find($topic_id);
        if (is_null($topic)) return Response()->json([
            'status' => 'NOT FOUND',
            'msg' => 'There is no Topic with id' . $topic_id,
            'topic_id' => $topic_id
        ], 404);

        if ($topic->status == 'ACCEPTED')
            return Response()->json([
                'status' => 'OK',
                'msg' => 'Topic was already accepted',
                'topic_id' => $topic_id,
            ], 200);

        $topic->status = 'ACCEPTED';
        $topic->save();   

        return Response()->json([
            'status' => 'OK',
            'msg' => 'Successfully accepted topic: '.$topic['subject'],
            'topic_id' => $topic_id,
            'subject' => $topic['subject'],
        ], 200);
    }

    
    public function reject(int $topic_id)
    {
        $this->authorize('reject', Topic::class);

        $topic = Topic::find($topic_id);
        if (is_null($topic)) return Response()->json([
            'status' => 'NOT FOUND',
            'msg' => 'There is no Topic with id' . $topic_id,
            'topic_id' => $topic_id
        ], 404);

        if ($topic->status == 'REJECTED')
            return Response()->json([
                'status' => 'OK',
                'msg' => 'Topic was already rejected',
                'topic_id' => $topic_id
            ], 200);

        $topic->status = 'REJECTED';
        $topic->save();

        return Response()->json([
            'status' => 'OK',
            'msg' => 'Successfully rejected topic: '.$topic['subject'],
            'topic_id' => $topic_id,
            'subject' => $topic['subject'],
        ], 200);
    }

    
    public function addUserFavorite($topic_id)
    {
        $this->authorize('addFavorite', Topic::class);

        $topic = Topic::find($topic_id);
        if (is_null($topic)) return Response()->json([
            'status' => 'NOT FOUND',
            'msg' => 'There is no Topic with id' . $topic_id,
            'topic_id' => $topic_id
        ], 404);

        $user = Auth::user();

        if ($topic->isFavorite($user->id))
            return Response()->json([
                'status' => 'OK',
                'msg' => 'Topic already added to favorites, id: ' . $topic_id,
            ], 200);



        $topic->favoriteUsers()->attach($user->id);

        return Response()->json([
            'status' => 'OK',
            'msg' => 'Successfully added topic to user favorites',
            'topic_id' => $topic_id,
        ], 200);
    }

    
    public function removeUserFavorite($topic_id)
    {
        $this->authorize('removeFavorite', Topic::class);

        $topic = Topic::find($topic_id);
        if (is_null($topic)) return Response()->json([
            'status' => 'NOT FOUND',
            'msg' => 'There is no Topic with id' . $topic_id,
            'topic_id' => $topic_id
        ], 404);

        $user = Auth::user();

        if (!$topic->isFavorite($user->id))
            return Response()->json([
                'status' => 'OK',
                'msg' => 'Topic was not a favorite, id: ' . $topic_id,
            ], 200);



        $topic->favoriteUsers()->detach($user->id);

        return Response()->json([
            'status' => 'OK',
            'msg' => 'Successfully removed topic from user favorites',
            'topic_id' => $topic_id,
        ], 200);
    }


    public function destroy(int $id)
    {
        $this->authorize('destroy', Topic::class);

        $topic = Topic::find($id);

        if (is_null($topic))
            return Response()->json([
                'status' => 'NOT FOUND',
                'msg' => 'There is no Topic with id' . $id,
                'topic_id' => $id
            ], 404);

        $deleted = $topic->delete();
        if (!$deleted)
            return Response()->json([
                'status' => 'Internal Server Error',
                'msg' => 'There was an error deleting the topic with id ' . $id,
            ], 500);

        return Response()->json([
            'status' => 'OK',
            'msg' => 'Successfully removed topic: '.$topic['subject'],
            'topic_id' => $id,
            'subject' => $topic['subject'],
        ], 200);
    }

    
    public function propose(Request $request)
    {
        $this->authorize('propose', Topic::class);

        $validator = Validator::make($request->all(), [
            'topicName' => 'required|string|min:2|unique:topic,subject'
        ]);

        if ($validator->fails()) {
            return Response()->json([
                'status' => 'Bad Request',
                'msg' => 'Failed to propose a new topic. Bad Request',
                'errors' => $validator->errors(),
            ], 400);
        }

        $topic = new Topic;
        $topic->subject = $request->topicName;
        $topic->user_id = Auth::id();
        $topic->save();

        return Response()->json([
            'status' => 'OK',
            'msg' => 'Successfully proposed topic',
            'topicName' => $request->topicName,
        ], 200);
    }
}