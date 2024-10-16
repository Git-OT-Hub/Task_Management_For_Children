<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('layout.name', 'My_Laravel_Project') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <header class="custom-main-color">
            <nav class="navbar navbar-expand-md shadow">
                <div class="container-fluid">
                    <img src="{{ asset('images/test_header_icon.png') }}" alt="" width="80" height="60">
                    <a class="navbar-brand px-3" href="{{ url('/') }}">
                        {{ config('layout.name', 'My_Laravel_Project') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse mt-3 mt-md-0" id="navbarSupportedContent">
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-3 ms-md-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket fa-2x"></i></a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item ms-0 ms-md-3">
                                        <a class="nav-link" href="{{ route('register') }}"><i class="fa-solid fa-user-plus fa-2x"></i></a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="custom-footer-color p-3">
            <div><a href="{{ url('/') }}">My_Laravel_Project について</a></div>
            <div class="mt-2"><a href="#">お問い合わせ</a></div>
            <div class="mt-2"><small>c 2024 My_Laravel_Project All Rights Reserved</small></div>
        </footer>
    </div>
</body>
</html>
