<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawingWrapping extends Model
{
    protected $table='drawing_wrapping';

    protected $fillable = [
        'id', 'ip_user', 'created_at', 'updated_at'
    ];

    public static function exists($ip){
        $result = DrawingWrapping::where('ip_user', '=', $ip)->get();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function limit($current_date){
        $updated_at = DrawingWrapping::where('ip_user', '=', $_SERVER['REMOTE_ADDR'])->get();
        $sec1 = strtotime($updated_at[0]->updated_at);
        $sec2 = strtotime($current_date);
        $sec = (int) round($sec2-$sec1);
        return $sec;
    }

    public static function getId($ip_user){
        $result = DrawingWrapping::where(['ip_user' => $ip_user])->get();
        if(count($result) > 0){
            return $result[0]->id;
        }else{
            return false;
        }
    }
}
