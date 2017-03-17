<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cats extends Model
{
    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at', 'position'
    ];
}
