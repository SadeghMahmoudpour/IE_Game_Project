<?php

use Illuminate\Database\Seeder;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=RecordsTableSeeder
        DB::table('records')->insert([
            'user_id' => 1,
            'game_id' => 1,
            'score' => 121,
            'level' => 23,
            'displacement' => 3,
        ]);
        DB::table('records')->insert([
            'user_id' => 1,
            'game_id' => 2,
            'score' => 124,
            'level' => 20,
            'displacement' => 3,
        ]);
        DB::table('records')->insert([
            'user_id' => 2,
            'game_id' => 1,
            'score' => 111,
            'level' => 23,
            'displacement' => 3,
        ]);
        DB::table('records')->insert([
            'user_id' => 3,
            'game_id' => 1,
            'score' => 123,
            'level' => 23,
            'displacement' => 3,
        ]);
        DB::table('records')->insert([
            'user_id' => 4,
            'game_id' => 1,
            'score' => 18,
            'level' => 23,
            'displacement' => 3,
        ]);
        DB::table('records')->insert([
            'user_id' => 5,
            'game_id' => 1,
            'score' => 11,
            'level' => 23,
            'displacement' => 3,
        ]);
        DB::table('records')->insert([
            'user_id' => 2,
            'game_id' => 2,
            'score' => 101,
            'level' => 23,
            'displacement' => 3,
        ]);
    }
}
