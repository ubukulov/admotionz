@extends('layouts/advertiser')
@section('content')
    <div class="content">
        <h2>Мои расходы</h2>
        <span>Баланс: {{ Auth::user()->deposit }} тг</span>
        <span>Расход: {{ $sum }} тг</span>
        <hr>
        @if(!empty($data))
            <table border="0" class="table table-striped">
                <thead>
                <th>#</th><th>Наименование рекламы</th><th>Наименование новости</th><th>Сайт</th><th>Кол-во переходов</th><th>Пол</th><th>Возраст</th><th>Расположение</th><th>Расход</th>
                </thead>
                <tbody>
                @for($i=0; $i<count($data); $i++)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $data[$i]['adv_title'] }}</td>
                        <td>{{ $data[$i]['post_title'] }}</td>
                        <td>{{ $data[$i]['host_name'] }}</td>
                        <td>{{ $data[$i]['view'] }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $data[$i]['country'] }}</td>
                        <td>{{ $data[$i]['paid'] }}</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        @endif
    </div>
@stop