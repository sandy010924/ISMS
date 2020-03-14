<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'id_student',       // 學員ID
        'cash',             // 付款現金
        'pay_model',        // 付款方式
        'number',           // 卡號後四碼
    ];
}