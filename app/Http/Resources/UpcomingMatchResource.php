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
        $datetime = Carbon::parse($this->datetime);
        $currentTime = Carbon::now();
        $status = $this->status === 'finished' ? 'not_started' : 'finished';

        $isLive = $this->status === 'life';
        $channel = $isLive ? $this->channel : null;

        $firstHalfEnd = $datetime->copy()->addMinutes(45);
        $secondHalfStart = $datetime->copy()->addMinutes(45)->addSeconds(1);
        $isFirstHalf = $datetime->lt($firstHalfEnd);
        $isSecondHalf = $datetime->between($secondHalfStart, $secondHalfStart->copy()->addMinutes(90));

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
                'day' => $datetime->dayName,
                'time' => $datetime->format('H:i'),
                'month' => $datetime->monthName
            ],
            'status' => $status,
            'is_live' => $isLive,
            'channel' => $channel,
            'play_ground' => $this->play_ground,
            'club1' => $club1,
            'club2' => $club2,
            'half' => $isFirstHalf ? 'الشوط الأول' : ($isSecondHalf ? 'الشوط الثاني' : null),
            
        ];

        if ($datetime->gt($currentTime) && $datetime->lt($currentTime->copy()->addHours(3))) {
            return $data;
        }

        unset($data['status']);
        unset($data['is_live']);
        unset($data['channel']);
        unset($data['half']);

        return $data;
    }
}
