$(document).ready(function ($) {

    $("#vid").hide();
    $("#video").attr({'required' : false});
    $("#capvid1").click(function () {
        $("#vid").hide();
        $("#video").val('');
        $("#im").show();
        $("#video").attr({'required' : false});
    });
    $("#capvid2").click(function () {
        $("#vid").show();
        $("#im").hide();
        $("#img").attr({'required' : false});
    });

    CKEDITOR.replace('body',{
        filebrowserBrowseUrl : '../../lib/filemanager/dialog.php?type=1&editor=ckeditor&fldr=',
        filebrowserUploadUrl : '../../lib/filemanager/dialog.php?type=1&editor=ckeditor&fldr=',
        filebrowserImageBrowseUrl : '../../lib/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
    });
});
