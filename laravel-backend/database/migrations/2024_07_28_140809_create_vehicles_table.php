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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->string('vehicle_type', 50);
            $table->string('model', 100);
            $table->decimal('purchase_cost', 10, 2);
            $table->dateTime('purchase_date');
            $table->string('license_plate', 20);
            $table->integer('capacity');
            $table->integer('current_mileage');
            $table->enum('vehicle_status', ['idle', 'moving', 'maintenance', 'decommissioned']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
