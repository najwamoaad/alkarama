<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class employeesRessource extends JsonResource
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
            
         
            'work' => $this->work,
            'jop_type' => $this->jop_type,
            'sport_id' => $this->sport->name,
            
        ];
    }
}
