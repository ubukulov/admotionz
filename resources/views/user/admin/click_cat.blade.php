@extends('layouts/admin')
@section('content')
    <div class="content">
        <h2>Добавление категории</h2>
        <hr>
        <form action="{{ url('/admin/click-cat/store') }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Названия</label>
                <div class="col-sm-10">
                    <input type="text" id="name" name="name" class="form-control" disabled="disabled" placeholder="Название автоматические формируется">
                </div>
            </div>
            <div class="form-group">
                <label for="price_click" class="col-sm-2 control-label">Цена за клик</label>
                <div class="col-sm-10">
                    <input type="number" id="price_click" name="price_click" class="form-control" placeholder="50">
                </div>
            </div>
            <div class="form-group">
                <label for="percent" class="col-sm-2 control-label">Процент</label>
                <div class="col-sm-10">
                    <input type="number" id="percent" name="percent" class="form-control" placeholder="10">
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