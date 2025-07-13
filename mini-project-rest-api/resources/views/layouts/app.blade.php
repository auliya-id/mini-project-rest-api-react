<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/assets/img/logo-ueu.png">

    <title>{{ config('app.name', 'Mini Project Rest API') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>

    <!-- jQuery (wajib untuk DataTables) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Fonts -->
    <link href="{{ asset('assets/css/font.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
        }

        #app-wrapper {
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar a {
            padding: 15px 15px;
            display: block;
            color: #333;
            text-decoration: none;
        }

        .sidebar a.active, .sidebar a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            margin-left: 250px;
            transition: margin-left 0.3s;
            width: 100%;
        }

        .content {
            flex-grow: 1;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 10px;
        }

        .footer {
            background: #007bff;
            color: white;
            padding: 10px 0 10px 0;
        }

        .navbar-brand {
            margin-right: 0px;
        }

        a.navbar-brand:hover {
            background-color: #FFF;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div id="app-wrapper" class="d-flex flex-column min-vh-100">
        <div class="d-flex flex-grow-1">
            <!-- Sidebar -->
            <div id="sidebar" class="sidebar">
                <a class="navbar-brand fw-bold text-center mb-3" href="{{ url('/') }}">
                    <h1>API SITE</h1>
                </a>
                @auth
                    <a href="" class="@yield('active')">
                        Dashboard
                    </a>
                @endauth
                <hr>
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="@yield('activeLogin')">
                            Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="@yield('activeRegister')">
                            Register
                        </a>
                    @endif
                @else
                    <a href="{{ url('/') }}">{{ Auth::user()->name }}</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </div>

            <!-- Main Content -->
            <div class="main-content flex-grow-1 d-flex flex-column">
                <div class="header d-flex justify-content-between align-items-center px-3">
                    <h2 class="m-0">
                        Mini Project Rest API
                    </h2>
                    <button class="btn btn-light d-md-none" onclick="toggleSidebar()">☰</button>
                </div>
                <div class="content px-3 py-4">
                    @yield('content')
                </div>
                <div class="footer text-center">
                    <span>&copy; {{ date('Y') }} {{ config('app.name', 'Mini Project Rest API') }}. All Rights Reserved.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>

    @stack('script')
</body>
</html>
