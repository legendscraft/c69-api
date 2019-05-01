<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

}