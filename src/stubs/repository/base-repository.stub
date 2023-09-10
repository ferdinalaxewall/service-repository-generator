<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class BaseRepository
{
    protected $model; 

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function findAll(string $sortColumn = 'created_at', string $sortBy = 'DESC')
    {
        return $this->model->orderBy($sortColumn, $sortBy)->get();
    }

    public function findOneById(int $id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function findOneByUUID(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function create(Collection|array $dto)
    {
        return $this->model->create($dto);
    }

    public function updateById(int $id, Collection|array $dto)
    {
        return $this->model->where('id', $id)->update($dto);
    }
    
    public function updateByUUID(string $uuid, Collection|array $dto)
    {
        return $this->model->where('uuid', $uuid)->update($dto);
    }

    public function deleteById(int $id)
    {
        $this->model->where('id', $id)->delete();
    }
    
    public function deleteByUUID(string $uuid)
    {
        $this->model->where('uuid', $uuid)->delete();
    }
}