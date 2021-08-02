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
        'name',
        'description',
        'status',
        'level_id',
        'course_id',
        'thumb_img',
        'created_by',
        'updated_by',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
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
