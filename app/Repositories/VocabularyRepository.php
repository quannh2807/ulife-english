<?php


namespace App\Repositories;

use App\Models\Vocabulary;

class VocabularyRepository extends AppRepository
{
    protected $model;

    public function __construct(Vocabulary $model)
    {
        parent::__construct($model);
    }
}
