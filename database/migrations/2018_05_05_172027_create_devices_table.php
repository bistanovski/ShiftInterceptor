<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Devices', function (Blueprint $table) {
            $table->char('device_id', 40);
            $table->string('name', 255);
            $table->enum('type', array('DESKTOP', 'MOBILE', 'EMBEDDED'));
            $table->string('operating_system', 255);
            $table->string('os_version', 50);
            $table->integer('number_of_sensors');
            $table->timestamps(); //created_at and updated_at columns

            $table->primary('device_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Devices');
    }
}
