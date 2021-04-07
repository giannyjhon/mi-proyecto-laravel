<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelledAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelled_appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('appoinment_id');
          //relacion con la cita que se cancela
          $table->foreign('appoinment_id')->references('id')->on('appoinments');

            $table->string('justification')->nullable();

            $table->unsignedInteger('cancelled_by');
//relacion con usuario quien cancela
  $table->foreign('cancelled_by')->references('id')->on('users');


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
        Schema::dropIfExists('cancelled_appointments');
    }
}
