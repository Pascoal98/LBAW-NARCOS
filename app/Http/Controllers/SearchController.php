<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SearchController extends Controller
{
    private const SEARCH_LIMIT = 5;

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', Rule::in(['articles', 'users'])],
            'query' => 'required|string',
        ]);


        if ($validator->fails())
            return response()->view('pages.search', [
                'errors' => $validator->errors()
            ])->setStatusCode(400);

        if ($request->type === 'articles')
            $search = $this->getArticleSearch($request->input('query'), 0, $this::SEARCH_LIMIT);
        else if ($request->type === 'users')
            $search = $this->getUserSearch($request->input('query'), 0, $this::SEARCH_LIMIT);
        return view('pages.search', [
            'type' => $request->type,
            'query' => $request->input('query'),
            'results' => $search['results'],
        ]);
    }

    public function searchUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string',
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'Failed to search users. Bad request',
                'errors' => $validator->errors(),
            ], 400);

        $search = $this->getUserSearch($request->value, $request->offset, $request->limit);

        return response()->json([
            'html' => view('partials.user.list', [ 'users' => $search['results'] ])->render()
        ], 200);
    }

    public function searchArticles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string',
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => 'Bad Request',
                'msg' => 'Failed to search articles. Bad request',
                'errors' => $validator->errors(),
            ], 400);

        $search = $this->getArticleSearch($request->value, $request->offset, $request->limit);

        return response()->json([
            'html' => view('partials.post.articles', [ 'articles' => $search['results'] ])->render()
        ], 200);
    }

    private function getUserSearch(string $value, $offset = 0, $limit = null)
    {
        $rawUsers = User::whereRaw('tsvectors @@ plainto_tsquery(\'english\', ?)', [$value])
            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$value])
            ->get()->skip($offset);

        $rawUsers = $rawUsers->take($limit);


        $users = $rawUsers->map(function ($user) {
            
            $followed = !Auth::guest() ? Auth::user()->isFollowing($user->id) : false;

            return [
                'id' => $user->id,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'reputation' => $user->reputation,
                'is_admin' => $user->is_admin,
                'followed' => $followed,
            ];
        });

        return [
            'results' => $users,
        ];
    }

    private function getArticleSearch(string $value, $offset = 0, $limit = null)
    {
        $rawArticles = Article::whereRaw('tsvectors @@ plainto_tsquery(\'english\', ?)', [$value])
            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$value])
            ->get()->skip($offset);

        $rawArticles = $rawArticles->take($limit);

        $articles = $rawArticles->map(fn ($article) => $article
            ->only('id', 'title', 'thumbnail', 'body', 'published_date', 'likes', 'dislikes'));

        return [
            'results' => $articles,
        ];
    }
}