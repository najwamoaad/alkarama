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
        "uuid","win","lose","draw","+/-","points","play","seasone_id","club_id"
    ];
    protected $casts=
    [
        "uuid"=>"string",
        "win"=>"integer",
        "lose"=>"integer",
        "+/-"=>"integer",
        "points"=>"integer",
        "play"=>"integer",
        "seasone_id"=>"integer",
        "club_id"=>"integer",
    ];
    public function seasone()
    {
        return $this->belongsTo(Seasone::class);
    }
    public function clubs()
    {
        return $this->belongsTo(Club::class);
    }
}
