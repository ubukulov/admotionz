@extends('layouts.admin')
@section('content')
    <div class="content">
        <h2>Зачисление баланс</h2>
        <hr>
        <form action="{{ url('admin/pay') }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="user" class="col-sm-2 control-label">Выберите рекламодателя</label>
                <div class="col-sm-10">
                    <select name="id_user" id="user" class="form-control" style="width: 400px;">
                        @foreach($user as $u)
                        <option value="{{ $u->id }}">{{ $u->login }} ({{ $u->deposit }} тг)</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="amount" class="col-sm-2 control-label">Укажите сумму</label>
                <div class="col-sm-10">
                    <input type="text" name="amount" id="amount" class="form-control" style="width: 400px;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Отправить</button>
                </div>
            </div>
        </form>
    </div>
@stop