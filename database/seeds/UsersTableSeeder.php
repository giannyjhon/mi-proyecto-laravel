<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create([
        'name' => 'gianny',
        'email' => 'giannyjhon@gmail.com',
        'password' => bcrypt('gianny'), // secret
        'address' => 'Av Angamos 983',
        'phone' => '933600880',
        'dni' => '002419391',
        'role' => 'admin'
      ]);

      User::create([
        'name' => 'Paciente 1',
        'email' => 'paciente1@gmail.com',
        'password' => bcrypt('gianny'), // secret,
        'role' => 'patient'
      ]);

      User::create([
        'name' => 'Médico 1',
        'email' => 'medico1@gmail.com',
        'password' => bcrypt('gianny'), // secret
        'role' => 'doctor'
      ]);
      factory(User::class, 50)->states('patient')->create();

    }
}
