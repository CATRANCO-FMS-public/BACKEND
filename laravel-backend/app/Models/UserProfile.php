<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = "user_profiles";

    protected $primaryKey = "user_profile_id";

    protected $fillable = [
        "last_name",
        "first_name",
        "middle_initial",
        "license_number",
        "address",
        "date_of_birth",
        "contact_number",
        "position",
        "user_id",
    ];

    protected $casts = [
        "user_id"=> "integer",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function assignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'user_profile_id');
    }
}
