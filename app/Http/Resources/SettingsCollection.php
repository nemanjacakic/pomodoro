<?php

namespace App\Http\Resources;

use App\Http\Traits\Casts;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingsCollection extends ResourceCollection
{
    use Casts;

    private $data = [];
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function ($item) {
            $this->data[$item->key] = $this->cast($item->value, $item->type);
        });

        return $this->data;
    }
}
