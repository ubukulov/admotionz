@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel-body register_form">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                <label for="role" class="col-md-4 control-label">Роль</label>

                <div class="col-md-6">
                    <select name="role" id="role" class="form-control">
                        <option value="3">Рекламодатель</option>
                        <option value="4">Испольнитель</option>
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Логин*</label>

                <div class="col-md-6">
                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" placeholder="Ваше логин">

                    @if ($errors->has('login'))
                        <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail*</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Ваш email">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Пароль*</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Придумайте пароль">

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 control-label">Подтверждать пароль*</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Повторно введите пароль">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i> Регистрироваться
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
