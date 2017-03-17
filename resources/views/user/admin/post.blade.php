@extends('layouts/admin')
@section('content')
    <div class="content">
        <h1>{{ $post->title }}</h1>
        <br>
        <div>
            <img src="{{ ($post->img) }}" alt="">
        </div>
        <p>{!! $post->body !!}</p>
        <div>
            Источник: <a href="{{ $post->link_source }}" target="_blank">сюда</a>
        </div>
    </div>
    <div class="clear"></div>
@endsection
