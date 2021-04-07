<?php

use Illuminate\Database\Seeder;
use App\Empleado;
class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Empleado::class())->create(10);
        //
    }
}
