<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tracker_vehicle_mapping', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('device_name');
            $table->string('tracker_ident', 50)->unique();
            $table->string('vehicle_id', 10); 
            $table->enum('status', ['active', 'inactive']);
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

    public function down()
    {
        Schema::table('tracker_vehicle_mapping', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::dropIfExists('tracker_vehicle_mapping');
    }
};
