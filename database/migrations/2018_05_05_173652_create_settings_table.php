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
            $table->bigInteger('user_id')->unsigned();
            $table->char('device_id', 40);
            $table->string('key', 255);
            $table->string('type', 255);
            $table->string('value', 1000);
            $table->timestamps(); //created_at and updated_at columns

            $table->foreign('device_id')->references('device_id')->on('Devices')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');  
        });

        Schema::table('Settings', function($table) {
            $table->foreign('user_id')->references('id')->on('Users')
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
