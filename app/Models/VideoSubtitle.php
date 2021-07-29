<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSubtitle extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'video_subtitles';

    /**
     * @var string[]
     */
    protected $fillable = [
        'video_id',
        'time_start',
        'time_end',
        'vi',
        'en',
        'ko',
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
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];

    public function hasLanguage () {
        return $this->belongsTo(Language::class, 'lang_id', 'id');
    }
}
