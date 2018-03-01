@extends('layouts/user')
@section('content')
    <div class="content">
        На счету: {{ $profit }} тг.     В ожидании: 250 000тг.
        <br><br>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td width="250" style="text-align: right;">Общая прибыль:</td>
                        <td width="150">Сегодня:</td>
                        <td width="150">Вчера:</td>
                        <td width="150">За неделю</td>
                        <td width="150">За месяц</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Общее кол-во переходов:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Покупок и успешных действий:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Средний % конверсии:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        @if(!empty($data))
        <table class="table table-striped">
        <thead>
            <th>#</th><th>Наименование предложения</th><th>Добавил</th><th>Кол-во переходов</th><th>Успешных действий</th><th>Конверсия</th><th>Дата</th>
        </thead>
        <tbody>
            @for($i=0; $i<count($data); $i++)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ get_post_name_by_id($data[$i]->id_post) }}</td>
                <td>{{ get_user_login(get_data_by_id_news($data[$i]->id_post)['id_user']) }}</td>
                <td>{{ getNumberConversion(Auth::user()->id,$data[$i]->id_post) }}</td>
                <td></td>
                <td></td>
                <td>{{ $data[$i]->created_at }}</td>
            </tr>
            @endfor
        </tbody>

        </table>
        @endif
    </div>
@stop