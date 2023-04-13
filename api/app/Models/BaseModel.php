<?php

namespace App\Models;

use Config\QueryBuilder;

abstract class BaseModel
{
    protected $table;
    protected $qb;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->qb = new QueryBuilder($table);
    }

    public function getAll()
    {
        return $this->qb->get();
    }

    public function getById(int $id)
    {
        $query = $this->qb->where('id', '=', $id);
        return $query->get();
    }

    public function save(array $data)
    {
        $lastId = $this->qb->insert($data);
        return $lastId;
    }

    public function update(int $id, array $data)
    {
        $response = $this->qb->update($id, $data);
        return $response;
    }

    public function delete(int $id)
    {
        $id = $this->qb->delete($id);
        return $id;
    }
}
