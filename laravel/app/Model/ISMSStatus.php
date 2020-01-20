<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ISMSStatus extends Model
{
    protected $table = 'isms_status';

    protected $fillable = [
        'id',
        'name'
    ];
}
