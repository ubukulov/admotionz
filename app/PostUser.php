<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Jelovac\Bitly4laravel\Facades\Bitly4laravel as Bitly;

class PostUser extends Model
{
    protected $table = 'post_user';

    protected $fillable = [
        'id', 'id_post', 'id_user', 'bitly_link','created_at', 'updated_at'
    ];

    public static function setShortLink($id_user,$user_login){
        $result = DB::select("SELECT PO.id AS id FROM posts PO
        WHERE PO.id_user<>'$id_user' AND PO.id_post_click<>1 AND PO.id NOT IN(SELECT PU.id_post FROM post_user PU WHERE PU.id_user='$id_user')");
        if($result){
            foreach($result as $key=>$value){
                $bit = Bitly::shorten(env("REAL_URL") . 'user/'. $user_login .'/post/'.$value->id);
                PostUser::create([
                    'id_post' => $value->id, 'id_user' => $id_user, 'bitly_link' => $bit['data']['url']
                ]);
            }
        }
    }
}
