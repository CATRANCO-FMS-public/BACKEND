<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    use HasFactory;

    protected $table = "vehicle_assignment";

    protected $primaryKey = "vehicle_assignment_id";

    protected $fillable = [
        "vehicle_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function createdAssignments()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function updatedAssignments()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function deletedAssignments()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function userProfiles()
    {
        return $this->belongsToMany(UserProfile::class, 'user_profile_vehicle_assignment', 'vehicle_assignment_id', 'user_profile_id')
            ->using(UserProfileVehicleAssignment::class)
            ->withTimestamps(); // Include timestamps if they exist
    }
}
