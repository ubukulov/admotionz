@extends('layouts/user')
@section('content')
    <div class="content">
        <h2>Доходы ({{ $profit }} тг)</h2>
        <hr>
        @if(!empty($data))
        <table class="table table-striped">
        <thead>
            <th>#</th><th>Наименование новости</th><th>Добавил</th><th>Оплата</th><th>Дата</th>
        </thead>
        <tbody>
            @for($i=0; $i<count($data); $i++)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ get_post_name_by_id($data[$i]->id_post) }}</td>
                <td>{{ get_user_login(get_data_by_id_news($data[$i]->id_post)['id_user']) }}</td>
                <td>
                    @if(check_post_user(Auth::user()->id,$data[$i]->id_post))
                        {{ $data[$i]->paid }}
                    @else
                        {{ ($data[$i]->paid)/2 }}
                    @endif
                </td>
                <td>{{ $data[$i]->created_at }}</td>
            </tr>
            @endfor
        </tbody>

        </table>
        @endif
    </div>
@stop