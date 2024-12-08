<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = "vehicles";

    // If vehicle_id is not auto-incrementing
    public $incrementing = false;

    protected $primaryKey = "vehicle_id";

    protected $fillable = [
        "vehicle_id",
        "or_id",
        "cr_id",
        "plate_number",
        "engine_number",
        "chasis_number",
        "third_pli",
        "third_pli_policy_no",
        "third_pli_validity",
        "ci",
        "ci_validity",
        "date_purchased",
        "supplier",
    ];

    public function assignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'vehicle_id');
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLogs::class, 'vehicle_id');
    }

    public function feedback() {
        return $this->hasMany(FeedbackLogs::class,'vehicle_id');
    }

    // Add the relationship with TrackerVehicleMapping
    public function trackerMapping()
    {
        return $this->hasOne(TrackerVehicleMapping::class, 'vehicle_id', 'vehicle_id');
    }
}
