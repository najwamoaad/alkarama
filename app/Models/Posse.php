<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posse extends Model
{   protected $table = 'posses';
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'image'

    ];
    protected $casts = [
        'name'=>"string",
        'start_date'=>"date",
        'image'=>"string"
        
];
}
