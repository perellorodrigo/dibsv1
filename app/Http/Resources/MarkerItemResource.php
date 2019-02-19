<?php

namespace Dibs\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarkerItemResource extends JsonResource
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
            'lat' => $this->lat,
            'lng' => $this->lng,
            'distanceToUser' => $this->distanceToUser,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'imageurl' => $this->imageurl,
            'dibs_caller_id' => $this->dibs_caller_id,
            'owner_id' => $this->owner_id
        ];
    }
}