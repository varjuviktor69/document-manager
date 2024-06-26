<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Manager</title>

    <link rel="stylesheet" href="{{ URL::asset('css/app.css') . env('STATIC_FILE_VERSION') }}">
    @yield('extraStyles')
</head>
<body>
    @yield('content')

    <script src="{{ URL::asset('js/global.js') . env('STATIC_FILE_VERSION') }}"></script>
    <script src="{{ URL::asset('js/ajax-form.js') . env('STATIC_FILE_VERSION') }}"></script>
    @yield('extraScripts')
</body>
</html>