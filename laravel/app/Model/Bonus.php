<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $table = 'bonus';

    protected $fillable = [
        'id',
        'id_events',
        'id_course',
        'id_group',
        'name',
        'status',
        'created_at',
        'updated_at',
    ];
}
