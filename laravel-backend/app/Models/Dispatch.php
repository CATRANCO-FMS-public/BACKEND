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
        "terminal_id", 
        "vehicle_assignment_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public function vehicleAssignments()
    {
        return $this->belongsTo(VehicleAssignment::class, 'vehicle_assignment_id');
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
