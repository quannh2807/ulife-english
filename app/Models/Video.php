<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'videos';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id', 'ytb_id', 'topic_id', 'cate_id', 'title', 'description', 'ytb_thumbnails', 'custom_thumbnails', 'publish_at', 'tags', 'author', 'channel_id', 'channel_title', 'type', 'position', 'status', 'created_by', 'updated_by'
    ];

    protected $attributes = [
        'position' => 0,
        'status' => 0,
        'created_by' => 0,
        'updated_by' => 0,
    ];

    /**
     * @return BelongsTo
     */
    public function hasCategories()
    {
        return $this->belongsToMany(Category::class, 'video_category', 'video_id', 'category_id');
    }

    public function hasVideoSub()
    {
        return $this->hasMany(VideoSubtitle::class, 'video_id', 'id');
    }

    public function hasTopic()
    {
        return $this->belongsTo(Topics::class, 'topic_id', 'id');
    }
}
