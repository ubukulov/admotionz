@extends('layouts/admin')
@section('content')
    <div class="content">
        <h2>Все страницы</h2>
        <hr>
        <table class="table table-striped">
            <thead>
                <th>#</th><th>Наименование</th><th>Короткое описание</th><th>Дата</th><th>Действие</th>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->description }}</td>
                    <td>{{ $page->updated_at }}</td>
                    <td><a href="{{ url('/admin/page/'.$page->id) }}">Редактировать</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop