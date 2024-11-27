<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $table = "terminals";

    protected $primaryKey = "terminal_id";

    protected $fillable = [
        "terminal_name",
    ];

    public function dispatches()
    {
        return $this->hasMany(Dispatch::class, 'terminal_id');
    }
}
