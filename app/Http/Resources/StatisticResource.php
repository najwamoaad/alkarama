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
        $values = array_values($v);  
        
      
        $value1 = $values[0];  
        $value2 = $values[1]; 
        return[
            'match_name'=>$this->metche()->first()->club1()->first()->name,
            'match_name2'=>$this->metche()->first()->club2()->first()->name,
            'name' => $this->name,
       
           
           'value1' => $value1,
           'value2' => $value2,
        ];
    }
}
