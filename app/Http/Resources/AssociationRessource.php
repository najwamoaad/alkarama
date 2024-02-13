<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssociationRessource extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'boss' => $this->boss,
            'image' => $this->image,
            'description' => $this->description,
            'country' => $this->country,
            'sport_id' => $this->sport->name,
            'topfans' => $this->topFans->pluck('name'),
           /* 'top_fans' => TopFansResource::collection($this->whenLoaded('topFans')),
            'sport' => new SportResource($this->whenLoaded('sport')),*/
        ];
    }
}
