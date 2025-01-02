<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicle_overspeed_tracking', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->timestamp('overspeed_timestamp'); // Timestamp of when overspeeding occurred
            $table->unsignedBigInteger('dispatch_logs_id'); // Foreign key reference to tracker_vehicle_mapping
            $table->string('vehicle_id', 10); // Foreign key reference to vehicles
            $table->decimal('speed', 5, 2); // Speed at the time of overspeeding
            $table->decimal('latitude', 10, 7); // Latitude of the overspeeding location
            $table->decimal('longitude', 10, 7); // Longitude of the overspeeding location
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('dispatch_logs_id')
                  ->references('dispatch_logs_id')
                  ->on('dispatch_logs')
                  ->onDelete('cascade');
            
            $table->foreign('vehicle_id')
                  ->references('vehicle_id')
                  ->on('vehicles')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('vehicle_overspeed_tracking', function (Blueprint $table) {
            $table->dropForeign(['dispatch_logs_id']);
            $table->dropForeign(['vehicle_id']);
        });
        Schema::dropIfExists('vehicle_overspeed_tracking');
    }
};
