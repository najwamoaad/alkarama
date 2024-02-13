<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replacment extends Model
{
    use HasFactory;
    protected $fillable = [
        'inplayer_id',
        'outplayer_id',
        'match_id'

    ];
    protected $casts = [
        'inplayer_id'=>"integer",
        'outplayer_id'=>"integer",
        'match_id'=>"integer"
        
];
    public function inplayer(){

     return $this->belongsTo(Player::class,'inplayer_id');



    }
    public function outplayer(){

        return $this->belongsTo(Player::class,'outplayer_id');
   
   
   
       }
    public function match(){

        return $this->belongsTo(Matche::class);
   
   
   
    }   
}
