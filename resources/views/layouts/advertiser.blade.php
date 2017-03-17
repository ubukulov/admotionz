<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Главная | Панель рекламодателя</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ ('/css/font-awesome.min.css') }}" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">--}}

            <!-- Styles -->
    <link rel="stylesheet" href="{{ ('/css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link href="{{ ('/css/user.css') }}" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Вернуться на сайт
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('advertiser') }}">Главная</a></li>
                <li><a href="{{ url('advertiser/adv') }}">Мои рекламы</a></li>
                <li><a href="{{ url('advertiser/spending') }}">Расходы</a></li>
                {{--<li><a href="#">Выплаты</a></li>--}}
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::check())
                    <li><a href="{{ url('advertiser/profile') }}" class="user_settings">{{ Auth::user()->login }}</a></li>
                    <li><a href="{{ url('advertiser/logout') }}">Выход</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->firstname }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('advertiser') }}"><i class="fa fa-btn fa-sign-out"></i>Кабинет</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выход</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div id="wrap">
    @yield('content')
</div>
        <!-- JavaScripts -->
<script src="{{ ('/js/jquery.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ ('/js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ ('/js/myscripts.js') }}" crossorigin="anonymous"></script>
<script src="{{ ('/js/script.js') }}" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>