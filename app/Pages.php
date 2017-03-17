<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable = [
        'id', 'title','keywords', 'description', 'body','created_at', 'updated_at'
    ];
}
