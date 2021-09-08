<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
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
        User::factory(10)->create();
        Category::factory(10)->create();
        //Video::factory(1)->create();

        $this->call([
            LevelsTableSeeder::class,
            TopicsTableSeeder::class,
            CoursesTableSeeder::class,
        ]);
    }
}
