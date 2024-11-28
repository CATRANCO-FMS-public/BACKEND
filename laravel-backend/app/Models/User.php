<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = "users";

    protected $primaryKey = "user_id";

    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'is_logged_in',
        'user_profile_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role_id' => 'integer',
            'status' => 'boolean',
            'is_logged_in' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function profile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }

    // VehicleAssignments relationships
    public function createdAssignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'created_by');
    }

    public function updatedAssignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'updated_by');
    }

    public function deletedAssignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'deleted_by');
    }

    // FuelLogs relationships
    public function createdFuelLogs()
    {
        return $this->hasMany(FuelLogs::class, 'created_by');
    }

    public function updatedFuelLogs()
    {
        return $this->hasMany(FuelLogs::class, 'updated_by');
    }

    public function deletedFuelLogs()
    {
        return $this->hasMany(FuelLogs::class, 'deleted_by');
    }


    // MaintenanceScheduling relationships
    public function createdMaintenanceSchedules()
    {
        return $this->hasMany(MaintenanceScheduling::class, 'created_by');
    }

    public function updatedMaintenanceSchedules()
    {
        return $this->hasMany(MaintenanceScheduling::class, 'updated_by');
    }

    public function deletedMaintenanceSchedules()
    {
        return $this->hasMany(MaintenanceScheduling::class, 'deleted_by');
    }

    // Dispatch relationships
    public function createDispatch()
    {
        return $this->hasMany(Dispatch::class, 'created_by');
    }

    public function updateDispatch()
    {
        return $this->hasMany(Dispatch::class, 'updated_by');
    }

    public function deleteDispatch()
    {
        return $this->hasMany(Dispatch::class, 'deleted_by');
    }
}
