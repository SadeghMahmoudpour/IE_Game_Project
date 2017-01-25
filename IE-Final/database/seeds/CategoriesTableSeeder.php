<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=CategoriesTableSeeder
        DB::table('categories')->insert([
            'name' => 'تیراندازی',
        ]);
        DB::table('categories')->insert([
            'name' => 'اول شخص',
        ]);
        DB::table('categories')->insert([
            'name' => 'اکشن',
        ]);
        DB::table('categories')->insert([
            'name' => 'ماجراجویی',
        ]);
    }
}
