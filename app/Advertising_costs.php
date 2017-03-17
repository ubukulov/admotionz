<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertising_costs extends Model
{
    protected $table = 'advertising_costs';
    
    protected $fillable = [
        'id', 'id_adv', 'id_user', 'id_post', 'paid', 'host_name', 'country', 'created_at', 'updated_at'
    ];
}
