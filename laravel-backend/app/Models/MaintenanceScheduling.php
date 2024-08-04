<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceScheduling extends Model
{
    use HasFactory, SoftDeletes;

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

    // Relationship with the Vehicle model
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    // Relationship with the User model for created_by
    public function createdMaintenanceSchedules()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with the User model for updated_by
    public function updatedMaintenanceSchedules()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relationship with the User model for deleted_by
    public function deletedMaintenanceSchedules()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}