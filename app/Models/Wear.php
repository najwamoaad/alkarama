<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seasone;
use App\Models\Sport;
class Wear extends Model
{
    use HasFactory;
    protected $fillable=
    [
        "uuid","image","seasone_id","sport_id"
    ];
    protected $casts=
    [
        "uuid"=>"string",
        "image"=>"string",
        "seasone_id"=>"integer",
        "sport_id"=>"integer",
    ];
    public function seasone()
    {
        return $this->belongsTo(Seasone::class);
    }
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
