<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SacramentResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'record_date'=>$this->record_date,
            'dcount'=>$this->dcount,
            'sacrament_id'=>$this->sacrament_id,
            'sacrament_name'=>$this->sacrament->name,

        ];
    }
}
