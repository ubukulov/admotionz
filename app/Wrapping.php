<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wrapping extends Model
{
    protected $table='wrapping';

    protected $fillable = [
        'id', 'ip_user','id_user','id_post', 'created_at', 'updated_at'
    ];

    public static function exists($ip){
        $result = Wrapping::where('ip_user', '=', $ip)->get();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function limit($current_date){
        $updated_at = Wrapping::where('ip_user', '=', $_SERVER['REMOTE_ADDR'])->get();
        $sec1 = strtotime($updated_at[0]->updated_at);
        $sec2 = strtotime($current_date);
        $sec = (int) round($sec2-$sec1);
        return $sec;
    }
}
