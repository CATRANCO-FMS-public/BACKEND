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
        "fuel_logs_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public function vehicleAssignments()
    {
        return $this->belongsToMany(VehicleAssignment::class, 'dispatch_log_vehicle_assignment', 'dispatch_logs_id', 'vehicle_assignment_id')->using(DispatchLogVehicleAssignment::class);
    }

    public function fuelLogs()
    {
        return $this->belongsTo(FuelLogs::class, 'fuel_logs_id');
    }

    public function createdDispatchLogs()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedDispatchLogs()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedDispatchLogs()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function dispatches() {
        return $this->hasMany(Dispatch::class,'dispatch_logs_id');
    }
}
