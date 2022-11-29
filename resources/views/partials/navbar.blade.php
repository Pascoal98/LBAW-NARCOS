<header>
    <nav>
    <h1><a href="{{ url('/') }}">NARCOS</a></h1>
        @if (Auth::check())
        <a class="button" href="{{url('/user/'. Auth::id()) }}"> My Profile </a>
        <a class="button" href="{{ url('/logout') }}"> Logout </a>
        @else
        <a class="button" href="{{ url('/login') }}"> Login </a>
        <a class="button" href="{{ url('/register') }}"> Register </a>
        @endif
    </nav>
</header>
