<?php

use Illuminate\Database\Seeder;

class CalidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('calidads')->insert([
            'name' => 'Primera ',
            'description' => null,
        ]);
        DB::table('calidads')->insert([
            'name' => 'segunda ',
            'description' => null,
        ]);
        DB::table('calidads')->insert([
            'name' => 'Tercera ',
            'description' => null,
        ]);
        DB::table('calidads')->insert([
            'name' => 'cuarta ',
            'description' => null,
        ]);   //
    }
}
