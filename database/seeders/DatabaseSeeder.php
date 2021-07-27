<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Levels;
use App\Models\Topics;
use App\Models\User;
use App\Models\Category;
use App\Models\Video;
use App\Models\VideoSubtitle;
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
        Video::factory(1)->create();
        Language::factory(4)->create();
        VideoSubtitle::factory(10)->create();
        // Levels
        Levels::create(['id' => 1, 'name' => 'A1', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 2, 'name' => 'A2', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 3, 'name' => 'B1', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 4, 'name' => 'B2', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 5, 'name' => 'C', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        // Topics

        Topics::created();
    }
}
