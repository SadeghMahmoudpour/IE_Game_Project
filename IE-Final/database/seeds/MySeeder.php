<?php

use Illuminate\Database\Seeder;

class MySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=MySeeder
//        DB::table('category_user')->insert([
//            'category_id' => 1,
//            'user_id' => 6,
//        ]);
//        DB::table('category_user')->insert([
//            'category_id' => 2,
//            'user_id' => 6,
//        ]);
//        DB::table('category_user')->insert([
//            'category_id' => 3,
//            'user_id' => 6,
//        ]);
//        DB::table('category_user')->insert([
//            'category_id' => 4,
//            'user_id' => 6,
//        ]);
//        DB::table('records')->insert([
//            'user_id' => 6,
//            'game_id' => 1,
//            'score' => 3,
//            'level' => 1,
//            'displacement' => -3,
//        ]);

        DB::table('records')->insert([
            'user_id' => 7,
            'game_id' => 1,
            'score' => 39,
            'level' => 3,
            'displacement' => -1,
        ]);
    }
}
