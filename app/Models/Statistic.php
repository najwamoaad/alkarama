<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $table = 'statistics';

    protected $fillable = [
        'uuid',
        'name',
        'value',
        'matche_id',
    ];
    
    public function metche()
    {
        $data = $this->belongsTo(Matche::class,"matche_id","id");
       
        return $data;
    }
}
