<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreachingResource extends JsonResource
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
            'preaching_id'=>$this->preaching_id,
            'user_id'=>$this->user_id,
            'record_date'=>$this->record_date,
            'dcount'=>$this->dcount,
            'preaching_name'=>$this->preaching->name,

        ];
    }
}
