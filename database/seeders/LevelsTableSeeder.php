<?php

namespace Database\Seeders;

use App\Models\Levels;
use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Levels::create(['id' => 1, 'name' => 'A1', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 2, 'name' => 'A2', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 3, 'name' => 'B1', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 4, 'name' => 'B2', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 5, 'name' => 'C', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
    }
}
