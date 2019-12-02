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
        // $this->call(UsersTableSeeder::class);
        factory(\App\User::class,2)->create();
        factory(\App\User::class)->create([
            'name' => 'gamempvs@gmail.com',
            'email' => 'gamempvs@gmail.com',
            'password' => bcrypt('gamempvs@gmail.com'),
        ]);
        factory(\App\User::class)->create([
            'name' => 'gamempvs1@gmail.com',
            'email' => 'gamempvs1@gmail.com',
            'password' => bcrypt('gamempvs1@gmail.com'),
        ]);
    }
}
