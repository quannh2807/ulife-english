<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @return Model
     */
    public function getModel();

    /**
     * @param array|string[] $columns
     * @param int $offset
     * @return mixed
     */
    public function fetchList(array $columns = ['*'], int $offset = 0);

    /**
     * @param int|null $page
     * @param array|string[] $columns
     * @param string $orderBy
     * @param string $orderDes
     * @return mixed
     */
    public function paginateList(int $page = null, array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc');

    /**
     * @param int $id
     * @param array|string[] $columns
     * @return mixed
     */
    public function findById(int $id, array $columns = ['*']);

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function delete(array $data);

    /**
     * @param array|string[] $columns
     * @return mixed
     */
    public function fetchAll(array $columns = ['*']);

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);

    /**
     * @param array $ids
     * @param array|string[] $columns
     * @param string $orderBy
     * @param string $orderDes
     * @return mixed
     */
    public function getListByIds(array $ids, array $columns = ['*'], string $orderBy = 'id', string $orderDes = 'ASC');
}
