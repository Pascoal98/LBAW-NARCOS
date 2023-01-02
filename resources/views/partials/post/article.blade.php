<div class="card flex-row flex-wrap bg-secondary">
    <div class="card-header border-0 h-100 bg-transparent">
        <img class="squareImage" alt="Article Thumbnail" src="{{
            isset($article['thumbnail']) ?
            asset('storage/'.$article['thumbnail'])
            :
            "https://media.istockphoto.com/id/882917690/pt/vetorial/pencil-with-paper-icon.jpg?s=612x612&w=0&k=20&c=2kaEvuyvDPWPPyW8zIGVQVyGMDXrlfOFXMxOaKvwI1Y="
        }}" onerror="this.src='{{ "https://media.istockphoto.com/id/882917690/pt/vetorial/pencil-with-paper-icon.jpg?s=612x612&w=0&k=20&c=2kaEvuyvDPWPPyW8zIGVQVyGMDXrlfOFXMxOaKvwI1Y=" }}'">
    </div>

    <a href="/article/{{ $article['id'] }}" class="h-100">
        <div class="card-block d-flex flex-column px-2 h-100 py-2">
            <h4 class="card-title text-truncate pb-4 my-0">
                {{ $article['title'] }}
            </h4>

            <span class="card-text"> 
                <i class="far fa-clock pe-2"> 
                    @php
                        $time = date('F j, Y', /*, g:i a',*/ strtotime( $article['published_date'] ) )
                    @endphp
                    {{ $time }}
                </i>

                <i class="fa fa-thumbs-up ms-3 me-2"> Likes: {{ $article['likes'] }}</i>
                <i class="fa fa-thumbs-down"> Dislikes: {{ $article['dislikes'] }}</i>
            </span>

            <p class="card-text text-light-white text-wrap overflow-hidden h-100">
                {!! mb_strimwidth(str_replace("&nbsp;", " ", strip_tags($article['body'])), 0, 500, "...") !!}
            </p>
        </div>
    </a>
    
</div>