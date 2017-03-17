@extends('layouts.app')
@section('content')
    <div class="adv_content">
        <input id="adv_url" type="hidden" value="{{ $adv->url }}">
        <center>
        <h2 style="color: blue !important;">
            @if(!empty($post->body))
                <a rel="nofollow" onclick="post_url()" style="color: blue !important;" id="post_url" href="{{ ('/post/'.$post->id) }}">{{ $adv->title }}</a>
            @else
                <a rel="nofollow" onclick="post_url()" style="color: blue !important;" id="post_url" href="{{ ($post->link_source) }}">{{ $adv->title }}</a>
            @endif
        </h2>
        </center>
        @if(!empty($adv->img))
            <center>
            <p>
                @if(!empty($post->body))
                    <a rel="nofollow" id="post_url" onclick="post_url()" href="{{ ('/post/'.$post->id) }}"><img src="{{ $adv->img }}" alt=""></a>
                @else
                    <a rel="nofollow" id="post_url" onclick="post_url()" href="{{ ($post->link_source) }}"><img src="{{ $adv->img }}" alt=""></a>
                @endif
            </p>
            </center>
        @endif
        @if(!empty($adv->video))
            <p>
                <iframe width="560" height="315" src="{{ youtube($adv->video) }}?autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </p>
        @endif
        <h4>Вы автоматически перейдёте на сайт источника через <span id="timer">1</span> секунд или перейдите быстрее нажав
            <a rel="nofollow" id="post_url" onclick="post_url()" href="{{ $adv->url }}">сюда</a>
        </h4>
        <center>
        <h4 style="margin-top: 50px; border: 1px solid #ccc; padding: 10px;font-size: 12px; width: 470px;">
            <strong>Внимание реклама!</strong><br>
            Мы очень любим наших пользователей, поэтому заранее предупреждаем Вас о том, что при нажатии на кнопку "сюда" Вам откроется дополнительно сайт рекламодателя.
        </h4>
        </center>
    </div>
@endsection
