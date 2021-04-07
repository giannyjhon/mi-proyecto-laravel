<?php

use Illuminate\Database\Seeder;
use App\Appoinment;
class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Appoinment::class, 300)->create();
    }
}
