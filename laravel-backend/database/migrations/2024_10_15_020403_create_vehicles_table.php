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
            $table->string('vehicle_id', 10)->primary()->unique();
            $table->string('or_id', 50);
            $table->string('cr_id', 50);
            $table->string('plate_number', 50);
            $table->string('engine_number', 50);
            $table->string('chasis_number', 50);
            $table->string('third_pli', 20);
            $table->string('third_pli_policy_no', 50);
            $table->date('third_pli_validity');
            $table->string('ci', 50);
            $table->dateTime('ci_validity');
            $table->date('date_purchased');
            $table->string('supplier', 20);
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
