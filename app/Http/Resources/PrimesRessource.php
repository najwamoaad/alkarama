<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrimesRessource extends JsonResource
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
            'image' => $this->image,
            'description' => $this->description,
        //    'type' => $this->type,
        //    'sport_id' => $this->sport->name,
       //   'seasone_id' => $this->seasone->name,
        ];
    
    }
}
