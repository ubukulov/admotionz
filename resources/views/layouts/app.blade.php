<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="verify-admitad" content="9fd7fe7f36" />
	<meta name="verify-advertiseru" content="bdec060844" />
    <title>@if(\App\Http\Controllers\IndexController::$header) {{ $post->title }} | Admotionz.com @else Admotionz.com | Сервис для рекламодателей и испольнителей @endif</title>
    <meta name="keywords" @if(\App\Http\Controllers\IndexController::$header) content="{{ $post->keywords }}" @else content="admotionz" @endif>
    <meta name="description" @if(\App\Http\Controllers\IndexController::$header) content="{{ $post->description }}" @else content="Admotionz.com | Сервис для рекламодателей и испольнителей" @endif>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ ('/css/font-awesome.min.css') }}" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">--}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ ('/css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link href="{{ ('/css/style.css') }}" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <script type="text/javascript">
        function timer() {
            var h = screen.height;
            var w = screen.width;
            var obj = document.getElementById('timer');
            if(document.getElementById('adv_url').getAttribute('value') != ''){
                var adv_url = document.getElementById('adv_url').getAttribute('value');
            }
            if(document.getElementById('adv_url').getAttribute('value') != ''){
                var post_url = document.getElementById('post_url').getAttribute('href');
            }
            obj.innerHTML--;
            if(obj.innerHTML==0){
                window.location.href = post_url;
                setTimeout(function(){},1000);
            } else{
                setTimeout(timer,1000);
            }
        }
        setTimeout(timer,1000);
    </script>
    <script type="text/javascript" src="http://vk.com/js/api/share.js?94" charset="utf8"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-85779014-1', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40245609 = new Ya.Metrika({ id:40245609, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40245609" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    <!-- Put this script tag to the <head> of your page -->
    <script type="text/javascript" src="http://vk.com/js/api/share.js?94" charset="utf-8"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-4991679726294441",
		enable_page_level_ads: true
	  });
	</script>
</head>
<body id="app-layout">
    @if(!Cache::has('country_code'))
    <div class="top">
        <div class="top_content">
            <form action="{{ url('/location') }}" method="post">
                {{ csrf_field() }}
                <span class="top_span">ВАША СТРАНА {{ Cache::get('country_first_name') }} ?</span>
                <input type="submit" name="{{ Cache::get('country_first_code') }}" class="top_btn" value="ДА, УСТАНОВИТЬ РЕГИОН {{ Cache::get('country_first_name') }}">
                <input type="submit" name="{{ Cache::get('country_second_code') }}" class="top_btn" value="НЕТ, УСТАНОВИТЬ РЕГИОН {{ Cache::get('country_second_name') }}">
            </form>
        </div>
    </div>
    @endif
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
                <a class="navbar-brand" style="margin-left: -100px !important;" href="{{ url('/') }}"><img style="width: 135px; margin-top: -15px;"  src="{{ ('/img/logo.png') }}" /></a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Главная</a></li>
                    <li><a href="{{ url('/about') }}">О нас</a></li>
                    <li><a href="{{ url('/exe') }}">Исполнителям</a></li>
                    <li><a href="{{ url('/adv') }}">Рекламодателям</a></li>
                    <li><a href="{{ url('/drawing') }}" target="_blank" style="background: green; color: #fff;">Заработать</a></li>
                    {{--<li><a href="{{ url('/help') }}">Помощь</a></li>--}}
                    {{--<li><a href="{{ url('/contacts') }}">Контакты</a></li>--}}
                    @if(Auth::check() AND Auth::user()->role == 4)
                    <li><a href="{{ url('/user/news/create') }}" style="font-weight: bold; text-align: right; color: #36547F;">Добавить контент</a></li>
                    @else
                    <li><a href="{{ ('/login') }}" style="font-weight: bold; text-align: right; color: #36547F;">Добавить контент</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Войти</a></li>
                        <li><a href="{{ url('/register') }}">Регистрация</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->login }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->role == 1)
                                <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-sign-out"></i>Кабинет</a></li>
                                @endif
                                @if(Auth::user()->role == 2)
                                <li><a href="{{ url('/moderator') }}"><i class="fa fa-btn fa-sign-out"></i>Кабинет</a></li>
                                @endif
                                @if(Auth::user()->role == 3)
                                <li><a href="{{ url('/advertiser') }}"><i class="fa fa-btn fa-sign-out"></i>Кабинет</a></li>
                                @endif
                                @if(Auth::user()->role == 4)
                                <li><a href="{{ url('/user') }}"><i class="fa fa-btn fa-sign-out"></i>Кабинет</a></li>
                                @endif
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выход</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </nav>
    <div id="wrap">
        @yield('content')
    </div>
    <!-- JavaScripts -->
    <script src="{{ ('/js/jquery.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ ('/js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ ('/js/app.js') }}" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5805e4155134c647"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	<script src="{{ asset('/js/clipboard.min.js') }}"></script>
	<script>
	function copy_func(copy_button_id){
		var copy = "#copy_button"+copy_button_id;
		var hdn  = "#refs_link"+copy_button_id;
		(function(){
			var clipboard = new Clipboard(copy,{
				text: function(){
					return document.querySelector(hdn).value;
				}
			});
			clipboard.on('success', function(e) {
				console.log(e);
				$(copy).html("<span class='fa fa-copy'></span> Скопировано");
				window.setTimeout(function(){
					$(copy).html("<span class='fa fa-copy'></span> Копировать");
				}, 5000);
			});

			clipboard.on('error', function(e) {
				console.log(e);
			});
		})();	
	}
	</script>
</body>
</html>
