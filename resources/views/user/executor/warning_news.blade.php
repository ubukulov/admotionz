@extends('layouts/user')
@section('content')
    <div class="content">
        <h3>Удаление новости</h3>
        <hr>
        <div class="middle" style="width: 100% !important;">
            <h2>{{ $post->title }}</h2>
            <p>
                <img src="{{ $post->img }}" alt="" width="150" align="left">
                {{ $post->description }}
            </p>
            <form action="{{ route('user.news.delete',$post->id) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $post->id }}">
                <input type="submit" name="del" value="yes">
                {{--<input type="submit" name="del" value="no">--}}
            </form>
        </div>
    </div>
@stop