<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class MatchWithReplecmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    { Carbon::setlocale(config('app.locale'));
        $dade = Carbon::parse($this->datetime);
       
         
      
    //  $statistics = $this->statistics()->value;
    
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
          
            'play_ground' => $this->play_ground,
            'goals'=>$value1,
            'goals2'=>$value2,
   
        'club_1' => new ClubResource($this->club1),
            'club_2' => new ClubResource($this->club2),
            'substitutions' => ReplacmentResource::collection($this->Replacments),
        ];
    }
}
