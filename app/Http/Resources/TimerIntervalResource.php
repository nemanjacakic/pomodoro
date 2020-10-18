<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TimerIntervalResource extends JsonResource
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
            'id' => $this->id,
            'timer' => $this->timer,
            'title' => $this->title,
            'duration' => gmdate("i:s", $this->duration),
            'updated_at' => Carbon::parse($this->updated_at)->format('d F Y'),
        ];
    }
}
