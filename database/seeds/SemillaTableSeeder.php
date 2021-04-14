<?php

use Illuminate\Database\Seeder;

class SemillaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semillas')->insert([
            'name' => 'ninguna ',
            'description' => null,
        ]);
        DB::table('semillas')->insert([
            'name' => 'Habano ',
            'description' => null,
        ]);
        DB::table('semillas')->insert([
            'name' => 'Conerico ',
            'description' => null,
        ]);
        DB::table('semillas')->insert([
            'name' => 'Maduro ',
            'description' => null,
        ]);
        DB::table('semillas')->insert([
            'name' => 'Candela ',
            'description' => null,
        ]);

        //
    }
}
