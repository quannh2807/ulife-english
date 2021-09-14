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
        'position',
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
        'position' => 0,
        'video_ids' => '',
        'status' => 1,
        'created_by' => 0,
        'updated_by' => 0,
    ];

    /**
     * @return BelongsToMany
     */

    public function hasLevel()
    {
        return $this->belongsTo(Levels::class, 'level_id', 'id');
    }

    public function hasCourse()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function hasCharacters()
    {
        return $this->hasMany(ActOutCharacter::class, 'lesson_id');
    }
}
