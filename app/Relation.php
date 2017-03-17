<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = "relation";
    protected $fillable = [
        'id', 'user_id', 'ref_id', 'created_at', 'updated_at'
    ];
}
