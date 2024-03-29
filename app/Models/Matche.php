<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = [
        'uuid',
        'datetime',
        'status',
        'channel',
        "round",
        "play_ground",
        "seasone_id",
        "club1_id",
        "club2_id"

    ];
    protected $casts = [
        'datetime' => "datetime",
        'status' => "string",
        
        'channel' => "string",
        
        "play_ground" => "string",
        "seasone_id" => "integer",
        "club1_id" => "integer",
        "club2_id" => "integer"
    ];
    public function seasone() 
    {

        return $this->belongsTo(Seasone::class);



    }
    public function club1()
    {
        return $this->belongsTo(Club::class, 'club1_id');
    }

    public function club2()
    {
        return $this->belongsTo(Club::class, 'club2_id');
    }
    public function statistics() 
    {

        return $this->hasMany(Statistic::class,"matche_id");



    }
    public function Plans() 
    {

        return $this->hasMany(Plan::class);



    }
    public function Replacments()  {

        return $this->hasMany(Replacment::class);
   
   
   
       }
       public function informations()
       {
           return $this->morphMany(Information::class, 'infoable');
       }
           public function informvideo()
           {
               return $this->MorphMany(Video::class, 'videoable');
           
       }
}
