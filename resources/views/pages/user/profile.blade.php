@extends('layouts.app')

@php
$guest = !Auth::check();
@endphp

<script type="text/javascript" src="{{ asset('js/user.js') }}"></script>

@section('title', "- User Profile")

{{-- ------------------------------------------------------------------------------------ --}}
@section('userInfo')
    <section id="userInfo">
        <div class="container-fluid py-3">
            <div class="row w-100 mt-4 mt-lg-5" id="userGraphics">
            <div class="col-5 col-lg-6 d-flex justify-content-center align-items-center h-100">
                    <img src="{{ isset($user['avatar']) ? asset('storage/' . $user['avatar']) : "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y=" }}"
                        id="avatarImg" onerror="this.src='{{ "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y=" }}'" alt="User Avatar" />

                </div>
                <div class="col-7 col-lg-6 d-flex flex-column align-items-center h-100">
                </div>
            </div>
            <div class="row w-100 my-4 mt-lg-5">
                <div class="col-5 col-lg-6 d-flex justify-content-center align-items-center position-relative">
                    <h2 class="text-center my-0 py-0">{{ $user['username'] }}</h2>
                </div>
                <div class="col-7 col-lg-6 d-flex justify-content-center align-items-center">
                    @if ($isOwner)
                        <button type="button" class="btn btn-outline-primary"title="Edit Profile">
                            <a class="fa fa-pencil" href="/user/{{ $user['id'] }}/edit"> Edit Profile</a>
                        </button>
                        <form method="GET" class="m-0 p-0 mx-0 mx-lg-3" action="{{ route('followedUsers', $user['id']) }}">
                            <button type="submit" class="btn btn-outline-primary" >
                                Followed Users
                            </button>
                        </form>
                        
                    @else
                        @if (!$guest)
                            @if ($follows)
                                <button type="button" class="btn btn-secondary px-lg-5 my-0 py-0 mx-3" id="followBtn"
                                    onclick="unfollowUser({{ $user['id'] }})">Unfollow</button>
                            @else
                                <button type="button" class="btn btn-primary px-lg-5 my-0 py-0 mx-3" id="followBtn"
                                    onclick="followUser({{ $user['id'] }})">Follow</button>
                            @endif
                        @endif
                    @endif
                    <p class="user-card-description mt-4 mb-4">Reputation: {{ $user['reputation'] }}</p>

                    <i class="fa fa-users font-2x mx-3 text-primary"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Follower Count"></i>
                    <p class="h5 text-center py-0 my-0" id="followersCount">{{ $followerCount }}</p>
                </div>
            </div>
            <div class="row w-100 my-2">
                <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center my-3">
                        <i class="fa fa-birthday-cake me-3 fa-1x" onclick="console.log('cliked')"></i>
                        <h5 class="mb-0">{{ $date_of_birth . ' (' . $age . ')' }}</h5>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center mt-2 mt-lg-0">
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('articles')
    <section class="container-fluid w-100 d-flex flex-column align-items-center my-2 ">
        <div class="position-relative w-100 d-flex justify-content-center align-items-center mb-2 mb-lg-4" id="userArticles">
            <h2 class="border-bottom border-2 border-light text-center pb-2" id="articlesTitle">Articles</h2>
        </div>
        <div id="articles">
            @if ($articles->isEmpty()) 
                <div class="alert alert-secondary mb-0 text-center mb-5" role="alert">
                    <h3 class="my-3 text-white">User didn't post any Article</h3>
                </div>
            @endif
            @include('partials.post.articles', ['articles' => $articles])
        </div>
    </section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('load-more')
    <div id="load-more">

        <button onclick="loadMoreUser({{ Auth::id() }})">Load more</button>

    </div>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}


@section('report')
<div onclick="report()"></div>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div id="reportInsideContainer" class="d-flex flex-column align-items-center justify-content-evenly">
                <h3 class="mt-4 mt-lg-0">Give us a reason to report this user</h3>
                <div class="text-danger d-flex d-none py-0 my-0 align-items-center text-center px-5" id="reportError">
                    <i class="fa fa-exclamation me-3 fa-1x"></i>
                    <h5 class="py-0 my-0" id="reportErrorText"></h5>
                </div>
                <form id="reportform" class="d-flex flex-row mb-0" onsubmit="reportUser({{ $user['id'] }})">
                    <input id="reason" class="customInput" type="text" name="reason" placeholder="Insert report reason here" required>

                    <button class="btn btn-purple btn-lg customBtn">Submit</button>
                </form>
            </div>
        </div>
@endsection

@section('content')
    <div id="userProfileContainer" class="d-flex flex-column">
        @yield('userInfo')
        @yield('articles')
        @if ($canLoadMore)
            @yield('load-more')

        @endif
        @yield('report')

    </div>
@endsection
