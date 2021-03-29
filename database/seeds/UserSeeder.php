<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'admin ',

           'is_banda' => true,
        'is_capa' => false,
       'email'  => 'admin@admin.com',
       'password'=>bcrypt("admin321"),
        ]);
        DB::table('users')->insert([
            'name' => 'admin2 ',

            'is_banda' => false,
            'is_capa' => true,
            'email'  => 'admin2@admin.com',

            'password'=>bcrypt("admin321")
        ]);
        //
    }
}
