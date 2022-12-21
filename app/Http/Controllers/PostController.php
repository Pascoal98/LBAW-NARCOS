<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Post;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function giveFeedback(Request $request, int $id)
    {
        $post = Post::find($id);
        if (is_null($post)) 
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Post not found, id: '.$id,
                'errors' => ['post' => 'post not found, id: '.$id]
            ], 404);

        $this->authorize('updateFeedback', $post);

        $feedback = Feedback::where('user_id', '=', Auth::id())->where('post_id', '=', $id)->first();

        if(!is_null($feedback)) {
            $deleted = $feedback->delete();

            if (!$deleted)
                return response()->json([
                    'status' => 'Internal Error',
                    'msg' => 'Could not rmeove feedback from post: '.$id,
                    'errors' => ['error' => 'Could not remove feedback from post: '.$id]
                ], 500);
        } 

        $feedback = new Feedback;
        $feedback->user_id = Auth::id();
        $feedback->post_id = $id;
        $feedback->is_like = $request->is_like;

        $feedback->save();

        $updatedPost = Post::find($id);

        $isArticle = Article::find($id) ? true : false;


        return response()->json([
            'status' => 'OK',
            'msg' => 'Successfully make feedback on post: '.$id,
            'likes' => $updatedPost->likes,
            'dislikes' => $updatedPost->dislikes,
            'is_like' => $feedback->is_like
        ], 200);
    }

    public function removeFeedback(Request $request, int $id)
    {   
        if (Auth::guest())
            return redirect('/login');

        $post = Post::find($id);
        if (is_null($post)) 
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Post not found, id: '.$id,
                'errors' => ['post' => 'post not found, id: '.$id]
            ], 404);

        $this->authorize('updateFeedback', $post);

        // buscar o feedback e remove-lo da base de dados
        $feedback = Feedback::where('user_id', '=', Auth::id())->where('post_id', '=', $id)->first();

        if(!is_null($feedback)) {
            $deleted = $feedback->delete();

            if (!$deleted)
                return response()->json([
                    'status' => 'Internal Error',
                    'msg' => 'Could not remove feedback from post: '.$id,
                    'errors' => ['error' => 'Could not remove feedback from post: '.$id]
                ], 500);
            else {
                $post = Post::find($id);
            }
        }

        return response()->json([
            'status' => 'OK',
            'msg' => 'Feedback was already deleted from post: '.$id,
            'likes' => $post->likes,
            'dislikes' => $post->dislikes,
            'is_like' => $feedback->is_like
        ], 200);
    }
}