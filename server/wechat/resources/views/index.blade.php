<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>index</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div id="app">
</div>
<script src="{{ asset('js/app.js?time=' . time() ) }}"></script>
</body>
</html>
