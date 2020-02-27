<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';

    protected $fillable = [
        'id_student',       // 學員ID
        'id_course',        // 課程ID
        'id_status',        // 狀態ID
        'id_payment',       // 繳款明細ID
        'amount_payable',   // 應付金額
        'amount_paid',      // 已付金額
        'person',           // 追單人員
        'memo',             // 備註
        'sign'             // 簽名檔案
    ];
}