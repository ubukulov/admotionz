@extends('layouts/user')
@section('content')
    <div class="content">
        <h3>Редактирование новости</h3>
        <hr>
        <div class="middle" style="width: 100% !important;">
            <form action="{{ route('user.news.update') }}" class="add_news_form form-horizontal" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $post->id }}" name="id">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Названия</label>
                <div class="col-sm-10">
                    <input style="width: 100%;" type="text" name="title" id="title" class="form-control" required="required" value="{{ $post->title }}">
                    {{ $errors->first('title') }}
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Короткое описание</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" cols="30" rows="2" class="form-control">{{ $post->description }}</textarea>
                    {{ $errors->first('description') }}
                </div>
            </div>
            <div class="form-group">
                <label for="keywords" class="col-sm-2 control-label">Ключевые слова</label>
                <div class="col-sm-10">
                    <textarea name="keywords" id="keywords" cols="30" rows="1" class="form-control">{{ $post->keywords }}</textarea><br>
                    {{ $errors->first('keywords') }}
                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-sm-2 control-label">Полные описание</label>
                <div class="col-sm-10">
                    <textarea name="body" id="body" class="form-control" cols="30" rows="10" required="required">{{ $post->body }}</textarea><br>
                    {{ $errors->first('body') }}
                </div>
            </div>
            <div class="form-group">
                <label for="img" class="col-sm-2 control-label">Картинка</label>
                <div class="col-sm-10">
                    @if(!empty($post->img))
                        <img src="{{ $post->img }}" alt="" width="90" height="90">
                        <input type="hidden" name="img" value="{{ $post->img }}" class="form-control">
                        <a href="{{ url('delete/img/'.$post->id) }}">Удалить</a>
                    @else
                        <input type="file" name="img" class="form-control" required="required"><br>
                        {{ $errors->first('img') }}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="id_cat" class="col-sm-2 control-label">Категория</label>
                <div class="col-sm-10">
                    <select name="id_cat" id="id_cat" class="form-control">
                        @foreach($cat as $c)
                            @if($c->id == $post->id_cat)
                                <option value="{{ $c->id }}" selected="selected">{{ $c->name }}</option>
                            @else
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="id_cat" class="col-sm-2 control-label">Клик категории</label>
                <div class="col-sm-10">
                    <select name="id_post_click" id="id_post_click" class="form-control">
                        @foreach($post_click as $click)
                            @if($click->id == $post->id_post_click)
                                <option value="{{ $click->id }}" selected="selected">{{ $click->title }}</option>
                            @else
                                <option value="{{ $click->id }}">{{ $click->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="link_source" class="col-sm-2 control-label">Ссылка на источник</label>
                <div class="col-sm-10">
                    <input style="width: 100%;" type="text" name="link_source" value="{{ $post->link_source }}" id="link_source" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="submit" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="submit" id="submit" value="Сохранить" name="submit" class="btn btn-success">
                </div>
            </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
@stop