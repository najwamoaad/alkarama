<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlayerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'high' => $this->high,
            'born' => $this->born,
            'play' => $this->play,
            'from' => $this->from,
            'number' => $this->number,
            'first_club' => $this->first_club,
            'career' => $this->career,
            'image' => $this->image,
        ];
    }
}
