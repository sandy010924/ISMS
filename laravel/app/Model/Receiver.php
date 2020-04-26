<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    protected $table = 'receiver';

    protected $fillable = [
        'id_message',
        'id_student',
        'phone',
        'email',
    ];
}
