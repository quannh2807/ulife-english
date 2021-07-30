<?php


namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository extends AppRepository
{
    protected $model;

    public function __construct(Lesson $model)
    {
        parent::__construct($model);
    }
}
