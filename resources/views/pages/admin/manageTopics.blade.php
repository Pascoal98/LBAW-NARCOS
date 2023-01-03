@extends('layouts.app')

<script type="text/javascript" src="{{ asset('js/topics.js') }}"></script>

@section('title', "- Manage topics")

@section('content')

<div class="text-center container">
    <h1 class="text-center mt-5">Manage topics</h1>
    <div class="mb-5 row">

        <div class="px-2 mt-5 col-12 col-lg-4">
            <div class="border bg-dark statusContainer" id="acceptedTopicsContainer">
                <h3 class="mt-5">Accepted topics</h3>
                @foreach ($topics_accepted as $topic)
                    <div class="mt-5 pb-3 pt-5 bg-dark mb-5 manageTopicContainer">
                        <div id="stateButton" class="d-flex align-items-center">
                            <h5 class="mx-3 my-0 py-0 w-75">{{ $topic['subject'] }}</h5>
                            <button type="button" onclick="removeTopic(this, {{ $topic['id'] }})" class="my-0 py-0 btn btn-lg btn-transparent">
                                <i class="fas fa-trash fa-2x mb-2 text-danger"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="px-2 mt-5 col-12 col-lg-4">
            <div class="border bg-dark statusContainer" id="pendingTopicsContainer">
                <h3 class="mt-5">Pending topics</h3>
                @foreach ($topics_pending as $topic)
                    <div class="mt-5 pb-3 pt-5 bg-dark mb-5 managetopicContainer">
                        <div id="stateButton" class="d-flex align-items-center">
                            <h5 class="mx-3 my-0 py-0 w-75">{{ $topic['subject'] }}</h5>
                            <button type="button" onclick="acceptTopic(this, {{ $topic['id'] }})" class="my-0 py-0 btn btn-lg btn-transparent">
                                <i class="fas fa-check fa-2x mb-2 text-success"></i>
                            </button>
                            <button type="button" onclick="rejectTopic(this, {{ $topic['id'] }})" class="my-0 mx-1 py-0 btn btn-lg btn-tranparent">
                                <i class="fas fa-times fa-2x mb-2 text-danger"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="px-2 mt-5 col-12 col-lg-4">
            <div class="border bg-dark statusContainer" id="rejectTopicsContainer">
                <h3 class="mt-5">Rejected topics</h3>
                @foreach ($topics_rejected as $topic)
                    <div class="mt-5 pb-3 pt-5 bg-dark mb-5 managetopicContainer">
                        <div id="stateButton" class="d-flex align-items-center">
                            <h5 class="mx-3 my-0 py-0 w-75">{{ $topic['subject'] }}</h5>
                            <button type="button" onclick="acceptTopic(this, {{ $topic['id'] }})" class="my-0 py-0 btn btn-lg btn-transparent">
                                <i class="fas fa-check fa-2x mb-2 text-success"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection