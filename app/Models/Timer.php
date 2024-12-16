<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "timers";

    protected $primaryKey = "timer_id";

    protected $fillable = [
        "title",           
        "start_time",     
        "end_time",        
        "minutes_interval",
        "created_by",      
        "updated_by",      
        "deleted_by",      
    ];

    // Relationships for tracking user actions
    public function createdTimer()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedTimer()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedTimer()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
