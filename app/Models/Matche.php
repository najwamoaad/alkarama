<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = [
        'datetime',
        'status',
        'plan',
        'channel',
        "round",
        "playground",
        "session_id",
        "club1_id",
        "club2_id"

    ];
    protected $casts = [
        'datetime' => "datetime",
        'status' => "string",
        'plan' => "string",
        'channel' => "string",
        "round" => "tinyinteger",
        "play_ground" => "string",
        "session_id" => "integer",
        "club1_id" => "integer",
        "club2_id" => "integer"
    ];
    public function Seasones() 
    {

        return $this->belongsTo(Seasone::class);



    }
    public function clubs() 
    {

        return $this->belongsTo(Club::class);



    }
    public function Statistics() 
    {

        return $this->hasMany(Statistic::class);



    }
    public function Plans() 
    {

        return $this->hasMany(Plan::class);



    }
    public function Replacments()  {

        return $this->hasMany(Replacment::class);
   
   
   
       }
}
