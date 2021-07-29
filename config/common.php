<?php

return [
    'item_per_page' => 12,
    'page_default' => 1,
    'status' => [
        'Không kích hoạt' => 0,
        'Kích hoạt' => 1,
    ],
    'paginate_size' => [
        'list' => [
            20,
            50,
            80,
            100,
        ],
        'default' => 20,
    ],
    'question_type' => [
        'Chọn một đáp án' => 1,
        'Sắp xếp' => 2,
        'Điền vào chỗ trống' => 2,
    ],
    'question_level' => [
        'Dễ' => 1,
        'Trung bình' => 2,
        'Khó' => 3,
        'Rất khó' => 4,
    ],
    'video_status' => [
        'hidden' => 0,
        'show' => 1,
    ],
    'subtitle_status' => [
        'pending' => 0, // chờ duyệt
        'resolve' => 1, // đã duyệt
        'reject' => 2, // không được duyệt
    ],
];
