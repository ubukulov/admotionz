<?php

namespace App\Http\Controllers\Draw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Jelovac\Bitly4laravel\Bitly4laravel;
use Mockery\CountValidator\Exception;
use phpDocumentor\Reflection\Types\This;
use Validator;
//use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\DrawingStatistics;
use App\RoleUser;
use App\Drawing;
use App\DrawingStatistics as DrawStat;
use App\DrawingWrapping as DrawWrap;
use App\ConfirmUser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\Factory;
use Jelovac\Bitly4laravel\Facades\Bitly4laravel as Bitly;
use App\Posts;

class IndexController extends Controller
{
    protected $user_id;

    public function index(Request $request){
        $all_count = DrawingStatistics::all_count();
        $participants = Drawing::getCountDrawParticipants();
        $draw_participants = DrawingStatistics::getDrawParticipants();
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $posts = Posts::where(['filter' => 1])->get();
        // Аутентификация по ип адресу
        if(Drawing::authWithIp($user_ip)){
            Auth::loginUsingId(Drawing::getUserIdByIp($user_ip));
            $this->user_id = Auth::user()->id;
            $user = User::find($this->user_id);
            $role = $user->roles[0]->title;
            $count = DrawingStatistics::count($this->user_id);
            $other = env('DRAW_COUNT') - $all_count;
            $drawing = Drawing::where(['user_id' => $this->user_id])->first();
            $bit = Bitly::shorten('https://admotionz.com/drawing/'.$drawing->user_id.'/'.$drawing->token);
            $unique_link = $bit['data']['url'];
            $drawing_list = Drawing::all();
            $place = 0;
            foreach($draw_participants as $key=>$val){
                if($val->user_id == $this->user_id){
                    $place = $key+1;
                }
            }
            return view('draw/index', compact('all_count', 'role', 'count', 'other', 'drawing', 'drawing_list', 'draw_participants','participants','place','unique_link', 'posts'));
        }
        if(Auth::check()){
            $this->user_id = Auth::user()->id;
            $user = User::find($this->user_id);
            foreach($user->roles as $role){
                if($role->title == 'draw'){
                    $role = $role->title;
                    $count = DrawingStatistics::count($this->user_id);
                    $other = env('DRAW_COUNT') - $all_count;
                    $drawing = Drawing::where(['user_id' => $this->user_id])->first();
                    $bit = Bitly::shorten('https://admotionz.com/drawing/'.$drawing->user_id.'/'.$drawing->token);
                    $unique_link = $bit['data']['url'];
                    $drawing_list = Drawing::all();
                    $place = 0;
                    foreach($draw_participants as $key=>$val){
                        if($val->user_id == $this->user_id){
                            $place = $key+1;
                        }
                    }
                    return view('draw/index', compact('all_count', 'role', 'count', 'other', 'drawing', 'drawing_list', 'draw_participants','participants','place','unique_link','posts'));
                }
            }
        }

        $arr_num = [
            'ноль', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'
        ];
        $n = array_rand($arr_num,1);
        $num1 = $arr_num[$n];
        $num2 = rand(0,20);
        $response = new Response(view('draw/index', compact('all_count', 'draw_participants','participants', 'num1', 'num2', 'posts')));
        $response->withCookie(cookie('num1',$n,0));
        $response->withCookie(cookie('num2',$num2,0));
        return $response;


        //return view('draw/index', compact('all_count', 'draw_participants','participants', 'num1', 'num2'));
    }

    public function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, User::$roles);
        if($validator->fails()) {
            return redirect('/drawing')->withErrors($validator)->withInput();
        }
        if(($request->cookie('num1') + $request->cookie('num2')) != (int) $data['captcha']){
            return Redirect::back()->with('message', 'Вы неправильно посчитали.');
        }
        if(User::exists($data['email'])){
            return redirect('/drawing');
        }else{
            DB::transaction(function() use ($data){
                try{
                    $data['block'] = 1;
                    $login = trim($this->generateLogin());
                    $pass = trim(rand(100000, 999999));
                    $data['login'] = $login;
                    $data['password'] = trim(Hash::make($pass));
                    $lastInsertId = User::create($data)->id;
                    $token = trim(Str::random(30));
                    $bit = Bitly::shorten('https://admotionz.com/drawing/'.$lastInsertId.'/'.$token);
                    $unique_link = $bit['data']['url'];

                    RoleUser::create([
                        'user_id' => $lastInsertId, 'role_id' => 5
                    ]);
                    Drawing::create([
                        'user_id' => $lastInsertId, 'token' => $token, 'ip' => $_SERVER['REMOTE_ADDR']
                    ]);
                    Mail::send('draw.confirm', ['token' => $token, 'id' => $lastInsertId, 'login' => $login, 'pass' => $pass, 'unique_link' => $unique_link], function($u) use ($data){
                        $u->from(env('MAIL_USERNAME'));
                        $u->to($data['email']);
                        $u->subject('Вы успешно зарегистрировались');
                    });
                }
                catch(Exception $e){
                    DB::rollback();
                }
                DB::commit();
            });
            return redirect('/drawing')->with('message', "Регистрация успешно завершено. Данные отправлены на почту.");
        }
    }
    # метод подсчитывает переходы по уникальному ссылку каждого пользователя
    public function drawing($id, $token){
        $ip_user = $_SERVER['REMOTE_ADDR'];
        $current_date = date("Y-m-d H:i:s");
        if(Drawing::check_user_by_id_and_token($id, $token)){
            $drawing_id = Drawing::check_user_by_id_and_token($id, $token);
            // если в таблице drawing_wrapping нет записей по этой ип адресу, то мы зафиксируем его
            if(!DrawWrap::exists($ip_user)){
                // таблица drawing_wrapping
                DrawWrap::create([
                    'ip_user' => $ip_user
                ]);
                // таблица drawing_statistics
                DrawStat::create([
                    'drawing_id' => $drawing_id, 'ip' => $ip_user
                ]);
                // за каждый уникальный переход по ссылкам прибавляем 5 тенге владелцу ссылок
                $drawing = Drawing::findOrFail($drawing_id);
                $drawing->balance = ($drawing->balance) + 5;
                $drawing->save();
            }
            // если есть записей по этой ип адресу в таблице drawing_wrapping, то мы проверяем на время
            if(DrawWrap::limit($current_date) >= 86400){
                // Прошел 24 часа
                // таблица drawing_statistics
                DrawStat::create([
                    'drawing_id' => $drawing_id, 'ip' => $ip_user
                ]);
                // обновляем поля updated_at в таблице drawing_wrapping по ип адресу
                $id_draw_wrap = DrawWrap::getId($ip_user);
                if($id_draw_wrap){
                    $draw_wrapping = DrawWrap::findOrFail($id_draw_wrap);
                    $draw_wrapping->update([
                        'updated_at' => $current_date
                    ]);
                }
                // за каждый уникальный переход по ссылкам прибавляем 5 тенге владелцу ссылок
                $drawing = Drawing::findOrFail($drawing_id);
                $drawing->balance = ($drawing->balance) + 5;
                $drawing->save();
            }
            //return redirect('/drawing');
            return view('draw/advertisement');
        }else{
            dd("Ошибка");
        }
    }

    public function confirm($token){
        $model = ConfirmUser::where(['token' => $token])->firstOrFail();
        $email = $model->email;
        $user = User::where(['email' => $email])->first();
        $user->block = 0;
        $firstname = $user->firstname;
        $lastname  = $user->lastname;
        $login = trim($this->generateLogin());
        $pass = trim(rand(100000, 999999));
        $user->login = $login;
        $user->password = trim(Hash::make($pass));
        $user->save();
        $model->delete();
        Mail::send('draw.mail', ['login' => $login,'pass' => $pass, 'firstname' => $firstname, 'lastname' => $lastname], function($u) use ($user){
            $u->from(env('MAIL_USERNAME'));
            $u->to($user->email);
            $u->subject('Подтверждение электронного ящика');
        });
        return redirect('/drawing')->with('message', "Подтвержение закончено. На почту $email отправлено логин и пароль.");
    }
    
    public function auth(Request $request){
        if(Auth::attempt(['login' => trim($request->login), 'password' => trim($request->password)])){
            return redirect()->intended('/drawing/account');
        }else{
            dd("ERROR");
        }
    }

    public function account(){
        $drawing = Drawing::where(['user_id' => Auth::user()->id])->firstOrFail();
        $bit = Bitly::shorten('https://admotionz.com/drawing/'.$drawing->user_id.'/'.$drawing->token);
        $unique_link = $bit['data']['url'];
        $count = DrawingStatistics::count(Auth::user()->id);
        $drawing_statistics = DrawingStatistics::getDrawStatistics(Auth::user()->id);
        return view('draw/account', compact('drawing', 'drawing_statistics', 'count','unique_link'));
    }
    # generate a unique login for user
    public function generateLogin(){
        $login = Str::lower(Str::random(8));
        $result = User::where(['login' => $login])->first();
        if(count($result) > 0){
            $this->generateLogin();
        }else{
            return $login;
        }
    }
    # change avatar
    public function avatar(){
        $drawing = Drawing::where(['user_id' => Auth::user()->id])->firstOrFail();
        $type = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
        ];
        if(Input::hasFile('file')){
            if(Input::file('file')->isValid()){
                $file = Input::file('file');
                $size = $file->getSize();
                $ext  = $file->getClientOriginalExtension();
                $mime  = $file->getMimeType();
                if(($size > 1000000) || !(in_array($mime, $type))) {
                    return Redirect::back()->with('message', "Размер или разрешение файла не соответствует");
                }
                $filename = md5(time()) . ".$ext";
                $destination = "draw/images/profile/";
                $file->move($destination, $filename);
                $path = $destination.$filename;
                if(!empty($drawing->img)){
                    unlink($drawing->img);
                }
                $drawing->img = $path;
                $drawing->save();
                return Redirect::back()->with('message', "Аватар успешно обновлен.");
            }
        }else{
            return Redirect::back()->with('message', "Не удалось загрузить файл");
        }
    }
    # change personal data
    public function settings(Request $request){
        $firstname = htmlspecialchars(strip_tags($request->firstname));
        $lastname  = htmlspecialchars(strip_tags($request->lastname));
        $phone     = htmlspecialchars(strip_tags($request->phone));
        $user = User::find(Auth::user()->id);
        $user->firstname = $firstname;
        $user->lastname  = $lastname;
        $user->phone     = $phone;
        $user->password  = Hash::make($request->password);
        $user->save();
        return Redirect::back()->with('message', 'Успешно обновлена');
    }

    # Авторизация по уникальную ссылку
    public function authenticate($id, $token){
        $id = (int) $id;
        $result = Drawing::where(['user_id' => $id, 'token' => $token])->get();
        if(count($result) > 0){
            Auth::loginUsingId($id);
            return redirect()->intended('/drawing/account');
        }else{
            return Redirect::back();
        }
    }
}
