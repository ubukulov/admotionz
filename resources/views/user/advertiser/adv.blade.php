@extends('layouts/advertiser')
@section('content')
    <div class="content">
        <h2>Мои рекламы</h2>
        <span>Общее количество: {{ get_count_adv(Auth::user()->id) }}</span>
        <span>Одобрено: {{ get_count_check_adv(Auth::user()->id) }}</span>
        <hr>
        <h4><a href="{{ url('advertiser/create') }}">Добавить рекламу</a></h4>
        @if(!empty($adv))
            <table border="0" class="table table-striped">
                <thead>
                <th>#</th><th>Наименование</th><th>Опубликован</th><th>Статус</th><th>Дата</th><th colspan="2">Действие</th>
                </thead>
                <tbody>
                @foreach($adv as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->title }}</td>
                        <td>
                            @if($a->publish == 1)
                                Да
                            @else
                                Нет
                            @endif
                        </td>
                        <td>
                            @if($a->status == 0)
                                Ждет модерации
                            @elseif($a->status == 1)
                                Одобрено
                            @else
                                Отказано
                            @endif
                        </td>
                        <td>{{ $a->created_at }}</td>
                        <td><a href="#">Ред.</a></td>
                        <td><a href="#">Удалить</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $adv->links() }}
        @endif
    </div>
@stop