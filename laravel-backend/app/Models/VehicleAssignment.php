<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    use HasFactory;

    protected $table = "vehicle_assignment";

    protected $primaryKey = "assignment_id";

    protected $fillable = [
        "assignment_date",
        "return_date",
        "user_profile_id",
        "vehicle_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];
}
