<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="sticky-top">
            <header class="custom-main-color shadow">
                <nav class="navbar navbar-expand-md">
                    <div class="container-fluid">
                        <img src="{{ asset('images/test_header_icon.png') }}" alt="" width="80" height="60">
                        <a class="navbar-brand px-3" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
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
                                    <li class="nav-item d-flex align-items-center">     
                                        <a class="nav-link" href="{{ route('rooms.index') }}"><i class="fa-solid fa-house fa-2x"></i></a>
                                    </li>
                                    <li class="nav-item dropdown ms-0 ms-md-3">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                @if(Auth::user()->icon)
                                                    <img src="{{ Storage::url(Auth::user()->icon) }}" alt="" class="img-thumbnail rounded-circle shadow">
                                                @else
                                                    <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle shadow">
                                                @endif
                                            </div>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                                            <li>
                                                <span class="dropdown-item">{{ Auth::user()->name }}</span>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('profiles.index') }}">
                                                    {{ __('profiles.profile') }}
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                    <i class="fa-solid fa-right-from-bracket fa-2x"></i>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown ms-0 ms-md-1">
                                        <a id="navbarDropdownNotice" class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="false" v-pre>     
                                            <i class="fa-solid fa-bell fa-2x position-relative">
                                                @if(Auth::user()->unreadNotifications->count() !== 0)
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger custom-notice-numbers">    
                                                        {{ Auth::user()->unreadNotifications->count() }}
                                                    </span>
                                                @endif
                                            </i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end shadow p-2 overflow-y-scroll" aria-labelledby="navbarDropdownNotice" style="height: 300px;">
                                            @forelse(Auth::user()->unreadNotifications as $notification)
                                                <li>
                                                    <span>{{ $notification->data['sender'] }}<i class="fa-solid fa-arrow-right mx-2"></i><span>
                                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ $notification->data['url'] }}">{{ $notification->data['content'] }}</a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                            @empty
                                                <li><p class="my-2">{{ __('notifications.no') }}</p></li>
                                            @endforelse
                                            <li>test</li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                            <li>test</li>
                                        </ul>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="custom-flash-area-parent">
                <div class="custom-flash-area-child" id="ajax-flash-message">
                    @if(session("successMessage"))
                        <div class="p-1">
                            <div class="alert alert-info mb-0 alert-dismissible fade show" role="alert">
                                {{ session("successMessage") }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @elseif(session("failureMessage"))
                        <div class="p-1">
                            <div class="alert alert-danger mb-0 alert-dismissible fade show" role="alert">
                                {{ session("failureMessage") }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="custom-main-color p-3">
            <div>
                <a href="{{ url('/') }}" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ config('app.name', 'Laravel') }} {{ __('About') }}</a>
            </div>
            <div class="mt-2">
                <a href="#" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ __('Contact') }}</a>
            </div>
            <div class="mt-2">
                <small>{{ __('Copyrigth') }}</small>
            </div>
        </footer>
    </div>
</body>
</html>
