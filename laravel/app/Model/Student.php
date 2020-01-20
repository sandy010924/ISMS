<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
        'name',
        'sex',
        'id_identity',
        'phone',
        'email',
        'birthday',
        'company',
        'profession',
        'address',
    ];
}
