<!doctype html>
<html lang='en'>

<head>
    <title>@yield('title', 'Release Calendar')</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href='/css/main.css' rel='stylesheet'>
    {{-- <script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> --}}
    @yield('head')
</head>

<body>

    {{-- Navigation bar --}}
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">Release Calendar</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                @if(!Auth::user())
                <li class="nav-item">
                    <a dusk="login-link" class="nav-link" href='/login'>Login</a>
                </li>
                <li class="nav-item">
                    <a dusk="register-link" class="nav-link" href='/register'>Register</a>
                </li>
                @else
                <li class="nav-item">
                    <a dusk="create-project-link" class="nav-link" href="/projects/create">Create Project</a>
                </li>
                <li class="nav-item">
                    <a dusk="create-release-link" class="nav-link" href="/releases/create">Create Release</a>
                </li>
                <li class="nav-item">
                    <form method='POST' id='logout' action='/logout'>
                        {{ csrf_field() }}
                        <a dusk="logout-link" class="nav-link" href='#' onClick='document.getElementById("logout").submit();'>Logout</a>
                    </form>
                </li>
                @endif
            </ul>
            <form class="form-inline my-2 my-lg-0 ml-auto">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
    </header>

    <main>
        <div class="container-fluid py-5 my-3">
            @yield('content')
        </div>
    </main>

</body>
</html>
