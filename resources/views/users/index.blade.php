<h1>Users</h1>
<ul>
    @foreach ($users as $user)
        <li>
            {{ $user->display_name }} ({{ $user->user_email }})
            <ul>
                <li>Roles: {{ implode(', ', $user->roles) }}</li>
            </ul>
        </li>
        
    @endforeach
</ul>
{{ $users->links() }}