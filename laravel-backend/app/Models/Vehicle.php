<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = "vehicles";

    protected $primaryKey = "vehicle_id";

    protected $fillable = [
        "vehicle_type",
        "model",
        "status",
        "purchase_cost",
        "purchase_date",
        "license_plate",
        "capacity",
        "current_mileage",
        "vehicle_status",
    ];
}
