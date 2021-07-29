<?php


namespace App\Repositories;


use App\Models\VideoSubtitle;

class VideoSubtitleRepository extends AppRepository
{
    protected $model;

    public function __construct(VideoSubtitle $model)
    {
        parent::__construct($model);
    }
}
