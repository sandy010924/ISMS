<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = 'mark';

    protected $fillable = [
        'id_student',
        'name_mark',
        'name_course',
    ];
}
