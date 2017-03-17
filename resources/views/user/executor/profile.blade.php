@extends('layouts.user')
@section('content')
    <div class="content">
        <h3>Профиль</h3>
        <hr>
        <div class="middle">
            <form action="{{ route('user.profile') }}" class="form-horizontal" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Фамилия</label>
                    <div class="col-sm-10">
                        <input type="text" name="lastname" id="lastname" class="form-control" value="{{ Auth::user()->lastname }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">Имя</label>
                    <div class="col-sm-10">
                        <input type="text" name="firstname" id="firstname" class="form-control" value="{{ Auth::user()->firstname }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="patronymic" class="col-sm-2 control-label">Отчество</label>
                    <div class="col-sm-10">
                        <input type="text" name="patronymic" id="patronymic" class="form-control" value="{{ Auth::user()->patronymic }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="login" class="col-sm-2 control-label">Логин</label>
                    <div class="col-sm-10">
                        <input type="text" name="login" id="login" class="form-control" value="{{ Auth::user()->login }}" disabled="disabled"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">E-mail</label>
                    <div class="col-sm-10">
                        {{ Auth::user()->email }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="submit" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" name="submit" id="submit" class="btn btn-warning" value="Изменить">
                    </div>
                </div>
            </form>
        </div>
        <div class="right_sidebar">
            <div class="right_div1">
                <span class="right_span">Количество рефералов:</span><span id="refs_count">{{ count_refs(Auth::user()->id) }}</span><br><br>
                <span class="right_span">Доход от рефералов:</span><span id="refs_profit">0,00 $</span>
            </div>
            <div class="right_div2">
                <span class="right_span">Реферальная ссылка</span><br>
                <input type="text" id="refs_link" value="http://xlink2.kz/?refs={{ Auth::user()->login }}" readonly="readonly"/>
            </div>
        </div>
        <div class="clear"></div>
    </div>
@stop