<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = [
        'id',
        'name',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'answer_correct',
        'status',
        'video_id',
        'start_time',
        'end_time',
        'level_id',
        'level_type',
        'topics_id',
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
        'status' => 1,
        'video_id' => 0,
        'start_time' => '',
        'end_time' => '',
        'level_id' => 0,
        'level_type' => 0,
        'topics_id' => 0,
        'created_by' => 1,
        'updated_by' => 1,
    ];

    public function getVideo()
    {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }

    public function getLevel()
    {
        return $this->belongsTo(Levels::class, 'level_id', 'id');
    }

    public function getTopics()
    {
        return $this->belongsTo(Topics::class, 'topics_id', 'id');
    }

}
