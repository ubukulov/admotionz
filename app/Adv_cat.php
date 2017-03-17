<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adv_cat extends Model
{
    protected $table = "adv_cat";
    protected $fillable = [
        'id', 'id_adv', 'id_cat', 'created_at', 'updated_at'
    ];
}
