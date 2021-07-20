<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class AppRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * AppRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $relations
     * @param array|string[] $columns
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $relations, array $columns = ['*'])
    {
        $result = $this->model;

        if ($relations !== "" && $relations !== null) {
            $result = $result->with($relations);
        }

        return $result->get($columns);
    }

    /**
     * @param int $id
     * @param array $relations
     * @param array|string[] $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function findById(int $id, array $relations, array $columns = ['*'])
    {
        $result = $this->model;

        if ($relations !== "" && $relations !== null) {
            $result = $result->with($relations);
        }

        return $result->findOrFail($id, $columns);
    }

    /**
     * @param $param
     * @param $limit
     */
    public function fetchData($param, $limit)
    {
        $result = $this->model;

        if (isset($param['orderBy'])) {
            $result = $result->orderBy($param['orderBy']);
        }

        $result->paginate($limit);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function storeNew($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function delete($data)
    {
        return $this->model->whereIn('id', $data)->delete();
    }

    /**
     * @param string $param
     * @param int $value
     * @return mixed
     */
    public function checkRecordExisted(string $param, int $value)
    {
        return $this->model->where($param, $value)->exists();
    }
}
