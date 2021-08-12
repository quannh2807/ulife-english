<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'lessons';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'level_id',
        'course_id',
        'thumb_img',
        'video_ids',
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
        'description' => '',
        'level_id' => 0,
        'course_id' => 0,
        'thumb_img' => '',
        'video_ids' => '',
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];

    /**
     * @return BelongsToMany
     */
    public function hasVideos()
    {
        return $this->belongsToMany(Video::class, 'lesson_video', 'lesson_id', 'video_id');
    }

    public function hasLevel()
    {
        return $this->belongsTo(Levels::class, 'level_id', 'id');
    }

    public function hasCourse()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
