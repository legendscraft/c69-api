<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'gender'=>$this->gender->name,
            'frequency'=>$this->frequency->name,
            'centre'=>$this->centre->name,
            'gender_id'=>$this->gender_id,
            'centre_id'=>$this->centre_id,
            'appointment_frequency_id'=>$this->appointment_frequency_id,
            'name'=>$this->name,
            'isLate'=>$this->is_late,
            'lastMet'=>$this->last_met,
        ];
    }
}
