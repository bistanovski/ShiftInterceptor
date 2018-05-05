<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sensors', function (Blueprint $table) {
            $table->string('sensor_name', 255);
            $table->char('device_id', 40);
            $table->integer('number_of_readings');
            $table->timestamps(); //created_at and updated_at columns

            $table->primary('sensor_name');

            $table->foreign('device_id')->references('device_id')->on('Devices')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Sensors');
    }
}
