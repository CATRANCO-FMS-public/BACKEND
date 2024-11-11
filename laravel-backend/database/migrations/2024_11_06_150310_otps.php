<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 20);
            $table->string('otp', 6);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('feedback_logs_id')->nullable();
            $table->timestamps();

            $table->foreign('feedback_logs_id')->references('feedback_logs_id')->on('feedback_logs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
};
