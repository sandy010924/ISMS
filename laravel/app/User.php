<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    const ROLE_ADMIN = 'admin';
    const ROLE_MARKETER = 'marketer';
    const ROLE_ACCOUNTANT = 'accountant';
    const ROLE_STAFF = 'staff';
    const ROLE_TEACHER = 'teacher';
    const ROLE_SALSER = 'saleser';
    const ROLE_MSALSER = 'msaleser';
    const ROLE_OFFICESTAFF = 'officestaff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
