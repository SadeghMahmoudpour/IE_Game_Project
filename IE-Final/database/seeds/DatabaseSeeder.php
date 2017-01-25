<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //php artisan migrate:refresh --seed
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(RecordsTableSeeder::class);
    }
}
