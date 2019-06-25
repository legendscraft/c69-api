<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['recipient','user_id'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
