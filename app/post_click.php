<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_click extends Model
{
    protected $table = 'post_click';
    
    protected $fillable = [
        'id', 'title', 'price_click', 'percent', 'created_at', 'updated_at'
    ];

}
