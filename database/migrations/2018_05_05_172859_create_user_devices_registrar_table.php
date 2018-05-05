<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDevicesRegistrarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserDevicesRegistrar', function (Blueprint $table) {
            $table->char('registration_id', 40);
            $table->string('username', 255);
            $table->char('device_id', 40);
            $table->timestamps(); //created_at and updated_at columns

            $table->primary('registration_id');

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
        Schema::dropIfExists('UserDevicesRegistrar');
    }
}
