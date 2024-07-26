<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchLogs extends Model
{
    use HasFactory;

    protected $table = "dispatch_logs";

    protected $primaryKey = "dispatch_logs_id";

    protected $fillable = [
        "vehicle_fuel_status",
        "assignment_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];
}
