<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_vehicle_assignment', function (Blueprint $table) {
            $table->id('user_profile_vehicle_assignment_id');
            $table->unsignedBigInteger('user_profile_id');
            $table->unsignedBigInteger('vehicle_assignment_id');
            $table->timestamps();

            $table->foreign('user_profile_id')->references('user_profile_id')->on('user_profile')->onDelete('cascade');
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
        Schema::dropIfExists('user_profile_vehicle_assignment');
    }
};
