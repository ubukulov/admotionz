@extends('layouts/advertiser')
@section('content')
    <div class="content">
        <div class="adv_create_form">
        <h2>Добавление рекламы</h2>
        <hr>
        <form class="adv_create_adv form-horizontal" action="{{ route('create.adv') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Названия</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="title" required="required">{{ $errors->first('title') }}
                </div>
            </div>
            <div class="form-group">
                <label for="capvid" class="col-sm-2 control-label">Выберите</label>
                <div class="col-sm-10" style="width: 150px; float: left;">
                    <label style="width: 80px; cursor: pointer;"><input style="cursor: pointer;" type="radio" name="capvid" id="capvid1" class="form-control" checked="checked" value="1">Изображение</label>
                </div>
                <div class="col-sm-10" style="width: 150px; float: left;">
                    <label style="width: 80px; cursor: pointer;"><input style="cursor: pointer;" type="radio" name="capvid" id="capvid2" class="form-control" value="2">Видео ролик</label>
                </div>
            </div>
            <div class="form-group" id="im">
                <label for="img" class="col-sm-2 control-label">Картинка</label>
                <div class="col-sm-10">
                    <input style="width: 500px;" type="file" name="img" id="img" class="form-control" required="required">{{ $errors->first('img') }}
                </div>
            </div>
            <div class="form-group" id="vid">
                <label for="video" class="col-sm-2 control-label">Видео ролик</label>
                <div class="col-sm-10">
                    <input type="text" name="video" class="form-control" id="video" placeholder="Ссылка на видео в Youtube" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="id_cat" class="col-sm-2 control-label">Категория</label>
                <div class="col-sm-10">
                    <select required="required" name="id_cat[]" id="id_cat"  class="form-control" multiple="multiple" style="width: 500px;" size="24">
                        @foreach($cats as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-sm-2 control-label">Веб сайт</label>
                <div class="col-sm-10">
                    <input type="text" name="url" id="url" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="publish" class="col-sm-2 control-label">Опубликовать</label>
                <div class="col-sm-10">
                    <select name="publish" id="publish" class="form-control" style="width: 100px;">
                        <option value="1">Да</option>
                        <option value="0">Нет</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default" >Добавить</button>
                </div>
            </div>

        </form>
        </div>
    </div>
@stop