<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table="users";

    protected $primaryKey= "user_id";

    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'is_logged_in',
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
        return $this->hasOne(UserProfile::class, 'user_id');
    }
}
