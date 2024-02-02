<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wear;
use App\Models\standing;
use App\Models\Employee;
use App\Models\Metch;
use App\Models\Prime;
class Seasone extends Model
{
    use HasFactory;
    protected $fillable=
    [
        "uuid","name","start_date","end_date",
    ];
    protected $casts=
    [
        "name"=>"string",
        "start_date"=>"date_time",
        "end_date"=>"date_time",
    ];
    public function wears()
    {
        return $this->hasMany(Wear::class);
    }
    public function standings()
    {
        return $this->hasMany(standing::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function primes()
    {
        return $this->hasMany(Prime::class);
    }

    public function metches()
    {
        return $this->hasMany(Matche::class);
    }
}
