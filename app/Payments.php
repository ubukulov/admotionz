<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'id', 'id_user', 'amount', 'created_at', 'updated_at'
    ];
}
