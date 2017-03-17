@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('authenticate') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="login" class="col-md-4 control-label">Логин</label>

                <div class="col-md-6">
                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}">

                    @if ($errors->has('login'))
                        <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Запомнить меня
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> Войти
                    </button>

                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                    <a class="btn btn-link" href="{{ url('/register') }}">Зарегистрироваться</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
