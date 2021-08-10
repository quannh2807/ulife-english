<?php

namespace Database\Seeders;

use App\Models\Course;
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
        //Video::factory(1)->create();

        // Levels
        Levels::create(['id' => 1, 'name' => 'A1', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 2, 'name' => 'A2', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 3, 'name' => 'B1', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 4, 'name' => 'B2', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Levels::create(['id' => 5, 'name' => 'C', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);

        // Topics
        Topics::create(['id' => 1, 'level_id' => 1, 'name' => 'Cấu trúc chung của một câu', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 2, 'level_id' => 1, 'name' => 'Đại từ nhân xưng', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 3, 'level_id' => 1, 'name' => 'Tính từ sở hữu', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 4, 'level_id' => 1, 'name' => 'Động từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 5, 'level_id' => 1, 'name' => 'Tính từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 6, 'level_id' => 1, 'name' => 'Danh từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 7, 'level_id' => 1, 'name' => 'Mạo từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 8, 'level_id' => 1, 'name' => 'Trạng từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 9, 'level_id' => 1, 'name' => 'Giới từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 10, 'level_id' => 1, 'name' => 'Sở hữu cách', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 11, 'level_id' => 1, 'name' => 'Thì hiện tại đơn giản', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 12, 'level_id' => 1, 'name' => 'Thì hiện tại tiếp diễn', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 13, 'level_id' => 1, 'name' => 'Thì tương lai đơn giản', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 14, 'level_id' => 2, 'name' => 'Sự hòa hợp giữa chủ ngữ và động từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 15, 'level_id' => 2, 'name' => 'Tân ngữ và các vấn đề liên quan', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 16, 'level_id' => 2, 'name' => 'Phân động từ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 17, 'level_id' => 2, 'name' => 'Động từ BQT cơ bản', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 18, 'level_id' => 2, 'name' => 'Động từ khuyết thiếu', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 19, 'level_id' => 2, 'name' => 'Tiền tố, hậu tố', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 20, 'level_id' => 2, 'name' => 'Thì quá khứ đơn giản', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 21, 'level_id' => 2, 'name' => 'Thì tương lai đơn giản', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 22, 'level_id' => 2, 'name' => 'Thì quá khứ tiếp diễn', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 23, 'level_id' => 3, 'name' => 'Đại từ phản thân', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 24, 'level_id' => 3, 'name' => 'Đại từ sở hữu', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 25, 'level_id' => 3, 'name' => 'Các dạng so sánh', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 26, 'level_id' => 3, 'name' => 'Cách dùng much, many, any, a lot of, lots of,…', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 27, 'level_id' => 3, 'name' => 'Cách dùng other, others, another', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 28, 'level_id' => 3, 'name' => 'Câu với enough', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 29, 'level_id' => 3, 'name' => 'Lối nói bao hàm', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 30, 'level_id' => 3, 'name' => 'Câu hỏi đuôi', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 31, 'level_id' => 3, 'name' => 'Thì hiện tại hoàn thành', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 32, 'level_id' => 3, 'name' => 'Thì quá khứ hoàn thành', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 33, 'level_id' => 3, 'name' => 'Thì tương lai hoàn thành', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 34, 'level_id' => 4, 'name' => 'Câu mệnh lệnh', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 35, 'level_id' => 4, 'name' => 'Câu giả định', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 36, 'level_id' => 4, 'name' => 'Mệnh đề nhượng bộ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 37, 'level_id' => 4, 'name' => 'Mệnh đề quan hệ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 38, 'level_id' => 4, 'name' => 'Câu trực tiếp, gián tiếp', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 39, 'level_id' => 4, 'name' => 'Câu chủ động, bị động', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 40, 'level_id' => 4, 'name' => 'Câu điều kiện', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 41, 'level_id' => 4, 'name' => 'Thì hiện tại hoàn thành tiếp diễn', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 42, 'level_id' => 4, 'name' => 'Thì tương lai hoàn thành tiếp diễn', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 43, 'level_id' => 4, 'name' => 'Thì quá khứ hoàn thành tiếp diễn', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 44, 'level_id' => 5, 'name' => 'Các dạng đảo ngữ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 45, 'level_id' => 5, 'name' => 'Thành ngữ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 46, 'level_id' => 5, 'name' => 'Collocation thông dụng', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 47, 'level_id' => 5, 'name' => 'Phrasal verbs', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 48, 'level_id' => 5, 'name' => 'Confusing words', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 49, 'level_id' => -1, 'name' => 'Lối nói phụ hoạ', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        Topics::create(['id' => 50, 'level_id' => -1, 'name' => 'Sự phù hợp về thị giữa 2 vế của một câu', 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
    }
}
