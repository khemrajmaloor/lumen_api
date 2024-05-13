<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_login', 'user_email', 'user_pass', 'user_nicename', 'user_url', 'role', 'user_registered'
    ];

    protected $hidden = [
        'user_pass', 'remember_token',
    ];
}
