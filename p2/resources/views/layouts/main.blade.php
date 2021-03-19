<!doctype html>
<html lang='en'>

<head>
    <title>@yield('title', 'Retirement Calculator')</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href='/css/home.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    @yield('head')
</head>

<body class="mt-5">
    <div class="container">
        @yield('content')
    </div>
    <footer class="footer bg-light text-muted px-3">
        Privacy Policy: This website does not store data on the server and does not share data with others.
    </footer>

</body>
</html>
