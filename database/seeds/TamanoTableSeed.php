<?php

use Illuminate\Database\Seeder;

class TamanoTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tamanos')->insert([
            'name' => 'ninguna ',
            'description' => null,
        ]);
        DB::table('tamanos')->insert([
            'name' => 'Grande ',
            'description' => null,
        ]);
        DB::table('tamanos')->insert([
            'name' => 'Mediano ',
            'description' => null,
        ]);
        DB::table('tamanos')->insert([
            'name' => 'Pequeño ',
            'description' => null,
        ]);

        //
    }
}
