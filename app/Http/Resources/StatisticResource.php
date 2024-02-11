<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {$v = json_decode($this->value, true);
        return[


            'name' => $this->name,
            'value' => $v,
           'match_name'=>$this->metche()->first()->club1()->first()->name
        ];
    }
}
