<?php

return [
    'item_per_page' => 12,
    'page_default' => 1,
    'import' => [
        'validation' => [
            'name' => [
                'max' => 25,
            ],
            'file' => [
                'header' => [
                    'id' => 'import.header_text.id',
                    'name' => 'import.header_text.name',
                    'created_at' => 'import.header_text.created_at',
                ],
                'type' => ['csv','tsv','xls','xlsx'],
                'max' => 8192,
            ],
        ],
    ],
    'status' => [
        'inactive' => 1,
        'active' => 2,
    ],
    'role' => [
        'student' => 1,
    ],
    'nhom_do_an' => [
        'trang_thai_hien_thi' => [
            'public' => 2,
            'private' => 1,
        ],
        'sinh_vien' => [
            'so_thanh_vien_max' => 7,
            'paginate' => 10,
        ],
        'giang_vien' => [
            'so_nhom_max' => 7,
        ],
    ],
    'du_an_2' => [
        'dot_dang_ki' => [
            'trang_thai' => [
                'inactive' => 1,
                'active' => 2,
            ],
        ],
        'date_format' => 'Y-m-d',
        'datetime_format' => 'Y-m-d H:i:s',
    ],
    'staff' => [
        'role' => [
            'cnbm' => 2,
            'pdt' => 3,
        ],
        'mimetypes' => [
            'application/vnd.ms-excel',
            'application/octet-stream',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
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
];
