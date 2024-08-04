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
            $table->dateTime('end_time');
            $table->enum('dispatch_status', ['in_progress', 'completed', 'cancelled']);
            $table->unsignedBigInteger('dispatch_logs_id');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('dispatch_logs_id')->references('dispatch_logs_id')->on('dispatch_logs')->onDelete('cascade');
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
            $table->dropForeign(['dispatch_logs_id']);
        });
        Schema::dropIfExists('dispatch');
    }
};