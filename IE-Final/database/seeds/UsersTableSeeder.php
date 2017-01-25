<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=UsersTableSeeder
        DB::table('users')->insert([
            'name' => 'صادق',
            'email' => 'sadegh@gmail.com',
            'password' => Hash::make('sadeghsadegh'),
            'admin' => true,
            'avatar' => 'http://semantic-ui.com/images/avatar/small/christian.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'هلی',
            'email' => 'heli@gmail.com',
            'password' => Hash::make('heli'),
            'admin' => false,
            'avatar' => 'http://semantic-ui.com/images/avatar/small/helen.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'سامان',
            'email' => 'saman@gmail.com',
            'password' => Hash::make('saman'),
            'admin' => false,
            'avatar' => 'http://semantic-ui.com/images/avatar/small/stevie.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'آرمین',
            'email' => 'armin@gmail.com',
            'password' => Hash::make('armin'),
            'admin' => false,
            'avatar' => 'http://semantic-ui.com/images/avatar/small/zoe.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'امیر',
            'email' => 'amir@gmail.com',
            'password' => Hash::make('amir'),
            'admin' => false,
            'avatar' => 'http://semantic-ui.com/images/avatar/small/elliot.jpg',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            DB::table('category_user')->insert([
                'category_id' => rand(1, 2),
                'user_id' => $i,
            ]);
            DB::table('category_user')->insert([
                'category_id' => rand(3, 4),
                'user_id' => $i,
            ]);
        }
    }
}
