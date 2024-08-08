<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
class DispatchLogVehicleAssignment extends Pivot
{
    protected $table = 'dispatch_log_vehicle_assignment';
    
    // Make sure timestamps are enabled
    public $timestamps = true;
}
