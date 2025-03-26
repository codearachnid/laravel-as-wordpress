<h1>Comments</h1>
<ul>
    @foreach ($comments as $comment)
        <li>
            {{ $comment->comment_author }} said:
            <p>{{ $comment->comment_content }}</p>
            <small>On: {{ $comment->comment_date }} | Status: {{ $comment->comment_approved }}</small>
            @if ($comment->post)
                <p>Post: {{ $comment->post->post_title }}</p>
            @endif
            @if ($comment->user)
                <p>User: {{ $comment->user->display_name }}</p>
            @endif
        </li>
    @endforeach
</ul>
{{ $comments->links() }}