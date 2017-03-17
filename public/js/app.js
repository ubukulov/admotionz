$(document).ready(function () {
    var adv_url = $("#adv_url").val();
    // $("#post_url").click(function(){
    //     var h = screen.height;
    //     var w = screen.width;
    //     var adv_url = $("#adv_url").val();
    //     var post_url = $("#post_url").attr('href');
    //     window.location.href = post_url;
    //     window.open(adv_url);
    // });
});

function post_url() {
    var post_url = document.getElementById('post_url').getAttribute('href');
    var adv_url = document.getElementById('adv_url').value;
    window.location.href = adv_url;
    window.open(post_url);
}

// Функция копирование
function copy_func(copy_button_id){
	(function(){
		var clipboard = new Clipboard('#'+copy_button_id);
		clipboard.on('success', function(e) {
			console.log(e);
			$('#'+copy_button_id).html("<span class='fa fa-copy'></span> Скопировано");
			window.setTimeout(function(){
				$('#'+copy_button_id).html("<span class='fa fa-copy'></span> Копировать");
			}, 5000);
		});

		clipboard.on('error', function(e) {
			console.log(e);
		});
	})();	
}