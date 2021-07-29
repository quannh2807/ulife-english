<?php


namespace App\Repositories;


use App\Models\Language;

class LanguageRepository extends AppRepository
{
    protected $model;

    public function __construct(Language $model)
    {
        parent::__construct($model);
    }
}
