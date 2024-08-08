<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dispatch_logs', function (Blueprint $table) {
            // First, drop the foreign key constraint
            $table->dropForeign(['vehicle_assignment_id']);
            
            // Then, drop the column
            $table->dropColumn('vehicle_assignment_id');
        });
    }

    public function down()
    {
        Schema::table('dispatch_logs', function (Blueprint $table) {
            // Re-add the column
            $table->unsignedBigInteger('vehicle_assignment_id')->nullable();

            // Re-add the foreign key constraint
            $table->foreign('vehicle_assignment_id')
                  ->references('vehicle_assignment_id')
                  ->on('vehicle_assignment')
                  ->onDelete('cascade');
        });
    }
};

