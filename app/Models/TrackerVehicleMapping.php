<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackerVehicleMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracker_vehicle_mapping';

    protected $fillable = [
        'device_name', 
        'tracker_ident', 
        'vehicle_id', 
        'status', 
        'created_by', 
        'updated_by', 
        'deleted_by'
    ];

    /**
     * Relationship with the Vehicle model.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

    /**
     * Relationship with the User model for 'created_by'.
     */
    public function createdTrackerVehicleMapping()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    /**
     * Relationship with the User model for 'updated_by'.
     */
    public function updatedTrackerVehicleMapping()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }

    /**
     * Relationship with the User model for 'deleted_by'.
     */
    public function deletedTrackerVehicleMapping()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'user_id');
    }
}
