<h1>Comment Tree</h1>
<ul>
    @foreach ($comments as $comment)
        <li>
            {{ $comment->comment_author }}: {{ $comment->comment_content }}
            @if ($comment->children->count())
                <ul>
                    @foreach ($comment->children as $child)
                        <li>{{ $child->comment_author }}: {{ $child->comment_content }}</li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
{{ $comments->links() }}