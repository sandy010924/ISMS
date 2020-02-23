<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $table = 'blacklist';

    protected $fillable = [
        'id_student',
        'reason',
    ];
}
