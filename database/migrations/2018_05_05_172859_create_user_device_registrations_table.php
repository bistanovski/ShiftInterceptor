<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeviceRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserDeviceRegistrations', function (Blueprint $table) {
            $table->char('registration_id', 40);
            $table->bigInteger('user_id')->unsigned();
            $table->char('device_id', 40);
            $table->timestamps(); //created_at and updated_at columns

            $table->primary('registration_id');

            $table->foreign('device_id')->references('device_id')->on('Devices')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');        
        });

        Schema::table('UserDeviceRegistrations', function($table) {
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
        Schema::dropIfExists('UserDeviceRegistrations');
    }
}
