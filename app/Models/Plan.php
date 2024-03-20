<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';

    protected $fillable = [
        'uuid',
        'player_id',
        'matche_id',
        'status',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function matche()
    {
        return $this->belongsTo(Matche::class);
    }
    
}
