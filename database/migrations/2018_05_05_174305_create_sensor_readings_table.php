<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SensorReadings', function (Blueprint $table) {
            $table->increments('reading_id');
            $table->string('sensor_name', 255);
            $table->string('reading_name', 255);
            $table->string('reading_type', 255);
            $table->string('rendering_type', 255);
            $table->timestamps(); //created_at and updated_at columns

            $table->foreign('sensor_name')->references('sensor_name')->on('Sensors')
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
        Schema::dropIfExists('SensorReadings');
    }
}
