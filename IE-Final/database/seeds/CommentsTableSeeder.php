<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=CommentsTableSeeder
        DB::table('comments')->insert([
            'user_id' => 1,
            'game_id' => 1,
            'text' => 'خوب بود',
            'rate' => 3,
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'user_id' => 2,
            'game_id' => 1,
            'text' => 'بد بود',
            'rate' => 1,
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'user_id' => 1,
            'game_id' => 2,
            'text' => 'میتونس خوب باشه',
            'rate' => 2,
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'user_id' => 4,
            'game_id' => 1,
            'text' => 'عالی بود',
            'rate' => 4,
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'user_id' => 3,
            'game_id' => 2,
            'text' => 'خوب نبود',
            'rate' => 2,
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'user_id' => 4,
            'game_id' => 2,
            'text' => 'خیلی خوب بود',
            'rate' => 5,
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
