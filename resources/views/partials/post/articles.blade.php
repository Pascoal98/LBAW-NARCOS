@foreach($articles as $article)
    @include('partials.post.article', ['article' => $article])
@endforeach