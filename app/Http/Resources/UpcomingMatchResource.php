<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Alkoumi\LaravelHijriDate\Hijri;
class UpcomingMatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $datetime = strtotime($this->datetime);
        $dade = Carbon::parse($this->datetime);
        $currentTime =date('Y-m-d H:i:s');
        

        $isLive = $this->status === 'life';
        $channel = $isLive ? $this->channel : null;

         
        $end_first_half =  date('Y-m-d H:i:s',strtotime('+45 minutes', $datetime));
        $end_second_half =date('Y-m-d H:i:s',strtotime('+90 minutes', $datetime));
    
        
        if ($currentTime < $end_first_half) {
            $half = 'First Half';
        } elseif ($currentTime <= $end_second_half) {
            $half = 'Second Half';
        } else {
            $half = 'Match Finished';
        }

        $club1 = [
            'name' => $this->club1->name,
            'logo' => $this->club1->logo
        ];

        $club2 = [
            'name' => $this->club2->name,
            'logo' => $this->club2->logo
        ];
        
        $goals = [];
        $statistics = $this->statistics;
    
        foreach ($statistics as $statistic) {
            $v = json_decode($statistic->value, true);
            
            $values = array_values($v);  
        
      
            $value1 = $values[0];  
            $value2 = $values[1]; 
        } 
         
        $data = [
            'datetime' => [
                'date' => $dade->translatedFormat('j F Y '),
                'day' => $dade->translatedFormat('l'),
                'time' => $dade->translatedFormat('h:i A'),
            ],
            
            'is_live' => $isLive,
            'channel' => $channel,
            'play_ground' => $this->play_ground,
            'club1' => $club1,
            'club2' => $club2,
            'half' => $half,
            
        ];

         

        

        return $data;
    }
}
