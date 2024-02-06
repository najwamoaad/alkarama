<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sport;
use App\Models\Plane;
class Player extends Model
{
    use HasFactory;
    protected $fillable=
    [
        "uuid","name","high","play","number","born",
        "from","first_club","career","image","sport_id"
    ]; 
    protected $casts=
    [
        "uuid"=>"string","name"=>"string","high"=>"integer",
        "play"=>"string","number"=>"integer","born"=>"datetime",
        "from"=>"string","first_club"=>"string","career"=>"string",
        "image"=>"string","sport_id"=>"integer"
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    public function replacments()
    {
        return $this->hasMany(Replacment::class);
    }
    public function plans()
    {
        return $this->hasMany(Plane::class);
    }
}
