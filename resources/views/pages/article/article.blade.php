@extends('layouts.app')

    <script type="text/javascript" src="{{ asset('js/comments.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('js/post.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>


@section('title', "- Article")


@section('article')
    <div class="article-container h-100 container-fluid bg-dark rounded mt-3 mb-5">

        <div id="articleContentContainer" class="d-flex flex-row my-2 h-100 position-relative">
            
            <div class="articleInfoContainer d-flex flex-column p-3 mb-0 text-white" >

                <div class="flex-row h1" id="articleTitle">
                    {{ $article['title'] }}
                </div>

                <div class="d-flex justify-content-between align-items-center flex-row">
                    @php
                        $article_published_date = date('F j, Y', /*, g:i a',*/ strtotime($article['published_date']));
                    @endphp
                    <i id="publishedAt">{{ $article_published_date }}</i>                      


                    @if ($is_author || $is_admin)
                        <div id="articleButtons" class="d-flex align-items-center">
                            @if ($is_author)
                                <a id="editArticleButton" href="{{ route('editArticle', ['id' => $article['id']])}}"
                                    class="fas fa-edit fa-2x article-button darkPurpleLink me-4"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Article">
                                </a>
                            @endif

                            @if (!$hasFeedback || $is_admin)
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
                                > Delete
                                    <i class="fas fa-trash fa-2x article-button text-danger mt-2"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Remove Article"></i>
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                <a href="{{ route('userProfile', ['id' => $author['id']]) }}">
                        {{ $author['username'] }}
                </a> 

                <p class="flex-row mt-3 mb-1">

                    @foreach ($topics as $topic)
                        @include('partials.topic', ['topic' => $topic ])
                    @endforeach

                    @if ( $is_author )
                        <i class="fas fa-thumbs-up ps-5"  id="articleLikes"> 
                            <span class="ms-1">{{ $article['likes'] }}</span>
                        </i>

                        <i class="fas fa-thumbs-down ps-3" id="articleDislikes"> 
                            <span class="ms-1">{{ $article['dislikes'] }}<span>
                        </i>

                    @else
                        @if ( $liked )
                            <i class="fas fa-thumbs-up ps-5 purpleLink feedbackIcon"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Like"
                                onclick="removeFeedback(this, {{ $article['id'] }}, true, false)"
                                > 
                                <span class="ms-1">{{ $article['likes'] }}</span>
                            </i>
                        @else 
                            <i class="fas fa-thumbs-up ps-5 purpleLink feedbackIcon" 
                                id="articleLikes"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Like"
                                onclick="giveFeedback(this, {{ $article['id'] }}, true, false)"> 
                                <span class="ms-1">{{ $article['likes'] }}</span>
                            </i>
                        @endif

                        @if ($disliked)
                            <i class="fas fa-thumbs-down ps-3 purpleLink feedbackIcon" id="articleDislikes"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Dislike"
                            onclick="removeFeedback(this, {{ $article['id'] }}, false, false)"> 
                                <span class="ms-1">{{ $article['dislikes'] }}</span>
                            </i>
                        @else
                            <i class="fas fa-thumbs-down ps-3 purpleLink feedbackIcon" id="articleDislikes"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Dislike"
                            onclick="giveFeedback(this, {{ $article['id'] }}, false, false)"> 
                                <span class="ms-1">{{ $article['dislikes'] }}<span>
                            </i>
                        @endif
                    @endif

                    @if ($article['is_edited'])
                        <b><i class="ms-4 text-lightPurple">Edited</i></b>
                    @endif
                </p>

                @if ($errors->has('article'))
                    <p class="text-danger my-4">{{ $errors->first('article') }}</p>
                @endif
                @if ($errors->has('content'))
                    <p class="text-danger my-4">{{ $errors->first('content') }}</p>
                @endif
                @if ($errors->has('user'))
                    <p class="text-danger my-4">{{ $errors->first('user') }}</p>
                @endif


                <div id="articleBody" class="flex-row h-75">
                    {!! $article['body'] !!}
                </div>

            </div>

        </div>


        <div class="d-flex flex-column" id="comments-section">

            @if (!$comments->isEmpty() || Auth::check())
                <div class="flex-row my-3 p-0">
                    <h3 class="m-0">Comments</h3>
                </div>
            @endif

            <div class="h-50">
                @if (Auth::check())
                    <div class="d-flex flex-row my-3" id="articleCommentsContainer">
                    <div class="flex-column h-100 commentHeader mx-3 mx-lg-5">
                            <img src="{{ isset(Auth::user()->avatar) ? asset('storage/' . Auth::user()->avatar) : "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y=" }}"
                                onerror="this.src='{{ "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y=" }}'" alt="Your Avatar">
                            <p>You</p>
                        </div>
                        <div id="comment_form" class="flex-column w-100 m-0">
                            <textarea id="commentTextArea" class="flex-column border-light m-0 p-2" placeholder="Type here"></textarea>
                            <button id="newCommentButton"
                                class="btn btn-primary px-4"
                                onclick="createNewComment({{ $article['id'] }})">
                                Comment
                            </button>
                        </div>
                    </div>
                @endif

                <div id="comments">
                    @include('partials.post.comments', ['comments' => $comments])
                </div>

                @if ($canLoadMore)
                <div id="load-more" class="w-75 my-3">
                    <button onclick="loadMoreComments({{ $article['id'] }})">Load more</button>
                </div>
                @endif

            </div>

        </div>
    </div>
@endsection

@section('content')

    @yield('article')
@endsection