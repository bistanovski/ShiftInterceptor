<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Settings', function (Blueprint $table) {
            $table->increments('settings_id');
            $table->string('username', 255);
            $table->char('device_id', 40);
            $table->string('key', 255);
            $table->string('type', 255);
            $table->string('value', 1000);
            $table->timestamps(); //created_at and updated_at columns

            $table->foreign('username')->references('username')->on('Users')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

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
        Schema::dropIfExists('Settings');
    }
}
