@extends('layouts/admin')
@section('content')
    <div class="content">
        <h1>{{ $adv->title }}</h1>
        <br>
        <div>
            @if(!empty($adv->img))
            <img src="{{ ($adv->img) }}" alt="">
            @endif
            @if(!empty($adv->video))
            <p>
                <iframe width="560" height="315" src="{{ youtube($adv->video) }}?autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </p>
            @endif
            <p>
                <span>Категория: </span>
                {{ get_cats_name($adv->id) }}
            </p>
            <p>
                Сайт рекламодателя: <a href="{{ $adv->url }}" target="_blank">ссылка</a>
            </p>
        </div>
    </div>
    <div class="clear"></div>
@endsection
