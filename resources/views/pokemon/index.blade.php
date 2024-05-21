<!DOCTYPE html>
<html>
<head>
    <title>Search App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        <livesearch-pokemon></livesearch-pokemon>
    </div>

    @vite('resources/js/app.js')
</body>
</html>