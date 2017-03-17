@extends('layouts/user')
@section('content')
    <div class="content">
        <h3>Рефералы</h3>
        <hr>
        <div class="middle">


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