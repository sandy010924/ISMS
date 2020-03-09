<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';

    protected $fillable = [
        'id_teacher',
        'name',
        'type',
        'id_type',
        'courseservices',
        'money',
    ];

}