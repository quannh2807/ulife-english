<?php
/**
 * Class CourseRepository
 * Created by nguyendx.
 * Date: 8/31/21
 */

namespace App\Repositories;


use App\Models\Course;

class CourseRepository extends AppRepository
{
    protected $model;

    public function __construct(Course $model)
    {
        parent::__construct($model);
    }
}
