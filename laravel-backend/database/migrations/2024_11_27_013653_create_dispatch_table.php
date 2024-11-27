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
        Schema::create('dispatch', function (Blueprint $table) {
            $table->id('dispatch_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->enum('dispatch_status', ['on_alley', 'on_road', 'completed']);
            $table->unsignedBigInteger('terminal_id');
            $table->unsignedBigInteger('vehicle_assignment_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('terminal_id')->references('terminal_id')->on('terminals')->onDelete('cascade');
            $table->foreign('vehicle_assignment_id')->references('vehicle_assignment_id')->on('vehicle_assignment')->onDelete('cascade');
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
        Schema::table('dispatch', function (Blueprint $table) {
            $table->dropForeign(['timer_id']);
            $table->dropForeign(['route_id']);
            $table->dropForeign(['vehicle_assignment_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::dropIfExists('dispatch');
    }
};
