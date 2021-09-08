<?php


namespace App\Repositories;

use App\Models\VocabularyCat;

class VocabularyCatRepository extends AppRepository
{
    protected $model;

    public function __construct(VocabularyCat $model)
    {
        parent::__construct($model);
    }
}
