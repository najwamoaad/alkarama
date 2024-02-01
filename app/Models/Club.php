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
    public function sports()
    {
        return $this->belongsTo(Sport::class);
    }
    public function matches()
    {
        return $this->hasMany(Matche::class);
    }

}
