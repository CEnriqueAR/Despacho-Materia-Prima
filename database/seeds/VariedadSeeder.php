<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('variedads')->insert([
            'name' => 'Viso ',
            'description' => null,
        ]);
        DB::table('variedads')->insert([
            'name' => 'Ligero ',
            'description' => null,
        ]);
        DB::table('variedads')->insert([
            'name' => 'Seco ',
            'description' => null,
        ]);

        //
    }
}
