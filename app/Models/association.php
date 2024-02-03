<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class association extends Model
{
    use HasFactory;
    

    protected $table = 'associations';

    protected $fillable = [
        'uuid',
        'boss',
        'image',
        'description',
        'country',
        'sport_id',
    ];

    public function topFans()
    {
        return $this->hasMany(TopFans::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }



}
