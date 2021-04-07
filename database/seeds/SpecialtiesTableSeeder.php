<?php

use Illuminate\Database\Seeder;
use App\Specialty;
use App\User;
class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $specialidades = [
        'Oftalmologia',
        'Pediatría',
        'Neurología'
      ];

      foreach ($specialidades as $especialtyName) {
      $specialty =  Specialty::create([
          'name' =>$especialtyName
        ]);

        $specialty->users()->saveMany(
          factory(User::class, 3)->states('doctor')->make()
        );

          user::find(3)->specialties()->save($specialty);
      }

    }
}
