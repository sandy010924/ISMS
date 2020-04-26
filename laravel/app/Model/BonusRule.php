<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BonusRule extends Model
{
    protected $table = 'bonus_rule';

    protected $fillable = [
        'id',
        'id_bonus',
        'name',
        'value',
        'status',
        'created_at',
        'updated_at',
    ];
}
