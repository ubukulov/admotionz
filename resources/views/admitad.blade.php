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
	@if(isset($data))
		<div class="row" style="margin-top: 17px;">
			@foreach($data['results'] as $item)
			<div class="col-md-4 news_block">
				<div>
					<a rel="nofollow" href="{{ $item['gotolink'] }}">
						<img width="300" height="172" src="{{ $item['image'] }}" alt="">
					</a>
				</div>
				<div style="margin-top: -15px; height: 55px;">
					<h3>
						<a rel="nofollow" class="news_title" href="{{ $item['gotolink'] }}">
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
	@endif
	<div>
@stop