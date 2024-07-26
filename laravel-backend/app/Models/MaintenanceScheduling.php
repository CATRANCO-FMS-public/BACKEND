<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceScheduling extends Model
{
    use HasFactory;

    protected $table = "maintenance_scheduling";

    protected $primaryKey = "maintenance_scheduling_id";

    protected $fillable = [
        "maintenance_type",
        "maintenance_cost",
        "maintenance_date",
        "vehicle_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];
}
