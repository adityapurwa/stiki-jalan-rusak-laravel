<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'address',
        'photo',
        'user_id',
        'cache_votes'
    ];
}
