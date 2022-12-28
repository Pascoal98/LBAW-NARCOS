<div class="card user-card d-flex flex-row flex-wrap mb-3 bg-secondary">
<div class="user-card-avatar card-block px-4 py-4 text-center">
        <a href="/user/{{ $user['id'] }}">
        <img src="{{
                isset($user['avatar']) ?
                asset('storage/avatars/'.$user['avatar']) : "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y="
            }}"
            onerror="this.src='{{ "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y="}}'"
            style="border-radius: 50%;"
        /> </a>
    </div>    
<div class="card-block user-card-body d-flex flex-column justify-content-center px-4 py-4">
        <h4 class="card-title mb-0">
            <a href="/user/{{ $user['id'] }}" class="purpleLink" >{{ $user['username'] }}</a>
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
