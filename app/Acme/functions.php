<?php
use App\Advertisements as ADV;
use App\Advertising_costs as ADVcost;
use App\Cats;
use App\Posts;
use App\Relation;
use App\User;
use App\Wrapping;
use App\Adv_cat;
use Illuminate\Support\Facades\DB;
use Jelovac\Bitly4laravel\Facades\Bitly4laravel as Bitly;
use App\post_click;
use App\PostUser;
# По ид категории получить его наименование
function get_cat_name($id){
    $id = (int) $id;
    $cat = Cats::find($id);
    return $cat['name'];
}
# По ид user а получить его логин
function get_user_login($id){
    $id = (int) $id;
    $user = User::find($id);
    return $user['login'];
}
# Определить на существования реферального ссылка
function check_exists($name){
    $user = User::where('login', '=',$name)->get();
    if(count($user) > 0){
        return true;
    }else{
        return false;
    }
}
# Получить ид пользователься по логин
function get_user_id_by_login($login){
    $user = User::where('login','=',$login)->get();
    return $user[0]->id;
}
# Определяет на уникальность рефералов
function check_refs($user_id,$refs_id){
    $result = Relation::where(['user_id' => $user_id, 'ref_id' => $refs_id])->get();
    if(count($result) > 0){
        return false;
    }else{
        return true;
    }
}
# Возвращает количество рефералов
function count_refs($user_id){
    $result = Relation::where('user_id','=',$user_id)->get();
    return count($result);
}
# По ид новости получить данные
function get_data_by_id_news($id){
    $news = Posts::find($id);
    return $news;
}
#
function youtube($video){
    $watch = "watch?v=";
    $embed = "embed/";
    $video = str_replace($watch, $embed,$video);
    return $video;
}
# По ип адреса получить идентификатор
function get_id_wrapping($ip){
    $result = Wrapping::where('ip_user','=',$ip)->get();
    return $result[0]->id;
}
# По ид поста получить доход из таблицы advertising_costs
function get_profit($id_post, $id_user){
    $result = ADVcost::where(['id_post' => $id_post, 'id_user' => $id_user])->get();
    if(count($result) > 1){
        $profit = 0;
        for($i=0; $i<count($result); $i++){
            $profit = $profit + $result[$i]->paid;
        }
        return $profit;
    }elseif(count($result) == 1){
        return $result[0]->paid;
    }else{
        return 0;
    }
}
# Посчитать кол-во рекламу по ид рекламодателя
function get_count_adv($id){
    $result = ADV::where('id_advertiser', '=', $id)->get();
    return count($result);
}
# Посчитать кол-во одобренных рекламы
function get_count_check_adv($id){
    $result = ADV::where(['id_advertiser' => $id, 'status' => 1])->get();
    return count($result);
}
# Посчитать кол-во оплаченных рекламы
function get_count_pay_adv($id){
    //$result =
}
# Получить наименование категории если их несколько
function get_cats_name($id_adv){
    $cats = Adv_cat::where(['id_adv' => $id_adv])->get();
    if(count($cats) > 1){
        $str = "";
        for($i=0; $i<count($cats); $i++){
            $str .= get_cat_name($cats[$i]->id_cat) .",";
        }
        return trim($str,",");
    }else{
        return get_cat_name($cats[0]->id_cat);
    }
}
# По ид рекламы получить его наименование
function get_adv_name_by_id($id_adv){
    $name = ADV::find($id_adv);
    return $name->title;
}
# По ид новости получить его наименование
function get_post_name_by_id($id_post){
    $name = Posts::find($id_post);
    return $name['title'];
}
# По ид испольнителя получить его доход
function get_all_profit($id_user){
    $data = DB::table('advertising_costs')
                    ->select(DB::raw('sum(paid) as paid'))
                    ->whereIn('id_post', function($query) use ($id_user){
                        $query->select(DB::raw('id'))
                              ->from('posts')
                              ->where(['id_user' => $id_user]);
                    })
                    ->where(['id_user' => $id_user])
                    ->get();
    return $data;
}
#
function check_post_user($id_user, $id_post){
    $result = Posts::where(['id_user' => $id_user, 'id' => $id_post])->get();
    if(count($result) > 0){
        return true;
    }
    return false;
}
# Функция преобразует время опубликованных новостей
function convert_date_news($date, $id_post){
    $result = DB::select(DB::raw("SELECT (UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(p.created_at)) AS sec FROM posts p WHERE p.id = $id_post"));
    $sec = $result[0]->sec;
    $min = round(round($sec) / 60);
    $hour = round(round($min) / 60);
    $day = round(round($hour) / 24);
    if($sec <= 60){
        return "только что";
    }
    if($sec > 60 AND $sec < 3600){
        return $min . " минут назад";
    }
    if($sec >= 3600 AND $sec < 86400){
        return $hour . " час назад";
    }
    if($sec == 86400){
        return $day . " день назад";
    }
    if($sec > 86400 AND $sec <= 345600){
        return $day . " дня назад";
    }
    if($sec > 345600 AND $sec < 604800){
        return $day . " дней назад";
    }
    if($sec >= 604800 AND $sec < 1209600){
        return "1 неделя назад";
    }
    if($sec >= 1209600 AND $sec < 1814400){
        return "3 неделя назад";
    }
    if($sec > 1814400){
        return "месяц назад";
    }
}
# Функция сокращает ссылку
function short_link($long_link){
	$bit = Bitly::shorten($long_link);
	$unique_link = $bit['data']['url'];
	return $unique_link;
}
# Определяем роль пользоватьтеля
function get_role_of_user($user_id){
    $user = User::find($user_id);
    $str = "";
    foreach($user->roles as $role){
        $str .= $role->title . ",";
    }
    return trim($str,",");
}
# Посчитать общее кол-во новостей
function get_all_count_of_news(){
    $posts = Posts::all();
    return count($posts);
}
# Посчитать кол-во зарегистрированных пользователей
function get_all_count_of_users(){
    $users = User::all();
    $admin = 0; $moderator = 0; $advertiser = 0; $executer = 0; $draw = 0;
    for($i=0; $i<count($users); $i++){
        $user = User::find($users[$i]->id);
        foreach($user->roles as $role){
            switch ($role->title){
                case "admin":
                    $admin += 1;
                    break;
                case "moderator":
                    $moderator += 1;
                    break;
                case "advertiser":
                    $advertiser += 1;
                    break;
                case "executer":
                    $executer += 1;
                    break;
                case "draw":
                    $draw += 1;
                    break;
            }
        }
    }
    $all = $admin+$advertiser+$executer+$moderator+$draw;
    $str = "Всего: $all чел. Из них: Администратор - ".$admin." чел., Модератор - ".$moderator." чел., Рекламодатель - ".$advertiser." чел., Исполнитель - ".$executer." чел., Розыгрыш - ".$draw." чел.";
    return $str;
}
# Получить название клик категории
function get_post_click_cat_title($id){
    $click = post_click::find($id);
    return $click['title'];
}
# Генерируем подсказку для ссылок
function get_post_click_cat_alt($id){
    $click = post_click::find($id);
    $str = "Вы получаете ". $click['price_click'] ." тг. за каждый уникальный переход + " .$click['percent']. "% от покупок при условии достижения конверсии не менее 2%. Переходы засчитываются из любой страны Мира.";
    return $str;
}
# По ид поста и пользователя получить ссылку
function get_user_post_link($id_user,$id_post){
    $result = PostUser::where(['id_post' => $id_post, 'id_user' => $id_user])->first();
    return $result['bitly_link'];
}
#
function getNumberConversion($id_user,$id_post){
    $result = Wrapping::where(['id_user' => $id_user, 'id_post' => $id_post])->get();
    return count($result);
}