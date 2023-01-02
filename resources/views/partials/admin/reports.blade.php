<div>

    <div class="accordion-item">

        <h2 class="accordion-header my-4" id="heading{{ $report['id'] }}">
            <button class="accordion-button collapsed my-0 py-0" 
                type="button" data-bs-toggle="collapse" data-bs-target="#report-{{ $report['id'] }}"
                aria-expanded="false" aria-controls="report-{{ $report['id'] }}">

                {{ $report['reported_id']['username'] }}
            </button>
        </h2>

        <div id="report-{{ $report['id'] }}" class="collapse border-secondary border-top border-bottom mb-5" 
            aria-labelledby="{{ $report['id'] }}" data-bs-parent="#accordionElement">

            <div class="accordion-body">
                <br>
                <p class="my-0 py-0">
                    Reason: {{ $report['reason'] }}
                </p>
                <p class="my-0 py-0">
                    Reporter:
                    @if (isset($report['reporter']))
                        <a href="/user/{{ $report['reporter']['id'] }}">
                            {{ $report['reporter']['username'] }}
                        </a>
                    @else
                        Reporter account was deleted
                    @endif
                </p>
                <p class="my-0 py-0">
                    Date: {{ $report['reported_at'] }}
                </p>
                <hr>

                <a href="/user/{{ $report['reported_id']['id'] }}" class="my-0">
                    <div class="text-center">
                        <img class="w-25" src="{{ 
                            isset($report['reported_id']['avatar']) 
                            ? asset('storage/avatars/' . $report['reported_id']['avatar']) 
                            : "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y=" 
                            }}"
                            alt="Reported User Avatar"
                            id="avatarImg" onerror="this.src='{{ "https://media.istockphoto.com/id/1142192548/vector/man-avatar-profile-male-face-silhouette-or-icon-isolated-on-white-background-vector.jpg?b=1&s=170667a&w=0&k=20&c=X33UQb6kE2ywnnbi0ZinZh_CnCZaPBCguqQayGlD99Y=" }}'" />
                        
                        <p> {{ $report['reported_id']['username'] }} </p>
                    </div>
                </a>
                
                @if ($report['reported_id']['is_suspended'] && $report['is_closed'] )
                    <button onclick="unsuspendUser(this, {{ $report['reported_id']['id'] }}, {{ $report['id'] }})" type="button" 
                        class="my-0 py-0 btn btn-lg btn-secondary">
                        Unsuspend User
                    </button>
                @else
                    @if (!$report['is_closed'])
                        <button id="suspendUserBtn" onclick="toggleSuspendPopup({{ $report['reported_id']['id'] }}, {{ $report['id'] }})" type="button" 
                            class="mt-4 my-0 py-0 btn btn-lg btn-secondary">
                            Suspend User
                        </button>
                    @endif
                @endif

                @if ($report['is_closed'] == 0)
                    <button onclick="closeReport(this, {{ $report['id'] }})" type="button" 
                        class="mt-4 my-0 py-0 btn btn-lg btn-secondary" id="closeReport-{{ $report['id'] }}">
                        Close Report
                    </button>
                @endif  

            </div>
        </div>
    </div>
</div>