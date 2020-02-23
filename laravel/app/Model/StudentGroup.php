<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $table = 'student_group';

    protected $fillable = [
        'id_student',
        'id_group',
        'name',
        'condition',
    ];
}
