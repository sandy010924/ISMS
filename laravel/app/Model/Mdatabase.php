<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mdatabase extends Model
{
    protected $table = 'm_database';

    protected $fillable = [
        'id ',
        'filename ',
    ];
}
