<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('layout.header')

    @yield('cssku')
</head>
<body style="margin:15px">

    @yield('content')

    @include('layout.script')
</body>
</html>
