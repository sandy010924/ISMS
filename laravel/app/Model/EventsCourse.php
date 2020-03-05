<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EventsCourse extends Model
{
    protected $table = 'EventsCourse';

    protected $fillable = [
        'id_course',
        'name',
        'location',
        'money',
        'money_fivedays',
        'money_installment',
        'memo',
        'host',
        'closeorder',
        'weather',
        'staff',
        'id_group',
        'course_start_at',
        'course_end_at',
        'created_at',
        'updated_at',
    ];
}
