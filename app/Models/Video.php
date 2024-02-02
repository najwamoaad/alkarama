<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image',
        'tupe',
        'reads',

    ];
    protected $casts = [
        'title'=>"string",
        'comment'=>"string",
        'image'=>"string",
        'type'=>'string',
        'reads'=>'integer',
        
];

    public function infoable(): MorphTo
    {
        return $this->morphTo();
    }

}
