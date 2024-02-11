<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Alkoumi\LaravelHijriDate\Hijri;
class MatchWithLiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $datetime = $this->datetime;
        $day =   Hijri::date('l', strtotime($datetime));
        $date = Date('Y/m/d', strtotime($datetime));
        $time =  Hijri::date('h:i A', strtotime($datetime));
        
        $goals = [];
        $statistics = $this->statistics;
    
        foreach ($statistics as $statistic) {
            $v = json_decode($statistic->value, true);
            
            $values = array_values($v);  
        
      
            $value1 = $values[0];  
            $value2 = $values[1]; 
        }
    
        return [
            
            
            'date' => $date,
            'day' => $day,
            'time' => $time,
          
            'playground' => $this->playground,
            'club1' => $this->club1->name,
            'club1logo' => $this->club1->logo,
            'club2' => $this->club2->name,
            'club2logo' => $this->club2->logo,
           'status' => 'life',
           'goalsclub1' =>$value1,
           'goalsclub2' =>$value2,
        ];
    }
}
