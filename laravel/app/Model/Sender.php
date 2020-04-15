<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    protected $table = 'sender';

    protected $fillable = [
        'id_message',
        'id_student',
        'phone',
        'email',
    ];
}
