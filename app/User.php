<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoleAndPermission;

    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'disable_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'disable_at'
    ];
}
