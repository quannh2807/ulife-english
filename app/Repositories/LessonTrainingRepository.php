<?php


namespace App\Repositories;

use App\Models\LessonTraining;

class LessonTrainingRepository extends AppRepository
{
    protected $model;

    public function __construct(LessonTraining $model)
    {
        parent::__construct($model);
    }
}
