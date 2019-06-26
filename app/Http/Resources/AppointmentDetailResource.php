<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['id'=>$this->id,
            'gender'=>$this->gender->name,
            'frequency'=>$this->frequency->name,
            'centre'=>$this->centre->name,
            'name'=>$this->name,
            'isLate'=>$this->is_late,
            'comments'=>AppointmentCommentResource::collection($this->comments),
            'lastMet'=>$this->last_met];
    }
}
