@extends('layouts/user')
@section('content')
    <div class="content">
        <h3>Мои новости</h3>
        <h4><a href="{{ url('/user/news/create') }}">Добавить новости</a></h4>
        <hr>
        <div class="middle" style="width: 100% !important;">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                <thead>
                    <th>ID</th><th>Картинка</th><th>Наименование</th><th>Категория</th><th>Статус</th><th>Дата</th><th>Редактировать</th><th>Удалить</th>
                </thead>
                <tbody>
                    @foreach($news as $n)
                    <tr>
                        <td>{{ $n->id }}</td>
                        <td><img src="{{ $n->img }}" alt="" width="80"></td>
                        <td>{{ $n->title }}</td>
                        <td>{{ get_cat_name($n->id_cat) }}</td>
                        <td>
                            @if($n->status == 0)
                                <img src="{{ asset('/img/mod.png') }}" alt="ждет модерации" title="Ждет модерации">
                            @elseif($n->status == 1)
                                <img src="{{ asset('/img/pub.png') }}" alt="опубликован" title="опубликован">
                            @else
                                <img src="{{ asset('/img/unpub.png') }}" alt="снято" title="Снято">
                            @endif
                        </td>
                        <td>{{ $n->created_at }}</td>
                        {{--<td><input type="text" readonly="readonly" value="{{ url('/post/'. $n->id . "-" . str_replace(' ', '-',mb_strtolower($n->title)). ".html") }}"></td>--}}
                        {{--<td>{{ get_profit($n->id, Auth::user()->id) }}</td>--}}
                        <td><a href="{{ url('/user/news/edit/'.$n->id) }}">Edit</a></td>
                        <td>
                            <button type="submit" onclick="deleteNews({{ $n->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $news->links() }}
        </div>
        <div class="clear"></div>
    </div>
@stop