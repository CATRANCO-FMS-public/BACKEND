<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = "user_profile";

    protected $primaryKey = "user_profile_id";

    protected $fillable = [
        "last_name",
        "first_name",
        "middle_initial",
        "license_number",
        "address",
        "date_of_birth",
        "sex",
        "contact_number",
        "contact_person",
        "contact_person_number",
        "user_profile_image",
        "position",
    ];

    protected $casts = [
        "user_id"=> "integer",
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_profile_id');
    }

    
    public function assignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'user_profile_id');
    }

    public function vehicleAssignments()
    {
        return $this->belongsToMany(VehicleAssignment::class, 'user_profile_vehicle_assignment', 'user_profile_id', 'vehicle_assignment_id')->using(UserProfileVehicleAssignment::class);
    }
}
