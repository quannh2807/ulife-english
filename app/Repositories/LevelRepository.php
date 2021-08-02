<?php


namespace App\Repositories;

use App\Models\Levels;

class LevelRepository extends AppRepository
{
    protected $model;

    public function __construct(Levels $model)
    {
        parent::__construct($model);
    }
}
