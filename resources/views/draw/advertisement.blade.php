@extends('draw/core')
@section('content')
    <div class="row" style="width: 545px; margin: 0 auto;">
        @if((rand(1,14) % 2) == 0)
        <h3 style="text-align: center;">Выгодная покупка!</h3>
        <script type="text/javascript">
            (function (w, d) {
                var host = "widget.admitad.com";
                var js, id = host.replace(/[^a-z0-9]/g,''), ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                window._adwid_config = {host: host};
                js = d.createElement('script'); js.id = id; js.async = true; js.charset = 'utf-8';
                js.src = '//' + host + '/js/widget.js?r' + ((new Date()).getTime()/3600000|0);
                ref.parentNode.insertBefore(js, ref);
            }(window, document));
        </script>
        <script id="0c6ba566" data-id="15540">
            window._adwid = window._adwid || [];
            window._adwid.push("0c6ba566")
        </script>
        @else
        <h3 style="text-align: center;">Получай скидки + cashback в более 200 магазинах!</h3>
            <a href="http://likemoney.me/cashback" target="_blank"><img src="{{ asset('/draw/images/cashback.jpg') }}" alt="cashback"></a>
        @endif
    </div>
    <div class="row" style="width: 1000px; margin: 20px auto; text-align: center;">
        <a class="btn btn-success" onclick="openSiteAdvertiser();" href="{{ url('/drawing') }}" target="_blank">Перейти на сайт розыгрыша</a>
    </div>

    <center>
        <h4 style="margin-top: 50px; border: 1px solid #ccc; padding: 10px;font-size: 12px; width: 470px;">
            <strong>Внимание реклама!</strong><br>
            Мы очень любим наших пользователей, поэтому заранее предупреждаем Вас о том, что при нажатии на кнопку "Перейти на сайт розыгрыша" Вам откроется дополнительно сайт рекламодателя.
        </h4>
    </center>
    <script>
        function openSiteAdvertiser() {
            window.location = "http://likemoney.me/cashback";
        }
    </script>
@stop