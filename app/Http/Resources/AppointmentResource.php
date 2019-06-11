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
            'name'=>$this->name
        ];
    }
}
