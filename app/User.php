<?php

namespace App;

use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','login', 'email', 'password',
        'role','lastname', 'firstname', 'patronymic', 'block', 'deposit', 'amount', 'phone'
    ];

    public static $roles = [
        'email' => 'required|email|max:255|unique:users'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function hasRole($role){

        //$result = User::where(['id' => Auth::user()->id,'role' => $role])->get();
        $result = RoleUser::where(['user_id' => Auth::user()->id,'role_id' => $role])->get();
        if(count($result) > 0){
            return true;
        }

        return false;
    }

    public static function withdraw_money($id_advertiser){
        $result = User::find($id_advertiser);
        $deposit = $result->deposit - $result->amount;
        $data['deposit'] = $deposit;
        $result->update($data);
    }

    public static function get_amount($id_advertiser){
        $result = User::find($id_advertiser);
        $amount = $result->amount;
        return $amount;
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public static function exists($email){
        $result = User::where(['email' => $email])->get();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
