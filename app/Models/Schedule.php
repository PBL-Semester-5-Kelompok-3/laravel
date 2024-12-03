<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_schedule';
    protected $fillable = ['time', 'keterangan', 'id_disease'];

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'id_disease', 'id_disease');
    }
}
