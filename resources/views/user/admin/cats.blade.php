@extends('layouts/admin')
@section('content')
    <div class="content">
    <div class="row">
        <div class="col-md-6">
            <h2>Все категории</h2>
            <a href="{{ url('/admin/cat/create') }}">Добавить категории</a>
            <hr>
            <table class="table table-striped">
                <thead>
                <th>ID</th><th>Наименование</th><th>Позиция</th><th>Дата</th>
                </thead>
                <tbody>
                @foreach($cats as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td><input type="text" id="position{{ $c->id }}" onchange="catPosition({{ $c->id }});" value="{{ $c->position }}" style="width:50px; text-align: center;"></td>
                        <td>{{ $c->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h2>Все категории</h2>
            <a href="{{ url('/admin/click-cat/create') }}">Добавить категории</a>
            <hr>
            <table class="table table-striped">
                <thead>
                <th>ID</th><th>Наименование</th><th>Дата</th>
                </thead>
                <tbody>
                @foreach($click_cats as $click)
                    <tr>
                        <td>{{ $click->id }}</td>
                        <td>{{ $click->title }}</td>
                        <td>{{ $click->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </div>
@stop