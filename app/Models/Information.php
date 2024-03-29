<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Information extends Model
{
    protected $table = 'informations';
    use HasFactory;
    protected $fillable = [
        'uuid',
        'title',
        'content',
        'image',
        'type',
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
