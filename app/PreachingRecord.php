<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreachingRecord extends Model
{
    protected $fillable = ['preaching_id','user_id','record_date','dcount'];

    public function preaching()
    {
        return $this->belongsTo('App\Preaching');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
