<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostView extends Model
{
    protected $table = 'post_view';

    protected $fillable = [
        'id', 'id_post', 'ip_user', 'created_at', 'updated_at'
    ];

    public static function exists($id_post, $ip_user){
        $result = DB::select("SELECT * FROM post_view WHERE id_post='$id_post' AND ip_user='$ip_user'");
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public static function check_user_for_view_post($id_post, $ip_user){
        $result = DB::select("SELECT (UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(updated_at)) AS sec FROM post_view WHERE id_post='$id_post' AND ip_user='$ip_user'");
        if($result[0]->sec >= 86400){
            // Прошел 24 часа
            return true;
        }
    }
    
    public static function update_time($id_post,$ip_user){
        $current_date = date("Y-m-d H:i:s");
        DB::update("UPDATE post_view SET updated_at='$current_date' WHERE id_post='$id_post' AND ip_user='$ip_user'");
    }
}
