@extends('layouts.app')


@section('title', "Article")

@section('article')
<div class="d-flex justify-content-between align-items-center flex-row">
    @php
        $article_published_at = date('F j, Y', /*, g:i a',*/ strtotime($article['published_at']));
    @endphp
    <i id="publishedAt">{{ $article_published_at }}</i>

    @if ($isAuthor || $isAdmin)
        <div id="articleButtons" class="d-flex align-items-center">
        @if ($isAuthor)
            <a id="editArticleButton" href="{{ route('editArticle', ['id' => $article['id']])}}"
                class="fas fa-edit fa-2x article-button darkPurpleLink me-4"
                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Article">
            </a>
        @endif

        @if (!$hasFeedback || $isAdmin)
            <form name="deleteArticleForm" id="deleteArticleForm" method="POST"
                action="{{ route('article', ['id' => $article['id']]) }}">
                @csrf
                @method('DELETE')
            </form>
            <button
                id="delete_content_{{$article['id']}}"
                type="button"
                onclick="confirmAction('#delete_content_{{$article['id']}}', () => document.deleteArticleForm.submit())"
                class="btn btn-transparent my-0"
                >
                <i class="fas fa-trash fa-2x article-button text-danger mt-2"
                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Remove Article"></i>
            </button>
        @endif
        </div>
    @endif
</div>
@endsection
