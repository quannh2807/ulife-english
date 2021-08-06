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
        'status',
        'created_by',
        'updated_by',
    ];
}
