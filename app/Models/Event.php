<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','description','start_time',"end_time","isSameDay","color","user_id"];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
