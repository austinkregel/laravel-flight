<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('social_logins', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('driver');
            $table->string('service_id');
            $table->timestamps();

            $table->unique(['user_id', 'service_id'] );
        });
    }
    public function down()
    {
        Schema::dropIfExists('social_logins');
    }
};
