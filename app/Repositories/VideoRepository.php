<?php


namespace App\Repositories;

use App\Models\Video;

class VideoRepository extends AppRepository
{
    protected $model;

    public function __construct(Video $model)
    {
        parent::__construct($model);
    }
}
