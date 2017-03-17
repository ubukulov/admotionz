@extends('layouts/moderator')
@section('content')
    <div class="content">
    <h2>Все новости</h2>
    <hr>
    <table class="table table-striped">
        <thead>
        <th>ID</th><th>Картинка</th><th>Наименование</th><th>Короткое описание</th><th>Добавил</th><th>Статус</th><th>Дата</th><th colspan="3">Действие</th>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td><img src="{{ $post->img }}" alt="" width="90"></td>
                <td>{{ $post->title }}</td>
                <td>
                    {{ $post->description }}
                </td>
                <td>{{ get_user_login($post->id_user) }}</td>
                <td>
                    @if($post->status == 0)
                        Ждет модерации
                    @elseif($post->status == 1)
                        Опубликован
                    @else
                        Снять с публикации
                    @endif
                </td>
                <td>{{ $post->created_at }}</td>
                <td>
                    @if(($post->status == 0) OR ($post->status == 2))
                        <button onclick="approve({{ $post->id }}, 'moderator');">Одобрить</button>
                    @else
                        <button onclick="block({{ $post->id }}, 'moderator');">Блокировать</button></td>
                    @endif
                </td>
                <td><a href="{{ ('/moderator/post/'.$post->id) }}" target="_blank">Просмотр</a></td>
                <td><button onclick="destroy({{ $post->id }}, 'moderator');">Удалить</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $posts->links() }}
    </div>
@stop