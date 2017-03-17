@extends('layouts/admin')
@section('content')
    <div class="content">
    <h2>Все пользователи</h2>
        <span style="font-size: 12px;">{{ get_all_count_of_users() }}</span>
    <hr>
    <table class="table table-striped">
        <thead>
            <th>ID</th><th>Логин</th><th>E-mail</th><th>Телефон</th><th>Роль</th><th>Блокирован</th><th>Дата регистрации</th><th colspan="3">Действие</th>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->login }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>
                {{ get_role_of_user($user->id) }}
            </td>
            <td>
                @if($user->block == 0) Нет @else Да @endif
            </td>
            <td>{{ $user->created_at }}</td>
            <td>
                @if($user->block == 0)
                <button onclick="spam({{ $user->id }});">Блокировать</button>
                @else
                <button onclick="despam({{ $user->id }});">Разблокировать</button>
                @endif
            </td>
            <td><a href="#">Ред.</a></td>
            <td><a href="#">Удалить</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@stop