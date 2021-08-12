<?php


namespace App\Repositories;

use App\Models\Exercises;

class ExercisesRepository extends AppRepository
{
    protected $model;

    public function __construct(Exercises $model)
    {
        parent::__construct($model);
    }
}
