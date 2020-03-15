<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table = 'register';

    protected $fillable = [
        'id_registration',          // 正課報名ID
        'id_student',               // 學員ID
        'id_status',                // 狀態ID
        'id_events',                // 場次ID
        'memo',                     // 備註
    ];
}