<?php

namespace App\Http\Controllers;

use App\Cats;
use App\Events\Event;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use App\Advertisements as ADV;
use App\Events\PostHasViewed;
use App\Wrapping;
use Illuminate\Support\Facades\Redirect;
use App\Advertising_costs as ADVcost;
use Illuminate\Support\Facades\Auth;
use App\Pages;
use App\PostView;
use Cache;

class IndexController extends Controller
{
    public static $header = false;
    protected $ip;
    # Admitad
    protected $clientId = "d9cd15eaac63b4a47ef568dd268717";
    protected $clientSecret = "d850e7fae59786b948dc1c777d3ba3";
    protected $website_admotionz_id = 525788;
    protected $website_likemoney_id = 479947;

	public function __construct(){
        if(!Cache::has('cat')){
            Cache::put('cat',Cats::orderBy('position')->get(),30);
        }
        if(!Cache::has('last_two')){
            $last_two = DB::table('posts')->where('status','=',1)->orderBy('created_at', 'DESC')->limit(2)->get();
            Cache::put('last_id',$last_two[1]->id,10);
            Cache::put('last_two',$last_two,10);
        }
        $this->getLocation();
	}
    
    public function welcome(Request $request){
        $cat = Cache::get('cat');
        $last_two = Cache::get('last_two');
        if(Cache::has('main_offers')){
            $posts = Cache::get('main_posts');
        }else{
            $posts = $users = DB::table('posts')->where([['status','=',1],['id', '<', Cache::get('last_id')]])->orderBy('created_at', 'DESC')->paginate(102);
            Cache::put('main_posts',$posts,10);
        }

        # сокращяем ссылки
        Posts::setShortLink();

//        if(isset($_GET['refs'])){
//            $refs = $_GET['refs'];
//            if(check_exists($refs)){
//                if(!$request->cookie('refs')){
//                    $response = new Response(view('welcome',compact('cat','posts')));
//                    $response->withCookie(cookie('refs',$refs,10080));
//                    return $response;
//                }
//            }
//        }

        return view('welcome', compact('cat','posts','last_two'));
    }

    public function cat($id){
        $id = (int) $id;
        $cat = Cache::get('cat');
        $last_two = Cache::get('last_two');
        switch ($id){
            # Admitad offers
            case 37:
                $api = new \Admitad\Api\Api();
                $scope = 'advcampaigns_for_website';
                if(Cache::has('ad_offers')){
                    $ad_offers = Cache::get('ad_offers');
                }else{
                    $authorizeResult = $api->authorizeClient($this->clientId, $this->clientSecret, $scope)->getArrayResult();
                    $api = new \Admitad\Api\Api($authorizeResult['access_token']);
                    $data1 = $api->get("/advcampaigns/website/{$this->website_admotionz_id}/", array(
                        'connection_status' => 'active', 'limit' => 500
                    ))->getArrayResult();
                    $data2 = $api->get("/advcampaigns/website/{$this->website_likemoney_id}/", array(
                        'connection_status' => 'active', 'limit' => 500
                    ))->getArrayResult();
                    $ad_offers = array_merge($data1,$data2);
                    $offers = array();
                    if(Cache::has('country_code')){
                        foreach($ad_offers['results'] as $key=>$value){
                            foreach($value['regions'] as $k=>$v){
                                if($v['region'] == Cache::get('country_code')){
                                    $offers['results'][] = $value;
                                }
                            }
                        }
                        Cache::put('ad_offers', $offers, 30);
                        $ad_offers = $offers;
                    }else{
                        Cache::put('ad_offers', $ad_offers, 30);
                    }
                }
                return view('welcome', compact('cat','ad_offers','last_two'));
                break;
            # Admitad coupons
            case 14:
                $api = new \Admitad\Api\Api();
                $scope = 'coupons_for_website';
                if(Cache::has('ad_coupons')){
                    $ad_coupons = Cache::get('ad_coupons');
                }else{
                    $authorizeResult = $api->authorizeClient($this->clientId, $this->clientSecret, $scope)->getArrayResult();
                    $api = new \Admitad\Api\Api($authorizeResult['access_token']);
                    $data1 = $api->get("/coupons/website/{$this->website_admotionz_id}/", array(
                        'status' => 'active', 'limit' => 500
                    ))->getArrayResult();
                    $data2 = $api->get("/coupons/website/{$this->website_likemoney_id}/", array(
                        'status' => 'active', 'limit' => 500
                    ))->getArrayResult();
                    $ad_coupons = array_merge($data1,$data2);
                    Cache::put('ad_coupons', $ad_coupons, 30);
                }
                return view('welcome', compact('cat','ad_coupons','last_two'));
                break;
        }
        $posts = DB::table('posts')->where(['id_cat' => $id, 'status' => 1])->orderBy('updated_at', 'DESC')->paginate(10);
        return view('welcome', compact('cat','posts','last_two'));
    }

    public function post($id){
        $id = (int) $id;
        $cat = Cache::get('cat');
        $post = Posts::find($id);
        self::$header = true;
        $ip = $_SERVER['REMOTE_ADDR']; // Ип адрес пользователя
        // обновить количество просмотр
        if(PostView::exists($id,$ip)){
            if(PostView::check_user_for_view_post($id,$ip)){
                Posts::update_view_count($id);
                PostView::update_time($id,$ip);
            }
        }else{
            PostView::create([
                'id_post' => $id, 'ip_user' => $ip
            ]);
            Posts::update_view_count($id);
        }
		
		if(!empty($post->body)){
			return view('post', compact('cat', 'post'));
		}else{
			//return Redirect::intended($post->link_source);
			return redirect()->away($post->link_source);
		}
    }

    public function adv($id){
        $id = (int) $id; // Ид новости
        $id_user = Posts::get_user_id($id); // Ид испольнителя
        $post = Posts::find($id);
        $ip = $_SERVER['REMOTE_ADDR']; // Ип адрес пользователя
        $current_date = date("Y-m-d H:i:s"); // текущая время
        // обновить количество просмотр
        if(PostView::exists($id,$ip)){
            if(PostView::check_user_for_view_post($id,$ip)){
                Posts::update_view_count($id);
                PostView::update_time($id,$ip);
            }
        }else{
            PostView::create([
                'id_post' => $id, 'ip_user' => $ip
            ]);
            Posts::update_view_count($id);
        }
        if($this->get_advertisements()){
            if((Auth::check()) AND (Auth::user()->role <= 2)){
                $adv = DB::table('advertisements')->where(['publish' => 1, 'status' => 1])->inRandomOrder()->first();
                return view('adv',compact('adv','post'));
            }
            $adv = $this->get_advertisements();
            if(isset($_SERVER['HTTP_REFERER'])){
                $host = $_SERVER['HTTP_REFERER'];
            }
            if(!Wrapping::exists($ip)){
                $data['ip_user'] = $ip;
                Wrapping::create($data);
                $adv_cost = [
                    'id_adv' => $adv->id, 'id_user' => $id_user, 'id_post' => $id, 'paid' => User::get_amount($adv->id_advertiser)
                    //'host_name' => $_SERVER['HTTP_REFERER']
                ];
                if(!empty($host)){
                    $adv_cost['host_name'] = $host;
                }
                ADVcost::create($adv_cost);
                User::withdraw_money($adv->id_advertiser);
                return view('adv',compact('adv','post'));
            }
            if(Wrapping::limit($current_date) >= 21600){
                // Прошел 6 часов
                $data['updated_at'] = $current_date;
                $wrapping = Wrapping::findOrFail(get_id_wrapping($ip));
                $wrapping->update($data);
                // Снимаем с рекламного депозита 30 тенге и зачисляем на счет испольнителя
                $adv_cost = [
                    'id_adv' => $adv->id, 'id_user' => $id_user, 'id_post' => $id, 'paid' => User::get_amount($adv->id_advertiser)
                    //'host_name' => $_SERVER['HTTP_REFERER']
                ];
                if(!empty($host)){
                    $adv_cost['host_name'] = $host;
                }
                ADVcost::create($adv_cost);
                User::withdraw_money($adv->id_advertiser);
                return view('adv',compact('adv','post'));
            }
            if(!empty($post->body)){
                return Redirect::intended('article/'.$id);
            }else{
				$adv = DB::table('advertisements')->where(['publish' => 1, 'status' => 1])->inRandomOrder()->first();
                return view('adv',compact('adv','post'));
                //return Redirect::intended($post->link_source);
                //return redirect()->away($post->link_source);
            }

        }else{
            // если нет рекламы
            return Redirect::intended('post/'.$id);
        }
    }
    # Получаем список рекламы
    public function get_advertisements(){
        if((Auth::check()) AND (Auth::user()->role <= 2)){
            return $adv = DB::table('advertisements')->where(['publish' => 1, 'status' => 1])->inRandomOrder()->first();
        }else{
            $adv = DB::table('advertisements')
                ->whereIn('id_advertiser', function($query){
                    $query->select(DB::raw('id'))
                        ->from('users')
                        ->where([['deposit', '>=', 30], ['block', '=', 0]]);
                })
                ->where(['publish' => 1, 'status' => 1])
                ->inRandomOrder()->first();
            return $adv;
        }
    }
    # Если испольнител распространиль ссылки
    public function ref($login, $id){
        $id = (int) $id; // Ид новости
        $id_user = get_user_id_by_login($login); // Ид испольнителя
        $post = Posts::find($id);
        $ip = $_SERVER['REMOTE_ADDR']; // Ип адрес удаленного пользователя
        $current_date = date("Y-m-d H:i:s"); // текущая время



        if($this->get_advertisements()){
            if((Auth::check()) AND (Auth::user()->role <= 2)){
                $adv = DB::table('advertisements')->where(['publish' => 1, 'status' => 1])->inRandomOrder()->first();
                return view('adv',compact('adv','post'));
            }
            $adv = $this->get_advertisements();
            if(isset($_SERVER['HTTP_REFERER'])){
                $host = $_SERVER['HTTP_REFERER'];
            }
            if(!Wrapping::exists($ip)){
                $data['ip_user'] = $ip;
                Wrapping::create($data);
                $adv_cost = [
                    'id_adv' => $adv->id, 'id_user' => $id_user, 'id_post' => $id, 'paid' => User::get_amount($adv->id_advertiser)
                    //'host_name' => $_SERVER['HTTP_REFERER']
                ];
                if(!empty($host)){
                    $adv_cost['host_name'] = $host;
                }
                ADVcost::create($adv_cost);
                User::withdraw_money($adv->id_advertiser);
                return view('adv',compact('adv','post'));
            }
            if(Wrapping::limit($current_date) >= 0){
                // Прошел 6 часов
                $data['updated_at'] = $current_date;
                $wrapping = Wrapping::findOrFail(get_id_wrapping($ip));
                $wrapping->update($data);
                // Снимаем с рекламного депозита 30 тенге и зачисляем на счет испольнителя
                $adv_cost = [
                    'id_adv' => $adv->id, 'id_user' => $id_user, 'id_post' => $id, 'paid' => User::get_amount($adv->id_advertiser)
                    //'host_name' => $_SERVER['HTTP_REFERER']
                ];
                if(!empty($host)){
                    $adv_cost['host_name'] = $host;
                }
                ADVcost::create($adv_cost);
                User::withdraw_money($adv->id_advertiser);
                return view('adv',compact('adv','post'));
            }
            if(!empty($post->body)){
                return Redirect::intended('post/'.$id);
            }else{
                return Redirect::intended($post->link_source);
            }

        }else{
            // если нет рекламы
            return Redirect::intended('post/'.$id);
        }
    }
    # Страница О нас
    public function about(){
        $page = Pages::find(1);
        $cat = Cache::get('cat');
        return view('about', compact('page','cat'));
    }
    # Страница Исполнителям
    public function executant(){
        $page = Pages::find(2);
        $cat = Cache::get('cat');
        return view('executant', compact('page', 'cat'));
    }
    # Страница Рекламодателям
    public function advertiser(){
        $page = Pages::find(3);
        $cat = Cache::get('cat');
        return view('advertiser', compact('page', 'cat'));
    }
    # Страница Помощь
    public function help(){
        $page = Pages::find(4);
        $cat = Cache::get('cat');
        return view('help', compact('page','cat'));
    }
    # Страница Контакты
    public function contacts(){
        $page = Pages::find(5);
        $cat = Cache::get('cat');
        return view('contacts', compact('page', 'cat'));
    }

    public function admitad(){
        $count = country();
        dd($count);
        $cat = Cache::get('cat');
        $api = new \Admitad\Api\Api();
        $clientId = "d9cd15eaac63b4a47ef568dd268717";
        $clientSecret = "d850e7fae59786b948dc1c777d3ba3";
        $scope = 'advcampaigns_for_website';
		if(Cache::has('ad_offers')){
            $data = Cache::get('ad_offers');
        }else{
            $authorizeResult = $api->authorizeClient($clientId, $clientSecret, $scope)->getArrayResult();
            $api = new \Admitad\Api\Api($authorizeResult['access_token']);
            $admotionz_id = 525788;
            $likemoney_id = 479947;
            $advertId = 2598; // <- Quelle ID
            $data1 = $api->get("/advcampaigns/website/{$admotionz_id}/", array(
                'connection_status' => 'active', 'limit' => 500
            ))->getArrayResult();
            $data2 = $api->get("/advcampaigns/website/{$likemoney_id}/", array(
                'connection_status' => 'active', 'limit' => 500
            ))->getArrayResult();
            $data = array_merge($data1,$data2);
            Cache::put('ad_offers', $data, 30);
        }
		
		return view('admitad', compact('data','cat'));
    }
    # По ип адресу определить местоположение пользователя
    public function getLocation(){
        if(!Cache::has('country_code')){
            $file = $_SERVER['DOCUMENT_ROOT'] . "/lib/SxGeo.dat";
            $SxGeo = new \App\SxGeo($file);
            $country_code = $SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
            switch ($country_code){
                case "KZ":
                    Cache::put('country_first_name',"КАЗАХСТАН",60);
                    Cache::put('country_second_name',"РОССИЯ",60);
                    Cache::put('country_first_code',"KZ",60);
                    Cache::put('country_second_code',"RU",60);
                    break;
                case "RU":
                    Cache::put('country_first_name',"РОССИЯ",60);
                    Cache::put('country_second_name',"КАЗАХСТАН",60);
                    Cache::put('country_first_code',"RU",60);
                    Cache::put('country_second_code',"KZ",60);
                    break;
                default:
                    Cache::put('country_first_name',"КАЗАХСТАН",60);
                    Cache::put('country_second_name',"РОССИЯ",60);
                    Cache::put('country_first_code',"KZ",60);
                    Cache::put('country_second_code',"RU",60);
                    break;
            }
        }
    }
    # Установливаем местоположение пользователя по его выбору
    public function setLocation(Request $request){
        $data = $request->all();
        if(array_key_exists('KZ',$data)){
            Cache::put('country_code',"KZ",60);
        }else{
            Cache::put('country_code',"RU",60);
        }
        return redirect()->back();
    }
}
