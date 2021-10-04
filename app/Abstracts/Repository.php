<?php

namespace App\Abstracts;


use App\Abstracts\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{

    /**
     * @var
     */
    protected $model;

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->orderByDesc('id')->get();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes)
    {
        $record = $this->getById($id);
        $record->update($attributes);
        return $record;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getNext(int $id)
    {
        return $this->model
            ->where('id', '>', $id)
            ->orderBy('id', 'ASC')
            ->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getPrevious(int $id)
    {
        return $this->model
            ->where('id', '<', $id)
            ->orderBy('id', 'DESC')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function paginate(int $page)
    {
        return $this->model
            ->orderBy('created_at', 'DESC')
            ->paginate($page);
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->model->getTable();
    }

    /**
     * @param mixed ...$relation
     * @return mixed
     */
    public function getWith(...$relation)
    {
        return $this->model
            ->with($relation)
            ->orderByDesc('id')
            ->get();
    }

    /**
     * @param int $limit
     * @param mixed ...$relation
     * @return mixed
     */
    public function paginateWith(int $limit, ...$relation)
    {
        return $this->model->with($relation)->paginate($limit);
    }

    public function maxId()
    {
        return $this->model->max('id');
    }

    public function getSelectItems($text)
    {
        return $this->model->all()
            ->mapWithKeys(function ($item) use ($text) {
                return [$item->id => $item->$text];
            });
    }

    public function getByIdWith($id, ...$with)
    {
        return $this->model
            ->with($with)
            ->findOrFail($id);
    }
}
