<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentComment extends Model
{
    protected $fillable = [
        'comment','mdate', 'appointment_id'
    ];

    public function appointment()
    {
        return $this->belongsTo('App\Appointment','appointment_id');
    }
}