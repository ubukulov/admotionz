@extends('layouts/user')
@section('content')
    <div class="content">
        <h3>Добавление новости</h3>
        <hr>
        <div class="add_create_news">
        <form action="{{ route('user.news.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Названия</label>
                <div class="col-sm-10">
                    <input type="text" name="title" required="required" class="form-control">
                    {{ $errors->first('title') }}
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Короткое описание</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" cols="30" rows="1" class="form-control"></textarea>
                    {{ $errors->first('description') }}
                </div>
            </div>
            <div class="form-group">
                <label for="keywords" class="col-sm-2 control-label">Ключевые слова</label>
                <div class="col-sm-10">
                    <textarea name="keywords" id="keywords" cols="30" rows="1" class="form-control"></textarea>
                    {{ $errors->first('keywords') }}
                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-sm-2 control-label">Полные описание</label>
                <div class="col-sm-10">
                    <textarea name="body" id="body" cols="30" rows="5" required="required" class="form-control"></textarea>
                    {{ $errors->first('body') }}
                </div>
            </div>
            <div class="form-group">
                <label for="img" class="col-sm-2 control-label">Картинка</label>
                <div class="col-sm-10">
                    <input type="file" name="img" required="required" class="form-control">
                    {{ $errors->first('img') }}
                </div>
            </div>
            <div class="form-group">
                <label for="id_cat" class="col-sm-2 control-label">Категория</label>
                <div class="col-sm-10">
                    <select name="id_cat" id="id_cat" class="form-control">
                        @foreach($cat as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="link_source" class="col-sm-2 control-label">Ссылка на источник</label>
                <div class="col-sm-10">
                    <input type="text" name="link_source" id="link_source" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="submit" class="col-sm-2 control-label"></label>
                <div class="col-lg-10">
                    <input type="submit" value="Сохранить" id="submit" name="submit" class="btn btn-success">
                </div>
            </div>
        </form>
        </div>
        <div class="clear"></div>
    </div>
@stop