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
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id('user_profile_id');
            $table->string('last_name', 100);
            $table->string('first_name', 100);
            $table->char('middle_initial', 1)->nullable();
            $table->string('license_number', 50)->nullable();
            $table->string('address', 255);
            $table->date('date_of_birth');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('contact_number', 20);
            $table->string('contact_person', 20); 
            $table->string('contact_person_number', 20);
            $table->string('user_profile_image', 255)->nullable();
            $table->enum('position', [
                'operation_manager', 
                'dispatcher', 
                'driver', 
                'passenger_assistant_officer'
            ]);
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
        Schema::dropIfExists('user_profile');
    }
};
