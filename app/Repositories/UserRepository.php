<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends AppRepository
{
    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
