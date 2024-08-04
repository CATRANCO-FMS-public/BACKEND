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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id('user_profile_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->char('middle_initial')->nullable();
            $table->string('license_number')->nullable();
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('contact_number');
            $table->enum('position', ['Admin','Dispatcher','Driver','Conductor']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *  
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
