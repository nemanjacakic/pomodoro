<?php

namespace App\Http\Resources;

use App\Http\Traits\Casts;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    use Casts;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->key => $this->cast($this->value, $this->type)
        ];
    }
}
