<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentCommentResource extends JsonResource
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
            'appointment_id'=>$this->appointment_id,
            'comment'=>$this->comment,
            'mdate'=>Carbon::parse($this->mdate)->format('l jS \\of F Y'),
            'rawDate'=>Carbon::parse($this->mdate)->toDateString(),
        ];
    }
}
