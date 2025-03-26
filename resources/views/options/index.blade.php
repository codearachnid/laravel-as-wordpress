<h1>WordPress Options</h1>
<ul>
    <li>Site Title: {{ $siteTitle }}</li>
    <li>Test Option: {{ json_encode($testOption) }}</li>
    <li>New Option: {{ $newOption }}</li>
</ul>
<h2>Autoloaded Options</h2>
<ul>
    @foreach ($autoloaded as $name => $value)
        <li>{{ $name }}: {{ is_array($value) ? json_encode($value) : $value }}</li>
    @endforeach
</ul>