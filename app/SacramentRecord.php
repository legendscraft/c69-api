<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SacramentRecord extends Model
{
    protected $fillable = ['sacrament_id','user_id','record_date','dcount'];
}
