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
        "start_time",
        "end_time",
        "status",
        "route",
        "vehicle_assignment_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public function vehicleAssignments()
    {
        return $this->belongsTo(VehicleAssignment::class, 'vehicle_assignment_id');
    }

    // Relationship to VehicleOverspeedTracking
    public function overspeedTrackings()
    {
        return $this->hasMany(VehicleOverspeedTracking::class, 'dispatch_logs_id');
    }

    public function createdDispatch()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedDispatch()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedDispatch()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
