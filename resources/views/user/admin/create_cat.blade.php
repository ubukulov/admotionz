@extends('layouts/admin')
@section('content')
    <div class="content">
        <h2>Добавление категории</h2>
        <hr>
        <form action="{{ url('/admin/cat/store') }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Названия</label>
                <div class="col-sm-10">
                    <input type="text" id="name" name="name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="position" class="col-sm-2 control-label">Позиция</label>
                <div class="col-sm-10">
                    <select name="position" id="position" class="form-control">
                    @foreach($cats as $cat)
                        <option value="{{ $cat->position }}">{{ $cat->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="submit" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <button class="btn btn-default" type="submit">Добавить</button>
                </div>
            </div>
        </form>
    </div>
@stop