<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'ytb_id', 'cate_id', 'title', 'description', 'ytb_thumbnails', 'custom_thumbnails', 'publish_at', 'tags', 'author', 'channel_id', 'channel_title', 'status', 'created_by', 'updated_by'
    ];
}
