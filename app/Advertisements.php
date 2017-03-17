<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisements extends Model
{
    protected $fillable = [
        'id', 'title', 'img', 'id_cat', 'id_advertiser',
        'publish', 'created_at', 'updated_at','video', 'url'
    ];

    public static $rules = [
        'title' => 'required|between:10,255',
        'id_advertiser' => 'integer',
        'publish' => 'integer'
    ];
}
