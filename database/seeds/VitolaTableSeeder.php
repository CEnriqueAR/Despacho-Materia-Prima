<?php

use Illuminate\Database\Seeder;
use App\Vitola;
class VitolaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vitolas')->insert([
        'name' => 'Habano ',
        'description' => null,
    ]);
        DB::table('vitolas')->insert([
            'name' => 'Conerico ',
            'description' => null,
        ]);
        DB::table('vitolas')->insert([
            'name' => 'Maduro ',
            'description' => null,
        ]);
        DB::table('vitolas')->insert([
            'name' => 'Candela ',
            'description' => null,
        ]);
    }

}
