@extends('draw/core')
@section('content')

    <header id="header-2" class="soft-scroll header-2">
        <nav class="main-nav navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="http://admotionz.com/" target="_blank">
                        <img src="{{ asset('/img/logo.png') }}" class="brand-img img-responsive">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <a @if(isset($role)) href="{{ url('/drawing/account') }}" @else href="#myModal" data-toggle="modal" data-target="#myModal" @endif>Кабинет</a>
                        </li>
                        <li class="nav-item active">
                            <a href="#content-3-4">Спонсоры</a>
                        </li>
                        <li class="nav-item">
                            <a href="#content-3-4">правила</a>
                        </li>
                        <li class="nav-item">
                            <a href="#rating">рейтинг</a>
                        </li>
                        <li class="nav-item">
                            <a href="#content-2-7">Призы</a>
                        </li>
                        <li class="nav-item">
                            <a href="#">Победители</a>
                        </li>
                        <li class="nav-item">
                            <a href="#content-2-8">Что это?</a>
                        </li>
                        <li class="nav-item">
                            <a href="#comments">Комментарии</a>
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <section id="promo-1" class="content-block promo-1  min-height-600px">
        <div class="container">
            <div class="container text-center">
                <h1 class="margin-bottom45 margin-top15">Зарабатывай онлайн вместе с Admotionz!</h1>
            </div>
            <div class="row">
                <div class="col-md-6 text-center">
                    <h2 class="white">WOW! Получай до 500 тг. <br> за каждый уникальный переход по твоей ссылке.</h2>
                </div>
                <!-- /.col -->
                <div class="col-md-6 pad10">
                    @if(Auth::check() AND isset($role))
                    <div class="row" style="background: white; padding: 5px; width: 600px; height: 350px;">
                        <div class="col-md-6" style="width: 260px;">
                            <img @if(!empty($drawing->img)) src="{{ asset($drawing->img) }}" @else src="/draw/images/no-image.png" @endif alt="" width="200">
                            <form action="{{ url('/drawing/change/avatar') }}" style="margin-top: 5px;" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input style="width: 300px;" type="file" name="file" required="required">
                                <button type="submit" name="submit" class="btn btn-success">Изменить</button>
                            </form>
                            <a href="#rating" style="margin-top: 10px;">Посмотреть ТОП</a>
                            <br>
                            @if(Session::has('message'))
                                {!!Session::get('message')!!}
                            @endif
                        </div>
                        <div class="col-md-6">
                            <form action="{{ url('/drawing/account/settings') }}" class="form-horizontal" method="post">
                                {{ csrf_field() }}
                                {{--<label>Имя</label>--}}
                                <input type="text" placeholder="Имя" name="firstname" value="{{ Auth::user()->firstname }}" class="form-control" required="required">
                                {{--<label>Фамилия</label>--}}
                                <input type="text" placeholder="Фамилия" name="lastname" value="{{ Auth::user()->lastname }}" class="form-control" required="required">
                                <span style="color: green;">Необходим для вывода прибыли</span>
                                <input type="text" placeholder="Введите свой номер мобильного" name="phone" value="{{ Auth::user()->phone }}" class="form-control" required="required">
                                <p>Рейтинг: <span class="pull-right" style="color: #00a5bb;">{{ $place }} из {{ $participants }} участников</span></p>
                                <p>Переходов: <span class="pull-right" style="color: #00a5bb;">{{ $count }}</span></p>
                                <p>Ваш доход: <span class="pull-right" style="color: #00a5bb;">{{ $drawing->balance }} тг</span></p>
                                <button style="margin-top: -3px;" type="submit" name="submit" class="btn btn-warning">Сохранить</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <h4 class="white">Укажите ваши данные для участия.</h4>
                    <form class="margin-top20" action="{{ url('drawing/store') }}" method="post">
                        {{ csrf_field() }}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" name="firstname" placeholder="Имя" class="form-control" required="required"/>--}}
                                    {{--{{ $errors->first('firstname') }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" name="lastname" placeholder="Фамилия" class="form-control" required="required"/>--}}
                                    {{--{{ $errors->first('lastname') }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" class="form-control" required="required"/>
                            {{ $errors->first('email') }}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span class="form-control">@if(isset($num1) AND  isset($num2)) {{ $num1 }}  +  {{ $num2 }}  = @endif</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="captcha" class="form-control" placeholder="Ответь" required="required">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Подтвердить</button>
                        @if(Session::has('message'))
                            {!!Session::get('message')!!}
                        @endif
                    </form>
                    @if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
                    <div class="video-wrapper text-center">
                        <h5 class="finn margin-bottom0 margin-top45">Или авторизуйтесь через соц. сети:</h5>
                        <div class="big-social row">
                            <div class="col-sm-2 social-item facebook col-sm-offset-3">
                                <a href="#"><i class="social-icon white fa fa-2x fa-facebook"></i></a>
                            </div>
                            <div class="col-sm-2 social-item google">
                                <a href="#"><i class="social-icon  white fa fa-2x fa-instagram"></i></a>
                            </div>
                            <div class="col-sm-2 social-item facebook">
                                <a href="http://oauth.vk.com//authorize?client_id=5772123&display=popup&redirect_uri=http://admotionz.com/drawing/account/?provider=vkontakte&token=code"><i class="social-icon white fa fa-2x fa-vk"></i></a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <div class="absol">
            <img src="{{ asset('draw/images/megaf.png') }}" />
        </div>
    </section>
    <section class="content-block promo-3" style="min-height: 320px !important;">
        <div class="container text-center">
            <div class="col-sm-12">
                <div>
                    <h2>Больше ссылок = Больше переходов = Выше доход</h2>
                </div>
                <div class="underlined-title text-center">
                    <div class="row text-center"></div>
                    <h3 class="white">Распространяйте ссылку везде, где захотите:</h3>
                    <div class="row text-center">
                        <div class="big-social row">
                            <?php
                            $title=urlencode('Гонка за супер призы от Admotionz!');
                            $url=urlencode('http://bit.ly/2hYzBkc');
                            $summary=urlencode('После приглашения 10 друзей Вы примите участие в розыгрыше 10 денежных призов по 2000 тг.');
                            $image=urlencode('http://admotionz.com/img/logo.png');
                            ?>
                            <div class="social-item facebook col-sm-1 col-sm-offset-2">
                                <a onClick="window.open('http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title; ?>&p[summary]=<?php echo $summary; ?>&p[url]=<?php echo $url; ?>&&p[images][0]=<?php echo $image; ?>','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)"><i class="social-icon fa fa-2x fa-facebook"></i></a>
                            </div>
                            <div class="col-sm-1 social-item ok">
                                <a href="http://facebook.com/"><i class="social-icon fa fa-2x fa-odnoklassniki"></i></a>
                            </div>
                            <div class="col-sm-1 social-item skype">
                                <a href="http://skype.com/"><i class="social-icon fa fa-2x fa-skype"></i></a>
                            </div>
                            <div class="col-sm-1 social-item whatsapp">
                                <a href="http://whatsapp.com/"><i class="social-icon fa fa-2x fa-whatsapp"></i></a>
                            </div>
                            <div class="col-sm-1 social-item twitter">
                                <a href="http://twitter.com/"><i class="social-icon fa fa-2x fa-twitter"></i></a>
                            </div>
                            <div class="col-sm-1 social-item google">
                                <a href="http://plus.google.com/"><i class="social-icon fa fa-2x fa-instagram"></i></a>
                            </div>
                            <div class="col-sm-1 social-item vk">
                                <a @if(isset($drawing)) href="http://vk.com/share.php?url=http://admotionz.com/drawing/{{ $drawing->user_id."/".$drawing->token }}" @else href="http://vk.com/share.php?url=http://admotionz.com/drawing" @endif target="_blank"><i class="social-icon fa fa-2x fa-vk"></i></a>
                            </div>
                            <div class="social-item viber col-sm-1">
                                <a href="http://facebook.com/"><i class="social-icon fa fa-2x fa-viber"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </section>
    @if(isset($role))
    {{--<section id="content-2-6" class="content-block content-2-6 ">--}}
        {{--<div class="container text-center">--}}
            {{--<div class="container">--}}
                {{--<!-- Start Row -->--}}
                {{--<div class="row margin-top30">--}}
                    {{--<div class="col-sm-5 margin-top20">--}}
                        {{--<img class="img-rounded img-responsive pull-right" @if(!empty($drawing->img)) src=" {{ asset($drawing->img) }}" @else src="/draw/images/no-image.png" @endif width="250">--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-6">--}}
                        {{--<div class="invitemore">--}}
                            {{--<h3>Кол-во приглашений: <span>{{ $count }}</span></h3>--}}
                            {{--<h3>До призов осталось: <span>2</span></h3>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!--// END Row -->--}}
            {{--</div>--}}
            {{--<div class="col-sm-10 col-sm-offset-1 margin-top30">--}}
                {{--<h2>Скопируйте это сообщение и отправьте его своим друзьям. <br />Хотите побороться за главный приз, сделайте приглашений больше остальных участников.</h2>--}}
            {{--</div>--}}
            {{--<div class="row"></div>--}}
            {{--<div class="row text-center margin-bottom30">--}}
                {{--<div class="row copy-cont">--}}
                    {{--<div class="col-md-8 col-xs-12 pull-left ">--}}
                        {{--<h4 id="unique_link" class="margin-top20">{{ url('/drawing/'.$drawing->user_id.'/'.$drawing->token) }}</h4>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-3 col-xs-12 pull-right">--}}
                        {{--<button type="button" id="copy_button" data-clipboard-target="#unique_link" class="btn btn-copy btn-block btn-primary"><span class="fa fa-copy"></span> Копировать</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- /.container -->--}}
    {{--</section>--}}
    @endif
    <section id="content-2-6" class="content-block content-2-6 ">
        <div class="container text-center">
            <div class="container">
                <h2>Почему работать с Admotionz.com очень выгодно:</h2>
                <br>
                <h3>+ Получай до 250 тг. за каждый уникальный переход распространяя ссылку</h3>
                <h3>+ Приглашай в проект своих друзей по своей ссылке ниже и получай 10% от их доходов</h3>
                <h3>+ Более 1000 эксклюзивных предложений от крупнейших компаний на <br>
                    одном сайте, которые будут интересны каждому. <a href="https://admotionz.com">посмотреть</a> </h3>
                <h3>+ Получай также до 50% с покупок или других действий Ваших друзей:
                    регистрация, вход в игру, скачивание приложений или получение займа</h3>
                <h3>+ Выводи деньги на карту любого банка или Qiwi кошелек через личный кабинет</h3>
                <h3>+ Приглашаем к сотрудничеству вебмастеров, владельцев сайтов, блогеров, владельцев популярных групп, вайнеров и популярных людей в соц. сетях</h3>

                <!--                 <br>
                <h4 style="font-weight: bold;">1 переход = 5 тенге</h4>
                <br>
                <h4>также зарабатываете 5 тг. за каждое новое приглашение</h4> -->
                <br>
                <h4 style="font-weight: bold">Распространяйте Вашу ссылку и начните зарабатывать прямо сейчас!</h4>
            </div>
            <div class="row text-center margin-bottom30">
                <div class="row copy-cont margin-bottom30">
                    <div class="col-md-8 col-xs-12 pull-left " style="width: 890px; text-align: left; padding-top: 4px;">
                        <h4 id="unique_link" class="margin-top20" style="font-size: 18px;" @if(!isset($drawing)) style="color: red;" @endif>
                            @if(isset($drawing))
                            Привет! Это не СПАМ! Перейди по ссылке и выиграй крутые призы {{ $unique_link }}
                            @else
                            Ваша ссылка станет доступна после регистрации / авторизации
                            @endif
                        </h4>
                    </div>
                    <div class="col-md-3 col-xs-12 pull-right">
                        <button type="button" id="copy_button" data-clipboard-target="#unique_link" class="btn btn-copy btn-block btn-primary"><span class="fa fa-copy"></span> Копировать</button>
                    </div>
                </div>
                <h4 style="color: red">Расскажите о новом виде онлайн заработка своим друзьям и получайте 10% с их дохода</h4>
                <div class="row copy-cont margin-top30">
                    <div class="col-md-8 col-xs-12 pull-left " style="width: 890px; text-align: left; padding-top: 4px;">
                        <h4 id="unique_link" class="margin-top20" style="font-size: 18px;" @if(!isset($drawing)) style="color: red;" @endif>
                            @if(isset($drawing))
                            Привет! Это не СПАМ! Перейди по ссылке и выиграй крутые призы {{ $unique_link }}
                            @else
                            Ваша ссылка станет доступна после регистрации / авторизации
                            @endif
                        </h4>
                    </div>
                    <div class="col-md-3 col-xs-12 pull-right">
                        <button type="button" id="copy_button" data-clipboard-target="#unique_link" class="btn btn-copy btn-block btn-primary"><span class="fa fa-copy"></span> Копировать</button>
                    </div>
                </div>
                <div class="row text-center" style="border: 4px solid red; margin-top: 15px;">
                    <h3>Распространяя Вашу реферальную ссылку Вы также<br> можете выиграть классные денежные призы.</h3>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </section>
    @if(isset($posts) AND count($posts) > 0)
    {{-- List offers --}}
    <section class="">
        <div class="container">
            <h3 class="text-center">Получайте до 50 тг. за каждый переход</h3>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4 news_block">
                        <div>
                            <a rel="nofollow" href="{{ url("post/". $post->id) }}">
                                <img width="300" height="172" src="{{ $post->img }}" alt="">
                            </a>
                        </div>
                        <div style="margin-top: -15px; height: 55px;">
                            <h3>
                                <a rel="nofollow" class="news_title" href="{{ url("post/". $post->id) }}">
                                    @if(Illuminate\Support\Str::length($post->title) < 70)
                                        {{ $post->title }}
                                    @else
                                        {{ substr(substr($post->title,0,130),0,strrpos(substr($post->title,0,130),' ')) }}
                                    @endif
                                </a>
                            </h3>
                        </div>
                        <div>
                            <p>
                                <img src="{{ ('/img/cat.png') }}" alt=""><span class="cat">{{ get_cat_name($post->id_cat) }}</span> |
                                <img src="{{ ('/img/man.png') }}" alt=""><span class="who_add">{{ get_user_login($post->id_user) }}</span> |
                                <img src="{{ ('/img/eye.png') }}" alt=""><span class="counter">{{ $post->view_count }}</span> |
                                <img src="{{ ('/img/date.png') }}" alt=""><span class="date">{{ convert_date_news($post->updated_at, $post->id) }}</span>
                            </p>
                        </div>
                        <div class="soc_buttons">
                            <div class="addthis_inline_share_toolbox_gz9y"></div>
                            <div class="post_click">
                                <span title="{{ get_post_click_cat_alt($post->id_post_click) }}">{{ get_post_click_cat_title($post->id_post_click) }}</span>
                            </div>
                        </div>
                        @if(Auth::check() && Auth::user()->role > 2)
                            <p style='margin-bottom: 10px;'>
                                <input type="text" id="refs_link{{ $post->id }}" class="hidden" value="{{ $post->title . " " . $post->bitly_short_link }}" />
                                <input style="width: 186px; margin-right: 10px;" type="text" value="{{ $post->bitly_short_link }}" readonly>
                                <button type="button" id="copy_button{{ $post->id }}" onclick="copy_func({{ $post->id }});"><span class="fa fa-copy"></span> Копировать</button>
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- List offers --}}
    @endif
    <section id="content-2-7" class="content-block content-2-7">
        <div class="container">
            <div class="row">
                <div class="underlined-title">
                    <div class="sample1">
                        <div class="container text-center"></div>
                        <h2 class="text-center margin-top45">ГОНКА ЗА СУПЕР ПРИЗЫ НАЧАЛАСЬ!</h2>
                        <span class="total-inv">@if(isset($all_count)) {{ $all_count }} @endif</span>
                        <button type="button" class="pull-right btn no-shadow btn-sm bg-tan-hover btn-default" data-toggle="popover" title="Подсказка" data-content="Делайте больше приглашений и следите за Вашим рейтингом в гонке, чтобы по достижению необходимого общего числа приглашений, Вы оказались на 1 месте и стали победителем!" role="button" data-container="body" data-delay="300" data-placement="left">?</button>
                        <h3>Всего переходов на {{ date("d.m.Y H:i") }}</h3>
                        <!-- <div class="slider shor slider-inverse"></div> -->
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $all_count }}" aria-valuemin="0" aria-valuemax="1000" style="width: 60%;">
                            <span class="sr-only">60% Complete</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-center">
                            <div class="counter-icon">
                                <span class="fa fa-bullhorn"></span>
                            </div>
                            <div class="counter-text">
                                <h3 class="counter">1000</h3>
                                <span>10 призов по 1000 тг.</span>
                            </div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="counter-icon">
                                <span class="fa fa-gift"></span>
                            </div>
                            <div class="counter-text">
                                <h3 class="counter">2500</h3>
                                <span>10 призов по 2000 тг.</span>
                            </div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="counter-icon">
                                <span class="fa fa-star"></span>
                            </div>
                            <div class="counter-text">
                                <h3 class="counter">5000</h3>
                                <span>10 призов по 2500 тг.</span>
                            </div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="counter-icon">
                                <span class="fa fa-trophy"></span>
                            </div>
                            <div class="counter-text">
                                <h3 class="counter">10000</h3>
                                <span>20 призов по 2500 тг.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 ">
                    <div>
                        <a class=" white">* призы от партнеров</a>
                        <a class="btn btn-round-w btn-sm ">подробнее</a>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <span class="white">Призы выигрывают те участники, которые окажутся в ТОПе выше всех, когда наберется необходимое общее кол-во переходов</span>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    @if(isset($role))
    <section id="content-1-2" class="content-block content-1-2">
        <div class="container">
            <!-- Start Row -->
            <div class="row margin-top30">
                <div class="col-sm-5 col-sm-offset-1 margin-top20">
                    <img class="img-rounded img-responsive" @if(!empty($drawing->img)) src=" {{ asset($drawing->img) }}" @else src="/draw/images/no-image.png" @endif width="300">
                </div>
                <div class="col-sm-6">
                    <div class="invitemore">
                        <h3>Приглашайте больше друзей чтобы принять участие в гонке за супер призы!</h3>
                        <div class="bg-turquoiseb col-md-12">
                            <ul>
                                <li>Место в гонке:
                                    <a class="pull-right" href="#">{{ $place }} из {{ $participants }} участников</a>
                                </li>
                                <li>Всего:
                                    <a class="pull-right" href="#">{{ $all_count }} приглашений</a>
                                </li>
                                <li>До победы осталось:
                                    <a class="pull-right" href="#">{{ $other }} приглашений</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <a href="#" class="btn btn-block btn-primary"><span class="fa fa-bullhorn"></span>&nbsp Пригласить</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--// END Row -->
        </div>
    </section>
    @endif
    <section id="rating" class="content-block team-2 team-2-2">
        <div class="container">
            <div class="underlined-title">
                <h2><span class="fa fa-bar-chart"></span>&nbspРейтинг пользователей</h2>
            </div>
            <div class="row">
                @foreach($draw_participants as $key=>$val)
                <div class="col-md-3 col-sm-6 col-xs-12 team-wrapper">
                    <div class="team-item">
                        <div class="team-thumb">
                            <img style="width: 263px; height: 197px;" @if(!empty($val->img)) src="{{ asset($val->img) }}" @else src="/draw/images/no-image.png" @endif class="img-responsive" alt="Member Image">
                            <div class="image-overlay"></div>
                            <a href="#" class="team-link"><i class="fa fa-3x fa-envelope-o"></i></a>
                        </div>
                        <div class="team-details">
                            <h5>{{ $key+1 }} место в общем рейтинге</h5>
                            <h7>Кол-во приглашений: {{ $val->cnt }}</h7><br>
                            <h7>Заработал уже: {{ $val->balance }} тг.</h7>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row text-center">
                <button type="button" class="btn btn-primary">показать еще</button>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <section id="content-2-8" class="content-2-8 content-block-nopad">
        <div class="image-container pull-left col-sm-4">
            <div class="background-image-holder">
                <div class="imagecont"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-7 col-sm-offset-5 col-xs-12 content clearfix col-md-8 col-md-offset-4">
                    <h2>Что это?</h2>
                    <div class="row pad15">
                        <div class="col-xs-2">
                            <span class="fa fa-rocket fa-4x"></span>
                        </div>
                        <div class="col-xs-10">
                            <p class="lead">Admotionz.com - онлайн площадка, для рекламодателей и исполнителей, которая позволяет одним получить новых клиентов, другим заработать на этом.</p>
                        </div>
                    </div>
                    <div class="row pad15">
                        <div class="col-xs-2">
                            <span class="fa fa-star-o fa-4x"></span>
                        </div>
                        <div class="col-xs-10">
                            <p class="lead">С нами уже работают более 1000 рекламодателей, предложения которых Вы можете посмотреть <a href="https://admotionz.com">здесь</a></p>
                        </div>
                    </div>
                    <div class="row pad15">
                        <div class="col-xs-2">
                            <span class="fa fa-money fa-4x"></span>
                        </div>
                        <div class="col-xs-10">
                            <p class="lead">Распространяйте уникальную ссылку, получайте доход с покупок друзей и зарабатывайте 10% с их дохода.</p>
                        </div>
                    </div>
                    <h2>Как мы разыгрываем призы?</h2>
                    <div class="row pad15">
                        <div class="col-xs-2">
                            <span class="fa fa-send fa-4x"></span>
                        </div>
                        <div class="col-xs-10">
                            <p class="lead">Все честно! Сделай приглашений больше остальных участников и выигрывай главные призы.</p>
                        </div>
                    </div>
                    <!-- /.row -->
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.row-->
        </div>
        <!-- /.container -->
    </section>
    <section id="content-1-6" class="content-1-6 content-block pad60">
        <div class="container">
            <div class="row text-center">
                <h2>Нас поддержали:</h2>
            </div>
            <!--end of row-->
            <div class="row client-row">
                <div class="row-wrapper">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/likemoney.me.png') }}"> -->
                        <h3><a style="color: red" href="http://likemoney.me" target="_blank">Likemoney.me</a></h3>
                        <!-- <h3><a style="color: red" href="https://aliexpress.com" target="_blank">Aliexpress</a></h3> -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/logo-less.png') }}"> -->
                        <h3><a style="color: red" href="https://lamoda.kz" target="_blank">Lamoda</a></h3>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/logo-sass.png') }}"> -->
                        <h3><a style="color: red" href="https://Ozon.ru" target="_blank">Ozon.ru</a></h3>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/logo-jquery.png') }}"> -->
                        <h3><a style="color: red" href="https://Wildberries.kz" target="_blank">Wildberries</a></h3>
                    </div>
                </div>
                <div class="row-wrapper">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/likemoney.me.png') }}"> -->
                        <!-- <a style="font-size: 28px;" href="http://likemoney.me" target="_blank">LIKEMONEY.ME</a> -->
                        <h3><a style="color: red" href="https://aliexpress.com" target="_blank">Aliexpress</a></h3>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/logo-less.png') }}"> -->
                        <h3><a style="color: red" href="https://Moneyman.kz" target="_blank">Moneyman</a></h3>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/logo-sass.png') }}"> -->
                        <h3><a style="color: red" href="https://Sulpak.kz" target="_blank">Sulpak</a></h3>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- <img alt="client" src="{{ asset('draw/images/partner-logos/logo-jquery.png') }}"> -->
                        <h3><a style="color: red" href="https://Alser.kz" target="_blank">Alser</a></h3>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <section id="content-3-4" class="content-block content-3-4 margin-top60">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div>
                        <h2 class="asbestos">СПОНСОРЫ ГОНКИ</h2>
                        <ul class="margin-top45">
                            <li>
                                <h3 class="text-center"><a href="http://likemoney.me/" target="_blank">LIKEMONEY.ME</a></h3>
                            </li>
                            <li>
                                <h3><a href="http://admotionz.com" target="_blank">ADMOTIONZ</a></h3>
                            </li>
                            <li>
                                <h3><a href="http://travel.likemoney.me" target="_blank">TRAVELZ</a></h3>
                            </li>
                            <li>
                                <h3><a href="#">MILKYCUP</a></h3>
                            </li>
                            <li>
                                <h3><a href="http://likemoney.me" target="_blank">OPTPRICE</a></h3>
                            </li>
                            <li>
                                <h3><a href="#">DINDON</a></h3>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row text-center">
                        <h2 class="asbestos">ПРАВИЛА</h2>
                    </div>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent=".panel-group" href="#content0"><span>Мы абсолютно честно разыгрываем призы</span></a></h4>
                            </div>
                            <!-- /.panel-heading -->
                            <div id="content0" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <p>Становится победителем тот участник, который сделал приглашений больше остальных, все участники видят в реальном времени какое место они занимают в общей гонке за супер призы.</p>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.content -->
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a class="panel-toggle collapsed" data-toggle="collapse" data-parent=".panel-group" href="#content1"><span>Как разыгрываються призы</span></a></h4>
                            </div>
                            <!-- /.panel-heading -->
                            <div id="content1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Розыгрыш призов длиться до бесконечности, призы разыгрываются каждый раз, когда достигается новая отметка по кол-ву участников, на каждом новом этапе подключаются новые спонсоры со своими ценными призами.</p>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.content -->
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a class="panel-toggle collapsed" data-toggle="collapse" data-parent=".panel-group" href="#content2"><span>Зачет приглашений</span></a></h4>
                            </div>
                            <!-- /.panel-heading -->
                            <div id="content2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Вам засчитывается приглашение только в случае перехода друзей по ссылке, которую Вы им выслали.</p>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.content -->
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a class="panel-toggle collapsed" data-toggle="collapse" data-parent=".panel-group" href="#content3"><span>Супер гонка</span></a></h4>
                            </div>
                            <!-- /.panel-heading -->
                            <div id="content3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Вам засчитывается новые переходы Вашими друзьями и это позволяет Вам расти в общем рейтинге.
                                        Переход засчитывается только один раз в сутки по одному уникальному пользователю, т.е. один Ваш друг может повышать Ваш рейтинг на 1 приглашение каждый новый день.</p>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.content -->
                        </div>
                    </div>
                    <!-- /.accordion -->
                </div>
                <!-- /.column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <section class="content-block contact-1">
        <div class="container text-center">
            <h2>Комментарии</h2>
            <!-- /.col-sm-10 -->
        </div>
        <!-- /.container -->
    </section>
    <div id="comments" class="content-block contact-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div id="contact" class="form-container">
                        <div class="comments">
                            <div class="heading">
                                <h4 class=" heading-title">Комментарии VK</h4>
                                <div class="heading-line">
                                    <span class="short-line"></span>
                                    <span class="long-line"></span>
                                </div>
                            </div>
							<!-- Put this div tag to the place, where the Comments block will be -->
							<div id="vk_comments"></div>
							<script type="text/javascript">
							VK.Widgets.Comments("vk_comments", {limit: 10, width: "550", attach: "*"});
							</script>
                        </div>
                    </div>
                    <!-- /.form-container -->
                </div>
                <div class="col-md-6">
                    <div id="contact" class="form-container">
                        <div class="comments">
                            <div class="heading">
                                <h4 class="heading-title">Комментарии Facebook</h4>
                                <div class="heading-line">
                                    <span class="short-line"></span>
                                    <span class="long-line"></span>
                                </div>
                            </div>
							<div class="fb-comments" data-href="http://admotionz.com/drawing" data-width="550" data-numposts="10"></div>
                        </div>
                    </div>
                    <!-- /.form-container -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
	<!--
	<script type="text/javascript">
	  VK.init({apiId: 5772123});
	</script> -->
@stop
