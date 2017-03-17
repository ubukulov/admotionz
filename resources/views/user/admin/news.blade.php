@extends('layouts/admin')
@section('content')
    <div class="content">
    <h2>Все новости ({{ get_all_count_of_news() }})</h2>
    <hr>
    <table class="table table-striped">
        <thead>
        <th>ID</th><th>Картинка</th><th>Наименование</th><th>Показать в розыгрыше</th><th>Добавил</th><th>Статус</th><th>Дата</th><th colspan="3">Действие</th>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td><img src="{{ $post->img }}" alt="" width="90"></td>
                <td>{{ $post->title }}</td>
                <td style="text-align: center;">
                    @if($post->filter == 0)
                        <a href="{{ url('/admin/in_draw/'.$post->id) }}"><img src="{{ asset('/img/no_draw.png') }}" alt="draw" title="Не показывается в розыгрыше"></a>
                    @else
                        <a href="{{ url('/admin/no_draw/'.$post->id) }}"><img src="{{ asset('/img/in_draw.png') }}" alt="draw" title="Показывается"></a>
                    @endif
                </td>
                <td>{{ get_user_login($post->id_user) }}</td>
                <td>
                    @if($post->status == 0)
                        <img src="{{ asset('/img/mod.png') }}" alt="ждет модерации" title="Ждет модерации">
                    @elseif($post->status == 1)
                        <img src="{{ asset('/img/pub.png') }}" alt="опубликован" title="опубликован">
                    @else
                        <img src="{{ asset('/img/unpub.png') }}" alt="снято" title="Снято">
                    @endif
                </td>
                <td>{{ $post->created_at }}</td>
                <td>
                    @if(($post->status == 0) OR ($post->status == 2))
                        <button onclick="approve({{ $post->id }}, 'admin');">Одобрить</button>
                    @else
                        <button onclick="block({{ $post->id }}, 'admin');">Блокировать</button></td>
                    @endif
                <td>
                    <a href="{{ ('/admin/post/'.$post->id) }}" target="_blank">Просмотр</a>
                </td>
                <td><button onclick="destroy({{ $post->id }}, 'admin');">Удалить</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $posts->links() }}
    </div>
@stop