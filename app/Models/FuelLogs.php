<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelLogs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "fuel_logs";

    protected $primaryKey = "fuel_logs_id";

    protected $fillable = [
        "purchase_date",
        "odometer_km",
        "distance_traveled",    
        "fuel_type",
        "fuel_liters_quantity",
        "fuel_price",
        "total_expense",       
        "vehicle_id",
        "odometer_distance_proof",
        "fuel_receipt_proof",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function createdFuelLogs()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedFuelLogs()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedFuelLogs()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
