<div class="card user-card d-flex flex-row flex-wrap mb-3 bg-secondary">
    <div class="card-block user-card-body d-flex flex-column justify-content-center px-4 py-4">
        <h4 class="card-title mb-0">
            <a href="/user/{{ $user['id'] }}" class="purpleLink" >{{ $user['name'] }}</a>
        </h4>

        @if (!Auth::guest() && $user['id'] != Auth::id())
            @if ($user['followed'])
                <div class="w-25 mb-2">
                    <button type="button" class="btn btn-primary my-0 py-0 me-3" id="followBtn"
                        onclick="shortcutUnfollowUser(this, {{ $user['id'] }})">Following</button>
                </div>
            @else
                <div class="w-25 mb-2">
                    <button type="button" class="btn btn-primary my-0 py-0 me-3" id="followBtn"
                        onclick="shortcutFollowUser(this, {{ $user['id'] }})">Follow</button>
                </div>
            @endif
        @endif

    </div>

    <div class="card-block user-card-right d-flex flex-column align-items-center justify-content-start py-4">
        @if ($user['isAdmin'])
            <span class="badge rounded-pill bg-custom mt-4 mb-4"> Admin </span>
        @endif

        <p class="user-card-description mt-4 mb-4">Reputation: {{ $user['reputation'] }}</p>

    </div>
    
</div>
