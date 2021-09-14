<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTraining extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'lesson_training';

    /**
     * @var string[]
     */
    protected $fillable = [
        'vi',
        'en',
        'type',
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
        'vi' => '',
        'en' => '',
        'type' => 0,
        'lesson_id' => 0,
        'created_by' => 0,
        'updated_by' => 0,
    ];
}
