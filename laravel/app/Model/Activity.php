<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    protected $fillable = [
        'submissiondate',   // Submission Date
        'id_student',       // 學員ID
        'id_course',        // 課程ID
        'id_status',        // 報名狀態ID
        'id_events',        // 場次ID        
        'course_content',   // 你有什麼問題想要詢問      
        'memo',             // 報名備註        
    ];
}
