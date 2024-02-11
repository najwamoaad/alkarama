<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seasone;
use App\Models\Club;
class Standing extends Model
{
    use HasFactory;
    protected $fillable=
    [
        "uuid","win","lose","draw","plus","play","seasone_id","club_id"
    ];
    protected $casts=
    [
        "uuid"=>"string",
        "win"=>"integer",
        "lose"=>"integer",
        "plus"=>"integer",
     
        "play"=>"integer",
        "seasone_id"=>"integer",
        "club_id"=>"integer",
    ];
    public function seasone()
    {
        return $this->belongsTo(Seasone::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
