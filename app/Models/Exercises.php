<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'exercises';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'answer_correct',
        'thumb',
        'level_id',
        'lesson_id',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'answer_1' => '',
        'answer_2' => '',
        'answer_3' => '',
        'answer_4' => '',
        'answer_correct' => '',
        'thumb' => '',
        'level_id' => 0,
        'lesson_id' => 0,
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];

}
