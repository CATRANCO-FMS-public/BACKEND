<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProfileVehicleAssignment extends Pivot
{
    protected $table = 'user_profile_vehicle_assignment';
    
    // Make sure timestamps are enabled
    public $timestamps = true;

    // Specify fillable fields if additional data is stored in the pivot table
    protected $fillable = [
        'user_profile_id',
        'vehicle_assignment_id',
        'created_at',
        'updated_at',
    ];
}
