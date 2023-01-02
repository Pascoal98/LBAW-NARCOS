@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <script type="text/javascript" src="{{ asset('js/select2topics.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/topics.js') }}"></script>
@endsection

@section('filters')
    <section>
        <div id="filterSection" class="d-none d-lg-flex flex-row align-items-center border border-light rounded-pill py-4 px-2 mt-3 mb-4 overflow-hidden">
            @if (Auth::check())
                <label data-bs-toggle="tooltip" data-bs-placement="bottom" title="Create an Article"
                    for="createArticleIcon">
                        <a id="createArticleIcon" class="nav-item mx-4" href="{{ route('createArticle') }}">
                            <i class="purpleLink fas fa-plus-circle fa-3x"></i>
                        </a>
                </label>
            @endif
            <div class="btn-group btn-group-toggle me-auto" data-toggle="buttons">
                @if (Auth::check())
                    <input type="radio" class="btn-check" name="filterType" id="recommended" autocomplete="off" checked>
                    <label data-bs-toggle="tooltip" data-bs-placement="bottom" title="From your favorite authors and topics"
                        class="filter-button btn btn-outline-warning text-light btn-lg ms-4 my-auto" for="recommended">
                    <i class="far fa-star mt-2 text-warning"></i>
                    <span class="mx-2">Recommended</span>
                    </label>
                @endif

                <input type="radio" class="btn-check" name="filterType" id="recent" autocomplete="off">
                <label data-bs-toggle="tooltip" data-bs-placement="bottom" title="The latest articles"
                    class="filter-button btn btn-outline-info text-light btn-lg ms-4 my-auto" for="recent">
                    <i class="fas fa-history mt-2 text-info"></i> 
                    <span class="mx-2">Recent</span>
                </label>
            </div>
            <select id="filterTopics" multiple>
                @foreach($topics as $topic)
                    <option value="{{ $topic['id'] }}">
                        {{ $topic['subject'] }}
                    </option>
                @endforeach
            </select>
            <i class="fa fa-feed filter-tag mx-4 text-lightRed my-auto"></i>
        </div>
</section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('articles')
    <section id="articles" class="container-fluid">

        @if ($articles->isEmpty())
            <div class="alert alert-custom mb-4 text-center" role="alert">
                <h3 class="my-3">No results found</h3>
            </div>  
        @endif
        @include('partials.post.articles', ['articles' => $articles])
    </section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('propose-topic')
    <section class="home-section d-flex flex-column align-items-center mt-5 bg-secondary">
        <div class="d-flex flex-grow-1 justify-content-center home-container">
            <div id="propose_Topic" class="position-relative d-flex flex-column align-items-center">
                <h1 class="mb-2">
                    Propose a new Topic
                </h1>
                <h4 class="mb-5 text-light"> Let us know what new topic you want to add!</h4>

                <form id="proposeTopicForm" class="d-flex flex-row mb-0" onsubmit="proposeTopic(event)">
                    <input id="topic-name" class="customInput" type="text" name="topicName" placeholder="Enter your topic" required>

                    <button class="btn btn-purple btn-lg customBtn ms-4" type="submit"> Propose </button>
                </form>
            </div>
        </div>
    </section>

@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('content')
    @yield('filters')
    @yield('articles')

    @yield('propose-topic')
@endsection