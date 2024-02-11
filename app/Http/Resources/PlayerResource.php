<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
         
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
