<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id','title','description','start_time',"end_time","isSameDay"];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
