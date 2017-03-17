<?php

use App\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Http\Request;
use App\Payments;
use App\Pages;
use App\Cats;

Route::get('/', ['as' => '/', 'uses' => 'IndexController@welcome']);
Route::get('/cat/{id}','IndexController@cat');
Route::get('post/{id}', 'IndexController@post')->where(['id' => '[1-9][0-9]*']);
Route::get('article/{id}', 'IndexController@post')->where(['id' => '[1-9][0-9]*']);
Route::get('user/post/{id}', ['as' => 'adv', 'uses' => 'IndexController@adv']);
Route::get('user/{login}/post/{id}', 'IndexController@ref');
Route::get('/about', 'IndexController@about');
Route::get('/exe', 'IndexController@executant');
Route::get('/adv', 'IndexController@advertiser');
Route::get('/help', 'IndexController@help');
Route::get('/contacts', 'IndexController@contacts');
Route::get('moderator/post/{id}', 'ModeratorController@post');
Route::auth();
Route::get('/authorization', 'Auth\AuthController@auth');
Route::post('/authenticate', ['as' => 'authenticate', 'uses' => 'Auth\AuthController@authenticate']);
Route::get('logout', function(){
    Auth::logout();
    return redirect('/');
});
Route::get('/admitad', 'IndexController@admitad');
Route::post('/location', 'IndexController@setLocation');

# Маршрутизации для испольнителя
Route::group(['middleware' => 'role:4'], function(){
    Route::get('user', ['as' => 'user', 'uses' => 'UserController@index']);
    Route::get('/user/logout', 'UserController@logout');
    Route::get('/user/refs','UserController@refs');
    Route::get('/user/profile','UserController@profile');
    Route::get('/user/news','UserController@news');
    Route::post('/user/profile/edit', ['as' => 'user.profile', 'uses' => 'UserController@update']);
    ## Add news
    Route::get('/user/news/create','UserController@create_news'); # Форма добавление новости
    Route::post('/user/news/store', ['as' => 'user.news.store', 'uses' => 'UserController@store_news']); # Процесс добавление новости в базу данных
    ## Edit news
    Route::get('/user/news/edit/{id}','UserController@edit_news'); # Форма редактирование новости
    Route::post('/user/news/update', ['as' => 'user.news.update', 'uses' => 'UserController@update_news']); # Процесс сохранение изменение
    ## Delete news
    Route::get('/user/news/delete/{id}', 'UserController@destroy_news');
    # Доходы
    Route::get('/user/profit', 'UserController@profit');
    # Изменить картинку новости
    Route::get('delete/img/{id}', function($id){
        $path = DB::select("SELECT img FROM posts WHERE id='$id'");
        $file = base_path()."/public".$path[0]->img;
        $result = unlink($file);
        if($result){
            DB::update("UPDATE posts SET img='' WHERE id='$id'");
        }
        return redirect()->back();
    });
});

# Маршруты для рекламодателя
Route::group(['middleware' => 'role:3'], function(){
    Route::get('advertiser', ['as' => 'advertiser','uses' => 'AdvertiserController@index']);
    Route::get('advertiser/logout', function(){
        Auth::logout();
        return redirect('/');
    });
    Route::get('advertiser/adv', function(){
        $adv = DB::table('advertisements')->where('id_advertiser', Auth::user()->id)->paginate(10);
        $count = count($adv);
        return view('user/advertiser/adv', compact('adv','count'));
    });
    Route::get('advertiser/create', 'AdvertiserController@create');
    Route::post('advertiser/store', ['as' => 'create.adv', 'uses' => 'AdvertiserController@store']);
    Route::get('advertiser/spending', 'AdvertiserController@spending');
    Route::get('advertiser/profile', function(){
        return view('user/advertiser/profile');
    });
    Route::post('advertiser/profile/contact',['as' => 'advertiser/contact', 'uses' => 'AdvertiserController@contact']);
    Route::post('advertiser/profile/password', 'AdvertiserController@change_password');
    Route::post('advertiser/profile/amount',function(Request $request){
        $data['id'] = Auth::user()->id;
        if($request->amount >= 30){
            $data['amount'] = $request->amount;
        }else{
            $data['amount'] = 30;
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->update($data);
        return redirect('advertiser/profile');
    });
});

# Маршруты для суперадминистратора
Route::group(['middleware' => 'role:1'], function(){
    Route::get('admin', ['as' => 'admin', 'uses' => 'AdminController@index']);
    Route::get('admin/users', 'AdminController@users');
    Route::get('admin/news', 'AdminController@news');
    Route::get('admin/cats', 'AdminController@cats');
    Route::get('admin/adv', 'AdminController@adv');
    Route::get('admin/profile', function(){
        $user = User::find(Auth::user()->id);
        return view('user/admin/profile', compact('user'));
    });
    # Одобрить новости
    Route::get('admin/news/{id}', function($id){
        DB::table('posts')->where('id', $id)->update(['status' => 1]);
        return redirect('admin/news');
    });
    # Снять с публикации
    Route::get('admin/news/block/{id}', function($id){
        DB::table('posts')->where('id', $id)->update(['status' => 2]);
        return redirect('admin/news');
    });
    # Удалить новости
    Route::get('admin/news/delete/{id}', function($id){
        DB::table('posts')->where('id', $id)->delete();
        return redirect('admin/news');
    });
    # Одобрить рекламу
    Route::get('admin/adv/{id}', function($id){
        DB::table('advertisements')->where('id', $id)->update(['status' => 1]);
        return redirect('admin/adv');
    });
    # Отказано
    Route::get('admin/adv/block/{id}', function($id){
        DB::table('advertisements')->where('id', $id)->update(['status' => 2]);
        return redirect('admin/adv');
    });
    # Удалить рекламу
    Route::get('admin/adv/delete/{id}', function($id){
        DB::table('advertisements')->where('id', $id)->delete();
        return redirect('admin/adv');
    });
    # Блокировать пользователя
    Route::get('admin/user/block/{id}', function($id){
        DB::table('users')->where('id', $id)->update(['block' => 1]);
        return redirect('admin/users');
    });
    # Разблокировать пользователя
    Route::get('admin/user/unblock/{id}', function($id){
        DB::table('users')->where('id', $id)->update(['block' => 0]);
        return redirect('admin/users');
    });
    # Зачисление баланс на счет рекламодателя
    Route::get('admin/payment', 'AdminController@payment');
    Route::post('admin/pay', function(Request $request){
        $deposit = User::find($request->id_user)->deposit + abs($request->amount);
        $data = [
            'id' => $request->id_user, 'deposit' => $deposit
        ];
        $pay = [
            'id_user' => $request->id_user, 'amount' => abs($request->amount)
        ];
        User::findOrFail($request->id_user)->update($data);
        Payments::create($pay);
        return redirect('admin/payment');
    });
    # Профиль
    Route::post('admin/profile/info', 'AdminController@info');
    Route::post('admin/profile/update/password', 'AdminController@update_password');
    # Просмотр новости и рекламы
    Route::get('admin/post/{id}', 'AdminController@post');
    Route::get('admin/advertisement/{id}', 'AdminController@advertisement');
    # Страницы
    Route::get('admin/pages', 'AdminController@pages');
    Route::get('admin/page/{id}', function($id){
        $page = Pages::find($id);
        return view('user/admin/edit_page', compact('page'));
    });
    Route::post('admin/page/{id}/update', 'AdminController@update_page');
    # Форма добавление категории
    Route::get('/admin/cat/create', function(){
        $cats = Cats::all();
        return view('user/admin/create_cat', compact('cats'));
    });
    Route::post('/admin/cat/store', 'AdminController@cat_store');
    Route::get('/admin/cat/{id}/position/{position}', function($id, $position){
        $cat = Cats::findOrFail($id);
        $cat->update(['position' => $position]);
        return redirect('admin/cats');
    });
    # Клик категории
    Route::get('/admin/click-cat/create', function(){
        return view('user/admin/click_cat');
    });
    Route::post('/admin/click-cat/store', 'AdminController@click_cat_store');
    # По клике показать оффер в розыгрыше или нет
    Route::any('/admin/no_draw/{id}','AdminController@no_draw');
    Route::any('/admin/in_draw/{id}','AdminController@in_draw');
});

# Маршруты для модератора
Route::group(['middleware' => 'role:2'], function(){
    Route::get('moderator', ['as' => 'moderator', 'uses' => 'ModeratorController@index']);
    Route::get('moderator/news', 'ModeratorController@news');
    # Снять новости
    Route::get('moderator/news/block/{id}', function($id){
        DB::table('posts')->where('id', $id)->update(['status' => 2]);
        return redirect('moderator/news');
    });
    # Одобрить новости
    Route::get('moderator/news/{id}', function($id){
        DB::table('posts')->where('id', $id)->update(['status' => 1]);
        return redirect('moderator/news');
    });
    # Удалить новости
    Route::get('moderator/news/delete/{id}', function($id){
        DB::table('posts')->where('id', $id)->delete();
        return redirect('moderator/news');
    });
});

# Розыгрыш
Route::get('/drawing', 'Draw\IndexController@index');
Route::post('/drawing/store', 'Draw\IndexController@store');
Route::get('/drawing/{id}/{token}', 'Draw\IndexController@drawing');
Route::get('/confirm/{token}', 'Draw\IndexController@confirm');
Route::post('/drawing/auth', 'Draw\IndexController@auth');
Route::get('/drawing/account', 'Draw\IndexController@account');
Route::post('/drawing/change/avatar', 'Draw\IndexController@avatar');
Route::post('/drawing/account/settings', 'Draw\IndexController@settings');

Route::get('/{id}/drawing/{token}', 'Draw\IndexController@authenticate');


Route::get('/drawing/logout', function(){
    Auth::logout();
    return redirect('/drawing');
});