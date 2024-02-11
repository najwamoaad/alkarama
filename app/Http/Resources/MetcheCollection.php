<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Alkoumi\LaravelHijriDate\Hijri;
class MetcheCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {$datetime = $this->datetime;
        $day =   Hijri::date('l', strtotime($datetime));
        $date = date('m/d', strtotime($datetime));
        $time =  Hijri::date('h:i a', strtotime($datetime));
        
        return [
            
            
           
            'date' => $date,
            'day' => $day,
            'time' => $time,
          
             
             
            'playground' => $this->playground,
           
            'club1' => $this->club->name,
            'club2' => $this->club->name,
            'goels'=> $this->statistics->name,
        ];
    }
}
