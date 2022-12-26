@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('js/select2topics.js') }}"></script>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('articles')
    <section id="articles" class="container-fluid">

    <div class="d-none d-lg-flex justify-content-end align-items-center position-relative" id="userSectionNav">
        @if (Auth::check())
            <label data-bs-toggle="tooltip" data-bs-placement="bottom" title="Create an Article"
                for="createArticleIcon">
                    <a id="createArticleIcon" class="nav-item mx-4" href="{{ route('createArticle') }}">
                        <i class="purpleLink fas fa-plus-circle fa-3x"></i>
                    </a> Create Article
            </label>
        @endif

        @if ($articles->isEmpty())
            <div class="alert alert-custom mb-4 text-center" role="alert">
                <h3 class="my-3">No results found</h3>
            </div>  
        @endif

        @include('partials.post.articles', ['articles' => $articles])
    </section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('content')
    @yield('articles')

@endsection