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
        'name' => '50x6 ',
        'description' => null,
    ]);
        DB::table('vitolas')->insert([
            'name' => '50x7 ',
            'description' => null,
        ]);
        DB::table('vitolas')->insert([
            'name' => '60x3 ',
            'description' => null,
        ]);
        DB::table('vitolas')->insert([
            'name' => '60x4 ',
            'description' => null,
        ]);
    }

}
