<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;
use Jelovac\Bitly4laravel\Facades\Bitly4laravel as Bitly;

class Posts extends Model
{
    protected $fillable = [
        'id', 'title', 'description', 'keywords', 'body', 'img', 'id_user', 'id_cat',
        'created_at', 'updated_at','status','link_source','view_count','bitly_short_link','id_post_click','filter'
    ];

    public static $rules = [
        'title'	=> 'required|between:10,255',
        'description'	=> 'required',
        'body' => 'required',
        'id_cat' => 'required',
        'id_user' => 'required'
        //'img' => 'required|dimensions:min_width=90,min_height=90'
    ];

    public static function get_user_id($id_post){
        $result = Posts::find($id_post);
        return $result->id_user;
    }

    public static function get_user_login_by_id_user($id_user){
        return User::find($id_user)->login;
    }

    # Просмотр
    public static function update_view_count($id){
        DB::update("UPDATE posts SET view_count = view_count + 1 WHERE id=$id");
    }
    
    # Сокращаем ссылки
    public static function setShortLink(){
        $result = Posts::where(['bitly_short_link' => ''])->get();
        if($result){
            for($i=0; $i<count($result); $i++){
                if(empty($result[$i]->bitly_short_link)){
                    $post = Posts::findOrFail($result[$i]->id);
                    $bit = Bitly::shorten(env("REAL_URL") . 'user/'. get_user_login($result[$i]->id_user) .'/post/'.$result[$i]->id);
                    $post->bitly_short_link = $bit['data']['url'];
                    $post->save();
                }
            }
        }
    }

    public function user(){
        return $this->belongsTo('User');
    }
    
    # 
    public static function getAmount($id_post){
        $result = DB::select("SELECT PC.price_click FROM posts PO
                        LEFT JOIN post_click PC ON PC.id=PO.id_post_click
                        WHERE PO.id='$id_post'");
        return $result[0]->price_click;
    }
}
