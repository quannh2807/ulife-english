<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class AppRepository implements RepositoryInterface
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
     * @param array|string[] $columns
     * @param int $offset
     * @return mixed
     */
    public function fetchList(array $columns = ['*'], int $offset = 0): Collection
    {
        $perPage = config('common.item_per_page');

        return $this->model
            ->skip($offset)
            ->limit($perPage)
            ->get($columns);
    }

    /**
     * @param int|null $page
     * @param array|string[] $columns
     * @param string $orderBy
     * @param string $orderDes
     * @return mixed
     */
    public function paginateList(int $page = null, array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc'): Collection
    {
        $perPage = config('common.item_per_page');

        return $this->model
            ->orderBy('updated_at', $orderDes)
            ->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param int $id
     * @param array|string[] $columns
     * @return mixed
     */
    public function findById(int $id, array $columns = ['*'])
    {
        return $this->model
            ->find($id, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->model
            ->where('id', $id)
            ->update($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->delete();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function delete(array $data)
    {
        return $this->model
            ->whereIn('id', $data)
            ->delete();
    }

    /**
     * @param array|string[] $columns
     * @return mixed
     */
    public function fetchAll(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param array $ids
     * @param array|string[] $columns
     * @param string $orderBy
     * @param string $orderDes
     * @return mixed
     */
    public function getListByIds(array $ids, array $columns = ['*'], string $orderBy = 'id', string $orderDes = 'ASC')
    {
        return $this->model->whereIn('id', $ids)
            ->orderBy($orderBy, $orderDes)
            ->get($columns);
    }
}
