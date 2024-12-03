<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informatif extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_informatif';
    protected $fillable = ['title', 'type', 'content'];
}
