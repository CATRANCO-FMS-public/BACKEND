<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProfileVehicleAssignment extends Pivot
{
    protected $table = 'user_profile_vehicle_assignment';
    
    // Make sure timestamps are enabled
    public $timestamps = true;
}
