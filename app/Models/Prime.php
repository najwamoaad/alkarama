<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'image',
        'type',
        'seasone_id',
        'sport_id',
    ];
    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'description' => 'string'
    ];
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    public function seasone()
    {
        return $this->belongsTo(Seasone::class);
    }
}
