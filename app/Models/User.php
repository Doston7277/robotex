<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name',
        'user_phone',
        'user_password',
        'user_image',
        'user_first_name',
        'user_last_name',
        'user_father_name',
        'user_address',
        'is_admin'
    ];
}
