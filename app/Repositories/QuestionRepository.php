<?php


namespace App\Repositories;

use App\Models\Question;

class QuestionRepository extends AppRepository
{
    protected $model;

    public function __construct(Question $model)
    {
        parent::__construct($model);
    }
}
