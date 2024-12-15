<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'id_disease', 'label', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'id_disease', 'id');
    }
}
