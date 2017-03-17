@extends('layouts/app')
@section('content')
<div class="left_sidebar">
    <div>
        <ul class="cats_lists">
            <li><a href="{{ url('/') }}">Все</a></li>
            @foreach($cat as $c)
                <li><a href="{{ url('/cat/'. $c->id) }}">{{ $c->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div class="content">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Горизантальный -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-4991679726294441"
         data-ad-slot="3140473018"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <h1 style="font-weight: bold;">{{ $post->title }}</h1>
    <img src="{{ $post->img }}" @if(getimagesize(base_path()."/public".$post->img)[0] > 700) width="700" @endif alt="">
    <div style="font-size: 16px;">{!! $post->body !!}</div>
    @if(!empty($post->link_source))
    <div>
        Источник: <a href="{{ $post->link_source }}" target="_blank">сюда</a>
    </div>
    @endif
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Нижняя реклама внутри новости -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-4991679726294441"
         data-ad-slot="1465263419"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<div class="right_sidebar">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Вертикальный баннер -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:240px;height:400px"
         data-ad-client="ca-pub-4991679726294441"
         data-ad-slot="6130965414"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<div class="clear"></div>
@endsection
