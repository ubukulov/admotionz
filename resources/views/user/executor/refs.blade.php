@extends('layouts/user')
@section('content')
    <div class="content">
        <h2>Рефералы ({{ $profit_refs }})</h2>
        <hr>
        <div class="middle">
        @if(!empty($profit))
        <table class="table table-striped">
        <thead>
            <th>#</th><th>Наименование новости</th><th>Добавил</th><th>Логин испольнителя</th><th>Оплата</th><th>Дата</th>
        </thead>
        <tbody>
        @for($i=0; $i<count($profit); $i++)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ get_post_name_by_id($profit[$i]->id_post) }}</td>
                <td>{{ get_user_login(Auth::user()->id) }}</td>
                <td>{{ get_user_login($profit[$i]->id_user) }}</td>
                <td>{{ ($profit[$i]->paid)/2 }}</td>
                <td>{{ $profit[$i]->created_at }}</td>
            </tr>
        @endfor
        </tbody>
        </table>
        @endif

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