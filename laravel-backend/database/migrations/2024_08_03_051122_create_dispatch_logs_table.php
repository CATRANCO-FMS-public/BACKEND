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
        Schema::create('dispatch_logs', function (Blueprint $table) {
            $table->id('dispatch_logs_id');
            $table->unsignedBigInteger('vehicle_assignment_id');
            $table->unsignedBigInteger('fuel_logs_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('vehicle_assignment_id')->references('vehicle_assignment_id')->on('vehicle_assignment')->onDelete('cascade');
            $table->foreign('fuel_logs_id')->references('fuel_logs_id')->on('fuel_logs')->onDelete('cascade'); // Reference to fuel_logs
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispatch_logs', function (Blueprint $table) {
            $table->dropForeign(['vehicle_assignment_id']);
            $table->dropForeign(['fuel_logs_id']); // Drop the foreign key
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::dropIfExists('dispatch_logs');
    }
};

