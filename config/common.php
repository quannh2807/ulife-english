<?php

return [
    'item_per_page' => 12,
    'page_default' => 1,
    'status' => [
        'Kích hoạt' => 1,
        'Không kích hoạt' => 0,
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
    'video_types' => [
        'Grammar' => 1,
        'Lesson' => 2,
    ],
    'subtitle_status' => [
        'pending' => 0, // chờ duyệt
        'resolve' => 1, // đã duyệt
        'reject' => 2, // không được duyệt
    ],
    'languages' => [
        'en' => 'Tiếng Anh',
        'vi' => 'Tiếng Việt',
    ],
    'lesson_training_types' => [
        'writing' => 1,
        'speaking' => 2,
    ]
];
