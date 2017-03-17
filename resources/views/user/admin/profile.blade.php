@extends('layouts/admin')
@section('content')
    <div class="content">
    <form action="{{ url('admin/profile/info') }}" method="post" class="form-horizontal">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">Фамилия</label>
            <div class="col-sm-10">
                <input style="width: 550px;"  type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}">
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">Имя</label>
            <div class="col-sm-10">
                <input style="width: 550px;"  type="text" name="firstname" id="firstname" class="form-control" value="{{ $user->firstname }}">
            </div>
        </div>
        <div class="form-group">
            <label for="patronymic" class="col-sm-2 control-label">Отчество</label>
            <div class="col-sm-10">
                <input style="width: 550px;"  type="text" name="patronymic" id="patronymic" class="form-control" value="{{ $user->patronymic }}">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-10">
                {{ $user->email }}
            </div>
        </div>
        <div class="form-group">
            <label for="submit" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <input type="submit" id="submit" value="Изменить" name="submit" class="btn btn-info">
            </div>
        </div>
    </form>

    <form action="{{ url('admin/profile/update/password') }}" class="form-horizontal" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Текущий пароль</label>
            <div class="col-sm-10">
                <input required="required" style="width: 550px;" type="password" name="password" id="password" class="form-control" value="{{ Auth::user()->password }}">
            </div>
        </div>
        <div class="form-group">
            <label for="new_password" class="col-sm-2 control-label">Новый пароль</label>
            <div class="col-sm-10">
                <input required="required"  style="width: 550px;"  type="password" name="new_password" id="new_password" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="confirm" class="col-sm-2 control-label">Подтверждение</label>
            <div class="col-sm-10">
                <input required="required"  style="width: 550px;"  type="password" name="confirm" id="confirm" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="submit1" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <input type="submit" name="change" id="submit1" class="btn btn-warning" value="Изменить пароль">
            </div>
        </div>
    </form>
    </div>
@stop