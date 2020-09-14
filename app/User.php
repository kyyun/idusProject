<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
    
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name', 'nickName', 'password', 'phoneNumber','email', 'gender'
    ];

}
