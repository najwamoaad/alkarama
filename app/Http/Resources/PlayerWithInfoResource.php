<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerWithInfoResource extends JsonResource
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
            
            'number' => $this->number,
          
            'image' => $this->image,
        ];
    }
}
