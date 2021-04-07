<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppoinmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appoinments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description');
            //fk especialidad
            $table->unsignedInteger('specialty_id');
            $table->foreign('specialty_id')->references('id')->on('specialties');

            //fk doctor
            $table->unsignedInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');

            //fk paciente
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

            $table->date('scheduled_date');
            $table->time('scheduled_time');

            $table->string('type');

          

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
        Schema::dropIfExists('appoinments');
    }
}
