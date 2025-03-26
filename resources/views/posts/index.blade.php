<h1>Posts</h1>
<ul>
    @foreach ($posts as $post)
        <li>
            {{ $post->post_title }} ({{ $post->post_status }})
            <h2>Postmeta</h2>
            <ul>
                @foreach ($post->meta as $meta)
                    <li>{{ $meta->meta_key }}: {{ $meta->meta_value }}</li>
                @endforeach
            </ul>
            <h2>Taxonomy</h2>
            <ul>
                @foreach ($post->taxonomies as $taxonomy)
                    <li>{{ $taxonomy->taxonomy }}: {{ $taxonomy->term->name }}</li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
{{ $posts->links() }}