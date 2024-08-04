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
        "vehicle_assignment_id",
        "fuel_logs_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public function vehicleAssignment()
    {
        return $this->belongsTo(VehicleAssignment::class, 'vehicle_assignment_id');
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
