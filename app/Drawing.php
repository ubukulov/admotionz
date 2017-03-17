<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    protected $table = 'drawing';
    
    protected $fillable = [
        'id', 'user_id', 'token', 'ip', 'img', 'created_at', 'updated_at', 'balance'
    ];

    public static function check_user_by_id_and_token($user_id, $token){
        $result = Drawing::where(['user_id' => $user_id, 'token' => $token])->get();
        if(count($result) > 0){
            return $result[0]->id;
        }else{
            return false;
        }
    }
    # Кол-во участников
    public static function getCountDrawParticipants(){
        $result = Drawing::all();
        return count($result);
    }

    # Попытаться авторизоватся по ип пользователя
    public static function authWithIp($ip){
        $result = Drawing::where(['ip' => $ip])->get();
        if(count($result) > 1){
            // есть несколько зарегистрированные пользователей с этого ип адреса
            return false;
        }
        if(count($result) == 1){
            // есть только одно зарегистрированный пользователь с этого ип адреса
            return true;
        }
        if(count($result) == 0){
            return false;
        }
    }

    # По ип адреса получаем ид пользователя
    public static function getUserIdByIp($ip){
        $result = Drawing::where(['ip' => $ip])->first();
        return $result->user_id;
    }
}
