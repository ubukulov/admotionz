@extends('layouts/app')
@section('content')
<div class="left_sidebar">
    <div id="menu3">
        <ul class="cats_lists">
            <li><a href="{{ url('/') }}">Все</a></li>
            @foreach($cat as $c)
            <li><a rel="nofollow" href="{{ url('/cat/'. $c->id) }}">{{ $c->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div class="content">
    @if(isset($ad_offers))
        <div class="row" style="margin: 0px;">
            @foreach($ad_offers['results'] as $item)
                <div class="col-md-3 ad_offers">
                    <div class="shop-image">
                        <a rel="nofollow" href="{{ url('/admitad/offer/'.$item['id']) }}" target="_blank">
                            <img width="143" height="59" src="{{ $item['image'] }}" alt="">
                        </a>
                    </div>
                    <div class="shop-title">
                        <a rel="nofollow" class="news_title" href="{{ url('/admitad/offer/'.$item['id']) }}" target="_blank">
                            {{ $item['name'] }}
                        </a>
                    </div>
                    <div class="cashback-rate-info">
                        <span class="current-rate special">5%</span>
                        <span class="">кэшбэк</span>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif(isset($ad_coupons))
        <div class="row" style="margin: 0px;">
            @foreach($ad_coupons['results'] as $item)
                <div class="col-md-3" style="height: 160px;">
                    <div>
                        <a rel="nofollow" href="{{ $item['goto_link'] }}">
                            <img width="149" height="59" src="{{ $item['image'] }}" alt="">
                        </a>
                    </div>
                    <div style="margin-top: -15px; height: 55px;">
                        <h3>
                            <a rel="nofollow" class="news_title" href="{{ $item['goto_link'] }}">
                                @if(Illuminate\Support\Str::length($item['name']) < 70)
                                    {{ $item['name'] }}
                                @else
                                    {{ substr(substr($item['name'],0,130),0,strrpos(substr($item['name'],0,130),' ')) }}
                                @endif
                            </a>
                        </h3>
                    </div>
                    <div>
                        {{--<p>--}}
                        {{--<img src="{{ ('/img/cat.png') }}" alt=""><span class="cat">{{ get_cat_name($two->id_cat) }}</span> |--}}
                        {{--<img src="{{ ('/img/man.png') }}" alt=""><span class="who_add">{{ get_user_login($two->id_user) }}</span> |--}}
                        {{--<img src="{{ ('/img/eye.png') }}" alt=""><span class="counter">{{ $two->view_count }}</span> |--}}
                        {{--<img src="{{ ('/img/date.png') }}" alt=""><span class="date">{{ convert_date_news($two->updated_at, $two->id) }}</span>--}}
                        {{--</p>--}}
                    </div>
                    <div class="soc_buttons">
                        <div class="addthis_inline_share_toolbox_gz9y"></div>
                        {{--@if($two->id_post_click != 1)--}}
                        {{--<div class="post_click">--}}
                        {{--<a href="{{ url('/drawing') }}" target="_blank" title="{{ get_post_click_cat_alt($two->id_post_click) }}">{{ get_post_click_cat_title($two->id_post_click) }}</a>--}}
                        {{--</div>--}}
                        {{--@endif--}}
                    </div>
                    {{--@if(Auth::check() && Auth::user()->role > 2)--}}
                    {{--<p style='margin-bottom: 10px;'>--}}
                    {{--<input type="text" id="refs_link{{ $two->id }}" class="hidden" value="{{ $two->title . " " . $two->bitly_short_link }}" />--}}
                    {{--<input style="width: 186px; margin-right: 10px;" type="text" value="{{ $two->bitly_short_link }}" readonly>--}}
                    {{--<button type="button" id="copy_button{{ $two->id }}" onclick="copy_func({{ $two->id }});"><span class="fa fa-copy"></span> Копировать</button>--}}
                    {{--</p>--}}
                    {{--@endif--}}
                </div>
            @endforeach
        </div>
    @else
    <div class="row" style="margin: 0px;">
    @foreach($last_two as $two)
        <div class="col-md-4 news_block">
            <div>
                <a rel="nofollow" href="{{ url("post/". $two->id) }}">
                    <img width="300" height="172" src="{{ $two->img }}" alt="">
                </a>
            </div>
            <div style="margin-top: -15px; height: 55px;">
                <h3>
                    <a rel="nofollow" class="news_title" href="{{ url("post/". $two->id) }}">
                        @if(Illuminate\Support\Str::length($two->title) < 70)
                            {{ $two->title }}
                        @else
                            {{ substr(substr($two->title,0,130),0,strrpos(substr($two->title,0,130),' ')) }}
                        @endif
                    </a>
                </h3>
            </div>
            <div>
                <p>
                    <img src="{{ ('/img/cat.png') }}" alt=""><span class="cat">{{ get_cat_name($two->id_cat) }}</span> |
                    <img src="{{ ('/img/man.png') }}" alt=""><span class="who_add">{{ get_user_login($two->id_user) }}</span> |
                    <img src="{{ ('/img/eye.png') }}" alt=""><span class="counter">{{ $two->view_count }}</span> |
                    <img src="{{ ('/img/date.png') }}" alt=""><span class="date">{{ convert_date_news($two->updated_at, $two->id) }}</span>
                </p>
            </div>
            <div class="soc_buttons">
                <div class="addthis_inline_share_toolbox_gz9y"></div>
                @if($two->id_post_click != 1)
                <div class="post_click">
                    <a href="{{ url('/drawing') }}" target="_blank" title="{{ get_post_click_cat_alt($two->id_post_click) }}">{{ get_post_click_cat_title($two->id_post_click) }}</a>
                </div>
                    @if(Auth::check())
                        @if(Auth::user()->id == $two->id_user)
                        <p style='margin-bottom: 10px;'>
                            <input type="text" id="refs_link{{ $two->id }}" class="hidden" value="{{ $two->title . " " . $two->bitly_short_link }}" />
                            <input style="width: 186px; margin-right: 10px;" type="text" value="{{ $two->bitly_short_link }}" readonly>
                            <button type="button" id="copy_button{{ $two->id }}" onclick="copy_func({{ $two->id }});"><span class="fa fa-copy"></span> Копировать</button>
                        </p>
                        @else
                        <p style='margin-bottom: 10px;'>
                            <input type="text" id="refs_link{{ $two->id }}" class="hidden" value="{{ $two->title . " " . get_user_post_link(Auth::user()->id,$two->id) }}" />
                            <input style="width: 186px; margin-right: 10px;" type="text" value="{{ get_user_post_link(Auth::user()->id,$two->id) }}" readonly>
                            <button type="button" id="copy_button{{ $two->id }}" onclick="copy_func({{ $two->id }});"><span class="fa fa-copy"></span> Копировать</button>
                        </p>
                        @endif
                    @endif
                @endif
            </div>

        </div>
    @endforeach
        <div class="col-md-4 news_block">
            <div class="google_div">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Главная 3-я блок новости -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4991679726294441"
                     data-ad-slot="2802395815"
                     data-ad-format="auto"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    @foreach($posts as $post)

        <div class="col-md-4 news_block">
            <div>
                <a rel="nofollow" href="{{ url("post/". $post->id) }}">
                    <img width="300" height="172" src="{{ $post->img }}" alt="">
                </a>
            </div>
            <div style="margin-top: -15px; height: 55px;">
                <h3>
                    <a rel="nofollow" class="news_title" href="{{ url("post/". $post->id) }}">
                        @if(Illuminate\Support\Str::length($post->title) < 70)
                            {{ $post->title }}
                        @else
                            {{ substr(substr($post->title,0,130),0,strrpos(substr($post->title,0,130),' ')) }}
                        @endif
                    </a>
                </h3>
            </div>
            <div>
                <p>
                    <img src="{{ ('/img/cat.png') }}" alt=""><span class="cat">{{ get_cat_name($post->id_cat) }}</span> |
                    <img src="{{ ('/img/man.png') }}" alt=""><span class="who_add">{{ get_user_login($post->id_user) }}</span> |
                    <img src="{{ ('/img/eye.png') }}" alt=""><span class="counter">{{ $post->view_count }}</span> |
                    <img src="{{ ('/img/date.png') }}" alt=""><span class="date">{{ convert_date_news($post->updated_at, $post->id) }}</span>
                </p>
            </div>
            <div class="soc_buttons">
                <div class="addthis_inline_share_toolbox_gz9y"></div>
                @if($post->id_post_click != 1)
                <div class="post_click">
                    <a href="{{ url('/drawing') }}" target="_blank" title="{{ get_post_click_cat_alt($post->id_post_click) }}">{{ get_post_click_cat_title($post->id_post_click) }}</a>
                </div>
                    @if(Auth::check())
                        @if(Auth::user()->id == $post->id_user)
                            <p style='margin-bottom: 10px;'>
                                <input type="text" id="refs_link{{ $post->id }}" class="hidden" value="{{ $post->title . " " . $post->bitly_short_link }}" />
                                <input style="width: 186px; margin-right: 10px;" type="text" value="{{ $post->bitly_short_link }}" readonly>
                                <button type="button" id="copy_button{{ $post->id }}" onclick="copy_func({{ $post->id }});"><span class="fa fa-copy"></span> Копировать</button>
                            </p>
                        @else
                            <p style='margin-bottom: 10px;'>
                                <input type="text" id="refs_link{{ $post->id }}" class="hidden" value="{{ $post->title . " " . get_user_post_link(Auth::user()->id,$post->id) }}" />
                                <input style="width: 186px; margin-right: 10px;" type="text" value="{{ get_user_post_link(Auth::user()->id,$post->id) }}" readonly>
                                <button type="button" id="copy_button{{ $post->id }}" onclick="copy_func({{ $post->id }});"><span class="fa fa-copy"></span> Копировать</button>
                            </p>
                        @endif
                    @endif
                @endif
            </div>

        </div>
    @endforeach
    </div>
    <div class="clear"></div>
    {{ $posts->links() }}
    @endif
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Главная нижняя реклама -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:970px;height:90px"
         data-ad-client="ca-pub-4991679726294441"
         data-ad-slot="4697931410"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
@endsection