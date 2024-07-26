<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    use HasFactory;

    protected $table = "dispatch";

    protected $primaryKey = "dispatch_id";

    protected $fillable = [
        "start_time",
        "end_time",
        "dispatch_status",
        "dispatch_logs_id",
    ];
}
