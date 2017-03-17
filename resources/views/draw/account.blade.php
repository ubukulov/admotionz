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
                    <a href="http://admotionz.com" target="_blank">
                        <img style="margin-right: 50px;" src="{{ asset('img/logo.png') }}" class="brand-img img-responsive">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="nav-item">
                            <a href="{{ url('/drawing') }}">Вернуться назад</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/drawing/logout') }}">Выход</a>
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <div id="draw_account">

        <section id="content1">

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img @if(!empty($drawing->img)) src="{{ asset($drawing->img) }}" @else src="/draw/images/no-image.png" @endif alt="" width="200">
                        <form action="{{ url('/drawing/change/avatar') }}" style="margin-top: 5px;" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input style="width: 300px;" type="file" name="file" class="form-control" required="required">
                            <button type="submit" name="submit" class="btn btn-success">Изменить</button>
                        </form>
                        @if(Session::has('message'))
                            {!!Session::get('message')!!}
                        @endif
                    </div>
                    <div class="col-md-6">
                        <form action="{{ url('/drawing/account/settings') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}
                            <label>Имя</label>
                            <input type="text" name="firstname" value="{{ Auth::user()->firstname }}" class="form-control" required="required">
                            <label>Фамилия</label>
                            <input type="text" name="lastname" value="{{ Auth::user()->lastname }}" class="form-control" required="required">
                            <label>Телефон</label>
                            <input type="text" placeholder="Введите свой номер мобильного" name="phone" value="{{ Auth::user()->phone }}" class="form-control" required="required">
                            <label>Пароль</label>
                            <input type="password" name="password" value="{{ Auth::user()->password }}" class="form-control" required="required">
                            <button style="margin-top: -3px;" type="submit" name="submit" class="btn btn-warning">Сохранить</button>
                        </form>
                    </div>
                </div>
                <div class="row invitemore">
                    <h3>Ваша уникальная ссылка</h3>
                    <hr>
                    <div class="row"></div>
                    <div class="row text-center margin-bottom30">
                        <div class="row copy-cont">
                            <div class="col-md-8 col-xs-12 pull-left " style="width: 890px; text-align: left; padding-top: 4px;">
                                <h4 id="unique_link" class="margin-top20" style="font-size: 18px;">Привет! Это не СПАМ! Перейди по ссылке и выиграй крутые призы {{ $unique_link }}</h4>
                            </div>
                            <div class="col-md-3 col-xs-12 pull-right">
                                <button style="" type="button" id="copy_button" class="btn btn-copy btn-block btn-primary" data-clipboard-target="#unique_link"><span class="fa fa-copy"></span> Копировать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="content2">
            <div class="container">
                <div class="row invitemore">
                    <h3>Переходы по ссылку ({{ $count }})</h3>
                    <hr>
                    <div class="row"></div>
                    <div class="row text-center margin-bottom30">
                        <table class="table table-striped">
                            <th>#</th><th>IP</th><th>Дата</th>
                            @for($i=0; $i<count($drawing_statistics); $i++)
                            <tr>
                                <td>{{ $j = $i+1 }}</td>
                                <td>{{ $drawing_statistics[$i]->ip }}</td>
                                <td>{{ $drawing_statistics[$i]->created_at }}</td>
                            </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop