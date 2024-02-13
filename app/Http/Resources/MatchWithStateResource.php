<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MatchWithStateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      
     
        $dade = Carbon::parse($this->datetime);
         
        
    
        return [
            'date' => $dade->translatedFormat('j F Y '),
            'day' => $dade->translatedFormat('l'),
            'time' => $dade->translatedFormat('h:i A'),
       
            'playground' => $this->play_ground,
            'club1' => $this->club1->name,
            'club1logo' => $this->club1->logo,
            'club2' => $this->club2->name,
            'club2logo' => $this->club2->logo,
           
        ];
    }
}
