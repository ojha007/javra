<?php

namespace App\Abstracts\Contracts;

interface RepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function getWith(...$relation);

    public function getNext(int $id);

    public function getPrevious(int $id);

    public function find(int $id);
}
