<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comment')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->string('method')->nullable();
            $table->string('route')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('browser_name')->nullable();
            $table->string('platform_name')->nullable();
            $table->string('device_family')->nullable();
            $table->string('device_model')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
