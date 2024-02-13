<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BossesRessource extends JsonResource
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
            'start_year'=> $this->year,
            'image' => $this->image,
        ];
    }
}
