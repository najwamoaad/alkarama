<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'description',
        'uuid'
    ];
    protected $casts = [
       
        
];

    public function infoable(): MorphTo
    {
        return $this->morphTo();
    }

}
