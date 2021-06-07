<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
          VariedadSeeder::class,
         // VitolaTableSeeder::class,
            CalidadTableSeeder::class,
           // SemillaTableSeeder::class,
            TamanoTableSeed::class,
        ]);

    }
}
