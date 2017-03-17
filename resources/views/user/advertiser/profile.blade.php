@extends('layouts/advertiser')
@section('content')
    <div class="content">
        <h2>Профиль</h2>
        <span>Баланс: {{ Auth::user()->deposit }} тг</span><span style="margin-left: 40px;">Цена за просмотр: {{ Auth::user()->amount }} тг</span><br><br>
        <button class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-sm1">Внести платеж</button>
        <button type="button" style="margin-left: 25px;" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Изменить</button>
        <hr>
        <div class="contact_info">
            <form action="{{ route('advertiser/contact') }}" class="form-horizontal" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Фамилия</label>
                    <div class="col-sm-10">
                        <input type="text" name="lastname" class="form-control" id="lastname" value="{{ Auth::user()->lastname }}" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">Имя</label>
                    <div class="col-sm-10">
                        <input type="text" name="firstname" class="form-control" id="firstname" value="{{ Auth::user()->firstname }}" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="patronymic" class="col-sm-2 control-label">Отчество</label>
                    <div class="col-sm-10">
                        <input type="text" name="patronymic" class="form-control" id="patronymic" value="{{ Auth::user()->patronymic }}" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Изменить</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="password_change">
            <form action="{{ url('advertiser/profile/password') }}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="current_password" class="col-sm-2 control-label">Текущий пароль</label>
                    <div class="col-sm-10">
                        <input type="password" name="current_password" class="form-control" id="current_password" value="{{ Auth::user()->password }}" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password" class="col-sm-2 control-label">Новый пароль</label>
                    <div class="col-sm-10">
                        <input type="password" name="new_password" class="form-control" id="new_password" required="required" placeholder="Придумайте пароль">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="col-sm-2 control-label">Подтвердить пароль</label>
                    <div class="col-sm-10">
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required="required" placeholder="Повторите пароль">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Изменить пароль</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form class="form-inline" action="{{ url('advertiser/profile/amount') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputAmount">Amount</label>
                            <div class="input-group">
                                <div class="input-group-addon">₸</div>
                                <input style="width: 185px;" type="text" name="amount" class="form-control" id="exampleInputAmount" placeholder="Минимальная сумма 30тг"><br>
                                <div class="input-group-addon">.00</div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" style="margin-left: 25%; margin-top: 15px;">Отправить</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputAmount">Amount</label>
                        <div class="input-group">
                            <div class="input-group-addon">₸</div>
                            <input style="width: 192px;" type="text" name="amount" class="form-control" id="exampleInputAmount" placeholder="Сумма"><br>
                            <div class="input-group-addon">.00</div>
                        </div>
                    </div>
                    <a style="margin-left: 30%;" href="https://paybox.kz" target="_blank" class="btn btn-primary">Отправить</a>
                </div>
            </div>
        </div>
    </div>
@stop