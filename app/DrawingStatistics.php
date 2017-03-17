<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DrawingStatistics extends Model
{
    protected $table = 'drawing_statistics';
    
    protected $fillable = [
        'id', 'drawing_id', 'ip', 'created_at', 'updated_at'
    ];

    # Общее кол-во приглащений
    public static function all_count(){
        $result = DrawingStatistics::all();
        return count($result);
    }
    # Общее кол-во приглашений по конкретному пользователю
    public static function count($user_id){
        $result = DB::select("SELECT DS.* FROM drawing_statistics DS LEFT JOIN drawing D ON D.id=DS.drawing_id WHERE D.user_id='$user_id'");
        return count($result);
    }
    # Список переход по ссылку
    public static function getDrawStatistics($user_id){
        $result = DB::select("SELECT DS.* FROM drawing D LEFT JOIN drawing_statistics DS ON DS.drawing_id=D.id WHERE D.user_id='$user_id'");
        return $result;
    }
    # Список участников по кол-во переходов
    public static function getDrawParticipants(){
        $result = DB::select("SELECT D.*, COUNT(DS.id) AS cnt  FROM drawing D
                            LEFT JOIN drawing_statistics DS ON DS.drawing_id = D.id
                            GROUP BY D.user_id ORDER BY cnt DESC, D.created_at ASC");
        return $result;
    }
}
