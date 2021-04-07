<?php

use Faker\Generator as Faker;
use App\Appoinment;
use App\User;
$factory->define(Appoinment::class, function (Faker $faker) {
    $doctorIds = User::doctors()->pluck('id');
    $patientIds = User::patients()->pluck('id');

    $date = $faker -> dateTimeBetween('-1 years', 'now');
    $scheduled_date = $date->format('Y-m-d');
    $scheduled_time = $date->format('H:i:s');

    $types = ['Consulta', 'Examen', 'Operación'];
    $status = ['Atendida', 'Cancelada'];
    return [
        'description' => $faker->sentence(5),
        'specialty_id' => $faker->numberBetween(1, 3),
        'doctor_id' => $faker->randomElement($doctorIds),
        'patient_id' => $faker->randomElement($patientIds),
        'scheduled_date' => $scheduled_date,
        'scheduled_time' => $scheduled_time,
        'type' => $faker ->randomElement($types),
        'status' => $faker ->randomElement($status)
    ];
});
