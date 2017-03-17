function deleteNews(id) {
    var ans = confirm("Вы действительно хотите удалить?");
    if(ans){
        window.location.href = "/user/news/delete/"+id;
    }
}
function approve(id, route, param) {
    if(param){
        var ans = confirm("Вы хотите одобрить эту рекламу?");
        if (ans){
            window.location.href = "/"+route+"/"+param+"/"+id;
        }
    }else{
        var ans = confirm("Вы хотите одобрить эту новость?");
        if(ans){
            window.location.href = "/"+route+"/news/"+id;
        }
    }
}

function block(id, route, param) {
    if(param){
        var ans = confirm("Вы хотите блокировать эту рекламу?");
        if(ans){
            window.location.href = "/"+route+"/adv/block/"+id;
        }
    }else{
        var ans = confirm("Вы хотите блокировать эту новость?");
        if(ans){
            window.location.href = "/"+route+"/news/block/"+id;
        }
    }
}

function destroy(id, route, param) {
    if(param){
        var ans = confirm("Вы хотите удалить эту рекламу?");
        if(ans){
            window.location.href = "/"+route+"/adv/delete/"+id;
        }
    }else{
        var ans = confirm("Вы хотите удалить эту новость?");
        if(ans){
            window.location.href = "/"+route+"/news/delete/"+id;
        }
    }
}

// Блокировать пользователя
function spam(id) {
    var ans = confirm("Вы хотите блокировать пользователя?");
    if(ans){
        window.location.href = "/admin/user/block/"+id;
    }
}
// разблокировать пользователя
function despam(id) {
    var ans = confirm("Вы хотите разблокировать пользователя?");
    if(ans){
        window.location.href = "/admin/user/unblock/"+id;
    }
}
// Просмотр новости
function view_news(id,route) {
    if(route){
        window.open('http://xlink2.kz/moderator/post/'+id, '_blank');
    }
    window.open('http://xlink2.kz/admin/post/'+id, '_blank');
}
// Изменение позиции категории
function catPosition(id){
    var position = document.getElementById('position'+id).value;
    var ans = confirm("Вы хотите изменить позицию?");
    if(ans){
        window.location.href = "/admin/cat/"+id+"/position/"+position;
    }else{
        window.location.href = "/admin/cats";
    }
}