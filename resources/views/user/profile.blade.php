@extends('layouts/user')
@section('content')
    <div class="content">
        <h3>Профиль</h3>
        <hr>
        <div class="middle">
            <form action="">
                {{ csrf_field() }}
                <label for="lastname">Фамилия</label><input type="text" name="lastname" value=""/><br>
                <label for="firstname">Имя</label><input type="text" name="firstname" value=""/><br>
                <label for="patronymic">Отчество</label><input type="text" name="patronymic" value=""/><br>
                <label for="login">Логин</label><input type="text" name="login" value="{{ Auth::user()->login }}" disabled="disabled"/><br>
                <label for="email">E-mail</label><input type="email" name="email" value="{{ Auth::user()->email }}" disabled="disabled"/><br>

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