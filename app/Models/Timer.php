<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;

    protected $table = "timers";

    protected $primaryKey = "timer_id";

    protected $fillable = [
        "title",           
        "start_time",     
        "end_time",        
        "minutes_interval"
    ];
    
}
