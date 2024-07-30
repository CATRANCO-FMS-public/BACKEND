<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    use HasFactory;

    protected $table = "vehicle_assignment";

    protected $primaryKey = "vehicle_assignment_id";

    protected $fillable = [
        "assignment_date",
        "return_date",
        "user_profile_id",
        "vehicle_id",
        "created_by",
        "updated_by",
        "deleted_by",
    ];


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }


    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
