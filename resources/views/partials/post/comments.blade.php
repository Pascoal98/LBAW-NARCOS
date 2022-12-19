@foreach ($comments as $comment)
    @include('partials.post.comment', ['comment' => $comment, 'isReply' => false])

    @foreach ($comment['children'] as $child)
        @include('partials.post.comment', ['comment' => $child, 'isReply' => true])
    @endforeach

@endforeach