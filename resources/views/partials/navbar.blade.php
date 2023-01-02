<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbarContainer">
    <h1><a href="{{ url('/') }}">NARCOS</a></h1>
        @if (Auth::check())
        <a class="button" href="{{url('/user/'. Auth::id()) }}"> My Profile </a>
        <a class="button" href="{{ url('/logout') }}"> Logout </a>
        @else
        <a class="button" href="{{ url('/login') }}"> Login </a>
        <a class="button" href="{{ url('/register') }}"> Register </a>
        @endif

        <button class="navbar-toggler m-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse w-75" id="navbarSupportedContent">                
            <form id="searchForm" class="d-flex flex-row align-items-center border"
                action="{{ route('search') }}">
                <i class="fas fa-search ms-4 submit" type="submit"></i>
                <input class="form-control no-border flex-grow-1 my-0 ms-3 bg-dark" type="search"
                    placeholder="Search" name="query" autocomplete="off" value="{{ old('query') }}" />
                <input type="hidden" name="type" value="{{ old('type') ? old('type') : 'articles' }}" />

                <div class="dropdown" id="searchDropdown">
                    <button id="searchDropdownButton"
                        class="btn btn-outline-light border-start dropdown-toggle my-0 pe-0" type="button"
                        data-bs-toggle="dropdown">{{ old('type') == 'users' ? 'Users' : 'Articles' }}</button>
                    <ul class="dropdown-menu dropdown-menu-dark w-100 text-center"
                        aria-labelledby="searchDropdownButton">
                        <li><a class="dropdown-item dropdown-custom-item" onclick="setSearchType(this)">Articles</a>
                        </li>
                        <li><a class="dropdown-item dropdown-custom-item" onclick="setSearchType(this)">Users</a>
                        </li>
                    </ul>
                </div>
                
            </form>
            
        </div>           
           
 
        <div id="dropdownContainer" class="nav-item dropdown ms-5">
            <a class="dropdown-item dropdown-custom-item"
                 href="{{ url('/admin') }}">Admin Panel
            </a>    
        </div>

    </nav>
</header>
