@extends('layouts/admin')
@section('content')
    <div class="content">
        <h2>Редактировать страницу</h2>
        <hr>
        <form action="{{ url('admin/page/'.$page->id.'/update') }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Наименование</label>
                <div class="col-sm-10">
                    <input type="text" id="title" class="form-control" name="title" value="{{ $page->title }}">
                </div>
            </div>
            <div class="form-group">
                <label for="keywords" class="col-sm-2 control-label">Ключевые слова</label>
                <div class="col-sm-10">
                    <textarea name="keywords" id="keywords" class="form-control"  cols="30" rows="4">{{ $page->keywords }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Короткое описание</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" class="form-control"  cols="30" rows="4">{{ $page->description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-sm-2 control-label">Полное описание</label>
                <div class="col-sm-10">
                    <textarea name="body" id="body" cols="30"  class="form-control" rows="80">{{ $page->body }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="submit" class="col-sm-2 control-label"></label>
                <div>
                    <button class="btn btn-success" type="submit">Отправить</button>
                </div>
            </div>
        </form>
    </div>
@stop