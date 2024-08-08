<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchLogVehicleAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_log_vehicle_assignment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispatch_logs_id');
            $table->unsignedBigInteger('vehicle_assignment_id');
            $table->timestamps();

            $table->foreign('dispatch_logs_id')->references('dispatch_logs_id')->on('dispatch_logs')->onDelete('cascade');
            $table->foreign('vehicle_assignment_id')->references('vehicle_assignment_id')->on('vehicle_assignment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispatch_log_vehicle_assignment');
    }
}

