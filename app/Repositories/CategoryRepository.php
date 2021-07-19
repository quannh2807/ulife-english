<?php


namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends AppRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
