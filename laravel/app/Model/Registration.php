<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';

    protected $fillable = [
        'id_student',               // 學員ID
        'id_course',                // 課程ID
        'amount_payable',           // 應付金額
        'amount_paid',              // 已付金額
        'sign',                     // 簽名檔案
        'status_payment',           // 付款狀態
        'id_events',                // 場次ID
        'registration_join',        // 我想參加課程
        'id_group',                 // 群組ID
        'pay_date',                 // 統編
        'pay_memo',                 // 抬頭
        'person',                   // 服務人員
        'type_invoice',             // 統一發票
        'number_taxid',             // 統編
        'companytitle',             // 抬頭
        'source_events',            // 來源場次ID
    ];
}