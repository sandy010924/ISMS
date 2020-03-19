<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentGroupdetail extends Model
{
    protected $table = 'student_groupdetail';

    protected $fillable = [
        'id_student ',
        'id_group ',
    ];
}
