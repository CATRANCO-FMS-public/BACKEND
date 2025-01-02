<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOverspeedTracking extends Model
{
    use HasFactory;

    protected $table = 'vehicle_overspeed_tracking';

    protected $primaryKey = 'id';

    protected $fillable = [
        'overspeed_timestamp',
        'dispatch_logs_id',
        'vehicle_id',
        'speed',
        'latitude',
        'longitude',
    ];

    // Relationship to DispatchLogs
    public function dispatchTrackingOverspeed()
    {
        return $this->belongsTo(DispatchLogs::class, 'dispatch_logs_id');
    }

    // Relationship to Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }
}
