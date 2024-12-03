<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_disease';
    protected $fillable = ['name'];

    public function histories()
    {
        return $this->hasMany(History::class, 'id_disease', 'id_disease');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'id_disease', 'id_disease');
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class, 'id_disease', 'id_disease');
    }
}
