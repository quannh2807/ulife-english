<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Course::create(['id' => 1, 'name' => 'A1. Người mới bắt đầu', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'status' => 1, 'level_id' => 1, 'thumb_img' => '', 'created_by' => 1, 'updated_by' => 1]);
        Course::create(['id' => 2, 'name' => 'A2. Lower intermediate', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'status' => 1, 'level_id' => 2, 'thumb_img' => '', 'created_by' => 1, 'updated_by' => 1]);
        Course::create(['id' => 3, 'name' => 'B1. Intermediate', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'status' => 1, 'level_id' => 3, 'thumb_img' => '', 'created_by' => 1, 'updated_by' => 1]);
        Course::create(['id' => 4, 'name' => 'B2. Upper intermediate', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'status' => 1, 'level_id' => 4, 'thumb_img' => '', 'created_by' => 1, 'updated_by' => 1]);
        Course::create(['id' => 5, 'name' => 'C1. Advance', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'status' => 1, 'level_id' => 5, 'thumb_img' => '', 'created_by' => 1, 'updated_by' => 1]);
        Course::create(['id' => 6, 'name' => 'C2. Business', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'status' => 1, 'level_id' => 5, 'thumb_img' => '', 'created_by' => 1, 'updated_by' => 1]);
    }
}
