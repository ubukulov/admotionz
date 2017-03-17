<!DOCTYPE html>
<html lang="en" style="height:100%;">
<head>
    <meta charset="utf-8">
    <title>Admotionz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Admotionz" />
    <meta name="description" content="Admotionz website" />
    <link rel="shortcut icon" href="ico/favicon.png">
    <meta name="verify-admitad" content="9fd7fe7f36" />
    <!-- Core CSS -->
    <link href="{{ asset('draw/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('draw/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Style Library -->
    <link href="{{ asset('draw/css/style-library-1.css') }}" rel="stylesheet">
    <link href="{{ asset('draw/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('draw/css/blocks.css') }}" rel="stylesheet">
    <link href="{{ asset('draw/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('draw/css/draw.css') }}" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{ asset('draw/js/html5shiv.js') }}"></script>
    <script src="{{ asset('draw/js/respond.min.js') }}"></script>
    <![endif]-->
    <link href="{{ asset('draw/css/bootstrap-material-design.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('draw/css/fa-viber.css') }}" rel="stylesheet" type="text/css">
	<!-- Put this script tag to the <head> of your page -->
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>

	<script type="text/javascript">
	  VK.init({apiId: 5772123, onlyWidgets: true});
	</script>
	<script src="https://vk.com/js/api/openapi.js?136" type="text/javascript"></script>
</head>
<body data-spy="scroll" data-target="nav">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@yield('content')

<script type="text/javascript" src="{{ asset('draw/js/jquery-1.11.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('draw/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('draw/js/material.js') }}"></script>
<script type="text/javascript" src="{{ asset('draw/js/ripples.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('draw/js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('draw/js/nouislider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('draw/js/bskit-scripts.js') }}"></script>
<script>
    $.material.init();
</script>
<script>
    $(function () {
        $.material.init();
        $(".shor").noUiSlider({
            start: 40,
            connect: "lower",
            range: {
                min: 0,
                max: 100
            }
        });

    });
</script>
</body>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Авторизация</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('/drawing/auth') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" name="login" class="form-control" placeholder="Логин" required="required">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" class="form-control" placeholder="Пароль" required="required">
                    </div>
                    <button type="submit" class="btn btn-success">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/clipboard.min.js') }}"></script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5805e4155134c647"></script>
<script>
    (function(){
        var clipboard = new Clipboard('#copy_button');
        clipboard.on('success', function(e) {
            console.log(e);
            $('#copy_button').html("<span class='fa fa-copy'></span> Скопировано");
            window.setTimeout(function(){
                $('#copy_button').html("<span class='fa fa-copy'></span> Копировать");
            }, 5000);
        });

        clipboard.on('error', function(e) {
            console.log(e);
        });
    })();
</script>
</html>
