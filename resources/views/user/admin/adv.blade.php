@extends('layouts/admin')
@section('content')
    <div class="content">
    <h2>Все рекламы</h2>
    <hr>
    <table class="table table-striped">
        <thead>
        <th>ID</th><th>Наименование</th><th>Добавил</th><th>Опубликован</th><th>Статус</th><th>Дата</th><th colspan="3">Действие</th>
        </thead>
        <tbody>
        @foreach($adv as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ $v->title }}</td>
                <td>{{ get_user_login($v->id_advertiser) }}</td>
                <td>
                    @if($v->publish == 0)
                        Нет
                    @else
                        Да
                    @endif
                </td>
                <td>
                    @if($v->status == 0)
                        Ждет модерации
                    @elseif($v->status == 1)
                        Одобрено
                    @else
                        Отказано
                    @endif
                </td>
                <td>{{ $v->created_at }}</td>
                <td>
                    @if($v->status == 0)
                    <button onclick="approve({{ $v->id }}, 'admin', 'adv');">Одобрить</button>
                    @elseif($v->status == 1)
                    <button onclick="block({{ $v->id }}, 'admin', 'adv');">Блокировать</button>
                    @else
                    <button onclick="approve({{ $v->id }}, 'admin', 'adv');">Одобрить</button>
                    @endif
                </td>
                <td>
                    <a href="{{ ('/admin/advertisement/'.$v->id) }}" target="_blank">Просмотр</a>
                </td>
                <td><button onclick="destroy({{ $v->id }}, 'admin', 'adv');">Удалить</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $adv->links() }}
    </div>
@stop