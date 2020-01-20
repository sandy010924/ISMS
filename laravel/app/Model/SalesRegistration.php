<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesRegistration extends Model
{
    protected $table = 'sales_registration';

    protected $fillable = [
        'id_student',       // 學員ID
        'id_course',        // 課程ID
        'id_status',        // 報名狀態ID
        'pay_model',        // 付款方式
        'account',          // 帳號/卡號後四碼
        'course_content',   // 想聽到的課程有哪些
    ];
    
}
