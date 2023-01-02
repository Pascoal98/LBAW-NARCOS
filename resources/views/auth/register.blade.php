@extends('layouts.app')

@section('content')
<div class="border border-light text-center border-3 bg-secondary container-fluid mt-4 mb-5" id="registerContainer">
    <h2 class="modal-titlemx-auto text-center fw-bold mt-4" id="exampleModalLabel">Register</h2>
  <form method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}

      <label for="username">Username</label>
      <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
      @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
      @endif

      <label for="email">E-Mail Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif

      <label for="password">Password</label>
      <input id="password" type="password" name="password" placeholder="Password" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>

      <label for="date_of_birth">Date of birth</label>
      <input id="date_of_birth" type="text" name="date_of_birth" placeholder="Confirm Password" required>
      @if ($errors->has('date_of_birth'))
        <span class="error">
            {{ $errors->first('date_of_birth') }}
        </span>
      @endif
      <button type="submit">
        Register
      </button>
  </form>
</div>
@endsection
