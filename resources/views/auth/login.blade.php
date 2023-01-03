@extends('layouts.app')

@section('content')
<div class="border border-light border-2 bg-secondary text-center container mt-3" id="loginContainer">
    <h2 class="modal-title mx-auto text-center fw-bold my-4" id="exampleModalLabel">Log In</h2>
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
        @if ($errors->has('email'))
            <span class="error">
            {{ $errors->first('email') }}
            </span>
        @endif

        <label for="password" >Password</label>
        <input id="password" type="password" name="password" placeholder="Password" required>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>

        @if ($errors->has('is_suspended'))
            <div class="error text-danger text-center">
                {{ $errors->first('is_suspended') }} for the following reason:
            </div>
            <div class="error text-danger fw-bold fst-italic my-3">
                {{ $errors->first('reason') }}
            </div>
            <div class="error text-danger mb-3">
                You will be unsuspended on {{ $errors->first('endDate') }}
            </div>
        @endif

        <button type="submit">
            Login
        </button>
    </form>
</div>
@endsection
