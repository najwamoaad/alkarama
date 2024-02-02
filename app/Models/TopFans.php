<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopFans extends Model
{
    use HasFactory;


    protected $table = 'top_fans';

    protected $fillable = [
        'uuid',
        'name',
        'association_id',
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }
}
