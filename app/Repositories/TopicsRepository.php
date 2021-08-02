<?php


namespace App\Repositories;

use App\Models\Topics;

class TopicsRepository extends AppRepository
{
    protected $model;

    public function __construct(Topics $model)
    {
        parent::__construct($model);
    }
}
