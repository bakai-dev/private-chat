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
        //factory(\App\User::class,2)->create();
        factory(\App\User::class)->create([
            'name' => 'test@gmail.com',
            'email' => 'test@gmail.com',
            'password' => bcrypt('test@gmail.com'),
        ]);
        factory(\App\User::class)->create([
            'name' => 'test2@gmail.com',
            'email' => 'test2@gmail.com',
            'image' => 'https://yt3.ggpht.com/-zaCHwdX2ywQ/AAAAAAAAAAI/AAAAAAAAAAA/BAgF9LisZ0Y/s108-c-k-c0x00ffffff-no-rj-mo/photo.jpg',
            'password' => bcrypt('test2@gmail.com'),
        ]);
        factory(\App\User::class)->create([
            'name' => 'Dog Woofson',
            'email' => 'Dog@gmail.com',
            'image' => 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/382994/dog.png',
            'password' => bcrypt('Dog@gmail.com'),
        ]);
        factory(\App\User::class)->create([
            'name' => 'Louis CK',
            'email' => 'Louis@gmail.com',
            'image' => 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/382994/louis-ck.jpeg',
            'password' => bcrypt('Louis@gmail.com'),
        ]);

        \App\Models\Session::create([
            'user1_id' => '3',
            'user2_id' => '1',
        ]);

        \App\Models\Message::create([
            'content' => 'Hello, can you hear me?',
            'session_id' => '1',
        ]);
        \App\Models\Message::create([
            'content' => 'Hey human!',
            'session_id' => '1',
        ]);
        \App\Models\Message::create([
            'content' => 'When we were younger and free... love this song) woof',
            'session_id' => '1',
        ]);

        \App\Models\Chat::create([
            'message_id' => '1',
            'session_id' => '1',
            'user_id' => '3',
            'type' => 0
        ]);

        \App\Models\Chat::create([
            'message_id' => '1',
            'session_id' => '1',
            'user_id' => '1',
            'type' => 1
        ]);


        \App\Models\Chat::create([
            'message_id' => '2',
            'session_id' => '1',
            'user_id' => '1',
            'type' => 1
        ]);

        \App\Models\Chat::create([
            'message_id' => '2',
            'session_id' => '1',
            'user_id' => '3',
            'type' => 0
        ]);

        \App\Models\Chat::create([
            'message_id' => '3',
            'session_id' => '1',
            'user_id' => '1',
            'type' =>  1
        ]);
        \App\Models\Chat::create([
            'message_id' => '3',
            'session_id' => '1',
            'user_id' => '3',
            'type' => 0
        ]);


    }
}
