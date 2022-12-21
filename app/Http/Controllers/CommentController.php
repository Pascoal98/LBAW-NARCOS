<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    
    public function create(Request $request)
    {
        $this->authorize('create', Content::class);

        $validator = Validator::make($request -> all(),
            [
                'body' => 'required|string|max:1000',
                'article_id' => 'required|exists:article,post_id',
                'parent_comment_id' => 'nullable|exists:comment,post_id'
            ]
        );
        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'Failed to create comment. Bad request',
                'errors' => $validator->errors(),
            ], 400);
        }

        $post = new Content;
        $post->body = $request->body;
        $post->author_id = Auth::id();
        $post->save();

        $comment = new Comment;
        $comment->post_id = $post->id;
        $comment->article_id = $request->article_id;

        $articleAuthor = Article::find($request->article_id)->author;
        $author_id = isset($articleAuthor) ? $articleAuthor->id : null;

        if (isset($request->parent_comment_id)) {
            $comment->parent_comment_id = $request->parent_comment_id;
            $parentAuthor = Comment::find($request->parent_comment_id)->author;
            $author_id = isset($parentAuthor) ? $parentAuthor->id : null;
        }

        $comment->save();
        // Refresh model instance
        $comment = Comment::find($post->id);


        return response()->json([
            'status' => 'OK',
            'msg' => 'Successfully created comment',
            'html' => view('partials.post.comment', [
                'comment' => $comment->getInfo(),
                'isReply' => isset($request->parent_comment_id),
            ])->render(),
        ], 200);
    }


    public function update(Request $request, int $id)
    {

        $comment = Comment::find($id);
        if (is_null($comment))
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Comment does not exist, id: '.$id,
                'errors' => ['Comment' => 'Comment does not exist, id: '.$id]
            ], 404);

        $post = Content::find($comment->post_id);
        if (is_null($post)) 
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Content does not exist, id: '.$id,
                'errors' => ['Content' => 'Content does not exist, id: '.$id]
            ], 404);

        $this->authorize('update', $post);

        $validator = Validator::make($request -> all(),
        [
            'body' => 'required|string|max:1000'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'Failed to update comment. Bad request',
                'errors' => $validator->errors(),
            ], 400);
        }

        $post->body = $request->body;
        $post->save();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Successfully updated comment',
            'body' => $request->body,
        ], 200);
    }

    /**
     * Deletes a Comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        $comment = Comment::find($id);
        if (is_null($comment))
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Comment does not exist, id: '.$id,
                'errors' => ['Comment' => 'Comment does not exist, id: '.$id]
            ], 404);

        $post = Content::find($comment->post_id);
        if (is_null($post)) 
            return response()->json([
                'status' => 'Not Found',
                'msg' => 'Content does not exist, id: '.$id,
                'errors' => ['Content' => 'Content does not exist, id: '.$id]
            ], 404);

        $this->authorize('delete', $post);

        $user = Auth::user();

        $has_feedback = ($post->likes != 0 || $post->dislikes != 0);
        $has_comments = !$comment->child_comments->isEmpty();

        if (($has_feedback || $has_comments) && !$user->is_admin) {
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'You can\'t delete a comment with feedback',
                'errors' => ['comment' => 'You can\'t delete a comment with feedback'],
            ], 403);
        }

        $deleted = $comment->delete();

        if (!$deleted)
            return response()->json([
                'status' => 'Internal Server Error',
                'msg' => 'There was an error deleting the comment with id ' . $id,
                'errors' => ['error' => 'There was an error deleting the comment with id ' . $id]
            ], 500);

        return response()->json([
            'status' => 'OK',
            'msg' => 'Successfully removed comment',
            'coment_id' => $id
        ], 200);
    }
}