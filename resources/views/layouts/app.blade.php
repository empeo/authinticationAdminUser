<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/style/bootstrap.min.css') }}">
</head>
<body>
    @include('layouts.navbar')
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('assets/dynamic/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
