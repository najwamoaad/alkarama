<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
 
class MetcheResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {  
        Carbon::setlocale(config('app.locale'));
        $dade = Carbon::parse($this->datetime);
        
        $goals = [];
        $statistics = $this->statistics;
    
        foreach ($statistics as $statistic) {
            $v = json_decode($statistic->value, true);
            
            $values = array_values($v);  
        
      
            $value1 = $values[0];  
            $value2 = $values[1]; 
        }
        
        return [
            
            
            'date' => $dade->translatedFormat('j F Y '),
            'day' => $dade->translatedFormat('l'),
            'time' => $dade->translatedFormat('h:i A'),
            'round' => $this->round,
            'playground' => $this->play_ground,
            'club1' => $this->club1->name,
            'club1logo' => $this->club1->logo,
            'club2' => $this->club2->name,
            'club2logo' => $this->club2->logo,
           // 'goals' => $this->statistics->where('name', 'goal')->pluck('value'),
           
           'goalsclub1' =>$value1,
           'goalsclub2' =>$value2,
        ];
    }
}
