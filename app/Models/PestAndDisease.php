<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestAndDisease extends Model
{
    use HasFactory;
    protected $table = 'pestdesease';
    protected $fillable = [
        'name',
        'description',
        'warning',
        'genus',
        'scientific_name',
        'aliases',
        'symptoms',
        'solutions',
        'source',
    ];
}
