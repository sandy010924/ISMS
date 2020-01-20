<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';

    protected $fillable = [
        'id_teacher',
        'name',
        'location',
        'events',
        'course_at',
        'memo',
        'type',
        'course_start_at',
        'course_end_at',
    ];

}