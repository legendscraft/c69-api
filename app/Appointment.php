<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name', 'user_id','gender_id','centre_id','appointment_frequency_id','last_met','is_late'
    ];

    public function gender()
    {
        return $this->belongsTo('App\Gender','gender_id');
    }

    public function frequency()
    {
        return $this->belongsTo('App\AppointmentFrequency','appointment_frequency_id');
    }

    public function centre()
    {
        return $this->belongsTo('App\Centre','centre_id');
    }

    public function comments()
    {
        return $this->hasMany('App\AppointmentComment');
    }
}
