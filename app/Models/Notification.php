<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_notification';
    protected $fillable = ['id_user', 'title', 'message', 'type', 'scheduled_time'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'user_id');
    }
}
