<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackLogs extends Model
{
    use HasFactory;

    protected $table = "feedback_logs";

    protected $primaryKey = "feedback_logs_id";

    protected $fillable = [
        "phone_number",
        "rating",
        "comments",
        "vehicle_id",
    ];

    public function vehicle() {
        return $this ->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function otp()
    {
        return $this->hasOne(OTP::class, 'feedback_logs_id');
    }
}
