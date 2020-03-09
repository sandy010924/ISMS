<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $table = 'refund';

    protected $fillable = [
        'id_registrtion',
        'id_student',
        'submissiondate',
        'refund_date',
        'name_student',
        'phone',
        'email',
        'name_course',
        'refund_reason',
        'pay_model',
        'account',
        'created_at',
        'updated_at',
    ];
}
