@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/suspensions.js') }}"></script>
@endsection

@section('title', "- Suspensions")

@section('content')

    <div class="text-center container">
        
        <h1 class="text-center mt-5">Users Suspensions</h1>

        <div class="accordion border my-5 statusContainer" id="accordionElement">

            @foreach ($suspendedUsers as $user)
                <div class="bg-dark">

                    <div class="accordion-item" id="susContainer">

                        <h2 class="accordion-header my-4" id="heading{{$user['id']}}">
                            <button class="accordion-button collapsed my-0 py-0" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#user{{$user['id']}}" aria-expanded="false" 
                                aria-controls="user{{$user['id']}}">
                                {{ $user['username'] }}
                            </button>
                        </h2>

                        <div id="user{{$user['id']}}" class="collapse border-secondary border-top border-bottom mb-5" 
                            aria-labelledby="heading{{$user['id']}}" data-bs-parent="#accordionElement">                   
                            <div class="accordion-body">
                                <br>
                                @foreach ($user['history'] as $suspension) 
                                    From: {{ $suspension['start_time'] }} 
                                    <br>
                                    To: {{ $suspension['end_time'] }}
                                    <br>
                                    Reason: {{ $suspension['reason'] }}
                                    <br>
                                    Admin:

                                    @if (isset($suspension['admin']))
                                        <a href="/user/{{ $suspension['admin']['id'] }}">
                                            {{ $suspension['admin']['username'] }}
                                        </a>
                                    @else 
                                        Admin account was deleted
                                    @endif

                                    <hr>
                                @endforeach
                                
                                <button onclick="unsuspendUser(this, {{ $user['id'] }})" type="button" 
                                    class="my-0 py-0 btn btn-lg">
                                    Unsuspend
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            @endforeach

        </div>
        
    </div>

@endsection