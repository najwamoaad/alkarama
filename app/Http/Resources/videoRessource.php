<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class videoRessource extends JsonResource
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
            
           
            'description'=> $this->description,
            'url' => $this->url,
        ];
    }
}
