<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'debt';

    protected $fillable = [
        'id_student',
        'id_status',
        'name_course',
        'status_payment',
        'contact',
        'person',
        'remind_at',
        'id_registration'
    ];
}
