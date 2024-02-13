<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $fillable = [
       'uuid',
        'name',
        'address',
        'logo',
        'sport_id',
    ];
    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'address' => 'string',
    ];
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    public function matches()
    {
        return $this->hasMany(Matche::class);
    }
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
     
    public function informations() 
    {
        return $this->MorphMany(Information::class, 'infoable');
    }
    public function informvideo() 
    {
        return $this->MorphMany(Video::class, 'videoable');
    }
}
