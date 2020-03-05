<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rule';

    protected $fillable = [
        'type',
        'name',
        'regulation',
        'rule_value',
        'rule_status',
    ];
}
