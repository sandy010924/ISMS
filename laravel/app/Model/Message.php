<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $fillable = [
        'id_student_group',
        'type',
        'title',
        'content',
        'send_at',
    ];
}
