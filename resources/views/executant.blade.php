@extends('layouts/app')
@section('content')
    <div class="left_sidebar">
        <div>
            <h1>Категории</h1>
            <ul class="cats_lists">
                <li><a href="{{ url('/') }}">Все</a></li>
                @foreach($cat as $c)
                    <li><a href="{{ url('/cat/'. $c->id) }}">{{ $c->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="content">
        <header>
            <h1>{{ $page->title }}</h1>
        </header>
        <p>
            {!! $page->body !!}
        </p>
    </div>
@stop