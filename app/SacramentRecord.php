<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SacramentRecord extends Model
{
    protected $fillable = ['sacrament_id','user_id','record_date','dcount'];

    public function sacrament()
    {
        return $this->belongsTo('App\Sacrament');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
