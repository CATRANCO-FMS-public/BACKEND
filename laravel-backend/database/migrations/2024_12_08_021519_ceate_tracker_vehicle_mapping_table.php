<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tracker_vehicle_mapping', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('tracker_ident', 50)->unique(); // Unique identifier for the tracker
            $table->string('vehicle_id', 10); // Link to the vehicle table
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracker_vehicle_mapping');
    }
};

