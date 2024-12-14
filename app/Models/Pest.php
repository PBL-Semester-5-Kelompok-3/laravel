<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    protected $table = 'pest';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function disease()
    {
        return $this->belongsTo(Disease::class, 'id_disease', 'id_disease');
    }
}
