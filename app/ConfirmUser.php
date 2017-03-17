<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmUser extends Model
{
    protected $table = 'draw_confirm_users';

    protected $fillable = [
        'id', 'email', 'token', 'created_at', 'updated_at'
    ];
}
