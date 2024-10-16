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
        Schema::create('maintenance_scheduling', function (Blueprint $table) {
            $table->id('maintenance_scheduling_id');
            $table->enum('maintenance_type', ['oil_change', 'tire_rotation', 'brake_inspection', 'engine_check', 'transmission_service']);
            $table->decimal('maintenance_cost', 10, 2);
            $table->dateTime('maintenance_date');
            $table->enum('maintenance_status', ['active', 'inactive'])->default('active');
            $table->string('vehicle_id', 10);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('cascade');
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
        Schema::table('maintenance_scheduling', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::dropIfExists('maintenance_scheduling');
    }
};
