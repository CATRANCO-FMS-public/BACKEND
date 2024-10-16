<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelLogs extends Model
{
    use HasFactory;

    protected $table = "fuel_logs";

    protected $primaryKey = "fuel_logs_id";

    protected $fillable = [
        "purchase_date",
        "distance_travelled", 
        "odometer_km",        
        "fuel_type",          
        "fuel_quantity",
        "fuel_price",
        "total_cost",         
        "vehicle_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function dispatch()
    {
        return $this->hasMany(Dispatch::class, 'fuel_logs_id');
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
