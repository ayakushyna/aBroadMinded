<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/node_modules/normalize.css/normalize.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Laravel</title>
</head>
<body>
<div id="app">

</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
