<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    private const COMMENTS_LIMIT = 10;

    public function createForm() 
    {
        if (Auth::guest()) 
            return redirect('/login');

        $user = User::find(Auth::id());
        if (is_null($user)) 
            return redirect('/login');

        $authorInfo = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'is_admin' => $user->is_admin,
            'avatar' => $user->avatar,
            'is_suspended' => $user->is_suspended,
            'reputation' => $user->reputation,
        ];

        $topics = Topic::listTopicsByStatus('ACCEPTED')
            ->map(fn ($topic) => $topic->only('id', 'subject'));

        return view('pages.article.create_article', [
            'author' => $authorInfo,
            'topics' => $topics,
        ]);
    }


    public function create(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $validator = Validator::make($request -> all(),
            [
                'body' => 'required|string|min:10',
                'title' => 'required|string|min:3|max:100',
                'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
                'topics' => 'required|array|min:1|max:3',
                'topics.*' => 'required|string|min:1',
            ]
        );
        if ( $validator->fails() ) {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                if (str_contains($key, 'topics'))
                    $key = 'topics';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            // Go back to form and refill it
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $topicsIds = [];

        foreach($request->topics as $topic) {
            $checkTopic = Topic::find($topic);

            //check if is valid topic
            if (!$checkTopic || $checkTopic->status != 'ACCEPTED') {
                return redirect()->back()->withInput()->withErrors(['topics' => 'Invalid Topic: '.$topic]); 
            }
            array_push($topicsIds, $checkTopic->id);
        }

        $post = new Post;
        $post->body = $request->body;
        $post->author_id = Auth::id();
        $post->save();

        $article = new Article;
        $article->post_id = $post->id;
        $article->title = $request->title;

        if (isset($request->thumbnail)) {
            $thumbnail = $request->thumbnail;
            $imgName = round(microtime(true)*1000).'.'.$thumbnail->extension();
            $thumbnail->storeAs('public/thumbnails', $imgName);
            $article->thumbnail = $imgName;
        }

        $article->save();

        $article->articleTopics()->sync($topicsIds);

        return redirect("/article/$article->post_id");
    }

    /**
     * Display Article Page.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $article = Article::find($id);
        if (is_null($article)) 
            return abort(404, 'Article not found, id: '.$id);

        $articleInfo = [
            'id' => $article->post_id,
            'title' => $article->title,
            'thumbnail' => $article->thumbnail,
            'body' => $article->body,
            'published_date' => $article->published_date,
            'likes' => $article->likes,
            'dislikes' => $article->dislikes,
            'is_edited' => $article->is_edited
        ];

        $author = $article->author;

        if (isset($author))
            $authorInfo = [
                'id' => $author->id,
                'username' => $author->username,
                'email' => $author->email,
                'date_of_birth' => $author->date_of_birth,
                'is_admin' => $author->is_admin,
                'avatar' => $author->avatar,
                'is_suspended' => $author->is_suspended,
                'reputation' => $author->reputation,
            ];
        else $authorInfo = null; // Anonymous, account deleted

        $is_author = isset($author) ? $author->id === Auth::id() : false;

        $comments = $article->getParsedComments();
        $canLoadMore = count($comments) > $this::COMMENTS_LIMIT;
        $comments = $comments->take($this::COMMENTS_LIMIT);

        $topics = $article->articleTopics->map(fn ($topic) => $topic->only('subject'))
            ->sortBy('subject');

        $user = Auth::user();
        $is_admin = Auth::user() ? $user->is_admin : false;

        $feedback = Auth::check() 
            ? Feedback::where('user_id', '=', Auth::id())->where('post_id', '=', $id)->first()
            : null;

        $liked = false;
        $disliked = false;

        if (!is_null($feedback)){
            $liked = $feedback->is_like;
            $disliked = !$feedback->is_like;
        }

        $hasFeedback = $liked || $disliked || !$comments->isEmpty();

        return view('pages.article.article', [
            'article' => $articleInfo,
            'author' => $authorInfo,
            'comments' => $comments,
            'canLoadMore' => $canLoadMore,
            'topics' => $topics,
            'is_author' => $is_author,
            'is_admin' => $is_admin,
            'liked' => $liked,
            'disliked' => $disliked,
            'hasFeedback' => $hasFeedback,
        ]);
    }

    public function comments(Request $request, int $id)
    {
        $article = Article::find($id);
        if (is_null($article))
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Article not found, id: ' . $id,
                'errors' => ['Article' => 'Article not found, id: ' . $id]
            ], 404);

        $validator = Validator::make($request->all(), [
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'Failed to fetch article\'s comments. Bad request',
                'errors' => $validator->errors(),
            ], 400);

        if (!isset($request->offset)) $request->offset = 0;

        $comments = $article->getParsedComments()->skip($request->offset);
        $canLoadMore = isset($request->limit) ? count($comments) > $request->limit : false;
        $comments = $comments->take($request->limit);

        return response()->json([
            'html' => view('partials.post.comments', [ 'comments' => $comments ])->render(),
            'canLoadMore' => $canLoadMore
        ], 200);
    }

    public function edit(int $id)
    {
        $article = Article::find($id);
        if (is_null($article)) 
            return abort(404, 'Article not found, id: '.$id);

        $post = Post::find($article->post_id);
        if (is_null($post))
            return abort(404, 'Post not found, id: '.$article->post_id);

        $this->authorize('update', $post);

        $articleInfo = [
            'post_id' => $article->post_id,
            'title' => $article->title,
            'thumbnail' => $article->thumbnail,
            'body' => $article->body,
        ];

        $articleTopics = $article->articleTopics->map(fn ($topic) => $topic->only('id', 'subject'))->sortBy('subject');

        $topics = Topic::listTopicsByStatus('ACCEPTED')->map(fn ($topic) => $topic->only('id', 'subject'));

        $author = $article->author;
        $authorInfo = [
            'id' => $author->id,
            'username' => $author->username,
            'email' => $author->email,
            'date_of_birth' => $author->date_of_birth,
            'is_admin' => $author->is_admin,
            'avatar' => $author->avatar,
            'is_suspended' => $author->is_suspended,
            'reputation' => $author->reputation,
        ];

        return view('pages.article.edit_article', [
            'article' => $articleInfo,
            'topics' => $topics,
            'articleTopics' => $articleTopics,
            'author' => $authorInfo,
        ]);
    }

    public function update(Request $request, int $id) : RedirectResponse
    {

        $article = Article::find($id);
        if (is_null($article)) 
            return redirect()->back()->withErrors(['article' => 'Article not found, id:'.$id]);

        $post = Post::find($article->post_id);
        if (is_null($post)) 
            return redirect()->back()->withErrors(['post' => 'Post not found, id:'.$id]);

        $this->authorize('update', $post);

        $validator = Validator::make($request -> all(),
        [
            'body' => 'nullable|string|min:10',
            'title' => 'nullable|string|min:1|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
            'topics' => 'required|array|min:1|max:3',
            'topics.*' => 'required|string|min:1',
        ]);

        if ( $validator->fails() ) {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                if (str_contains($key, 'topics'))
                    $key = 'topics';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            // Go back to form and refill it
            return redirect()->back()->withInput()->withErrors($errors);
        }

        if (isset($request->body)) $post->body = $request->body;
        if (isset($request->title)) $article->title = $request->title;
        if (isset($request->thumbnail)) {
            $newThumbnail = $request->thumbnail;
            $oldThumbnail = $article->thumbnail;

            $imgName = round(microtime(true)*1000).'.'.$newThumbnail->extension();
            $newThumbnail->storeAs('public/thumbnails', $imgName);
            $article->thumbnail = $imgName;

            if (!is_null($oldThumbnail))
                Storage::delete('public/thumbnails/'.$oldThumbnail);
        }

        $topicsIds = [];

        foreach($request->topics as $topic) {
            $checkTopic = Topic::find($topic);

            //check if is valid topic
            if (!$checkTopic || $checkTopic->status != 'ACCEPTED') {
                return redirect()->back()->withInput()->withErrors(['topics' => 'Invalid Topic: '.$topic]); 
            }
            array_push($topicsIds, $checkTopic->id);
        }

        $post->save();

        $article->save();

        $article->articleTopics()->sync($topicsIds);

        return redirect("/article/${id}");
    }


    public function delete(Request $request, int $id)
    {

        $article = Article::find($id);
        if(is_null($article))
            return redirect()->back()->withErrors(['article' => 'Article not found, id:'.$id]);

        $post = Post::find($article->post_id);
        if (is_null($post)) 
            return redirect()->back()->withErrors(['post' => 'Post not found, id:'.$id]);

        $this->authorize('delete', $post);

        $user = Auth::user();
        $owner_id = $post->author_id;

        $has_feedback = ($post->likes != 0 || $post->dislikes != 0);
        $has_comments = !$article->comments->isEmpty();

        if ($user->id != $owner_id && !$user->is_admin) {
            return redirect()->back()->withErrors(['user' => "Only the owner of the article can delete it"]);
        }

        if (($has_feedback || $has_comments) && !$user->is_admin) {
            // cannot delete if is not admin or it has feedback and comments
            return redirect()->back()->withErrors(['post' => "You can't delete an article with feedback"]);
        }

        $deleted = $article->delete();

        if ($deleted) 
            return redirect('/');
        else 
            return redirect("/article/${id}");
    }
}