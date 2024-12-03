<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_solution';
    protected $fillable = ['keterangan_solution', 'id_disease'];

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'id_disease', 'id_disease');
    }
}
