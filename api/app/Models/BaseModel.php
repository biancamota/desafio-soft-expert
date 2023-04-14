<?php

namespace App\Models;

use Config\QueryBuilder;
use Exception;

abstract class BaseModel
{
    protected $table;
    protected $qb;

    public function __construct()
    {
        $this->qb = new QueryBuilder();
        $this->qb->setTable($this->table);
    }

    public function getAll()
    {
        return $this->qb->get();
    }

    public function getById(int $id)
    {
        return $this->qb->where('id', '=', $id)->first();
    }

    public function save(array $data)
    {
        return $this->qb->insert($data);
    }

    public function update(int $id, array $data)
    {
        return $this->qb->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->qb->delete($id);
    }

    public function beginTransaction()
    {
        $this->qb->beginTransaction();
    }

    public function commit()
    {
        $this->qb->commit();
    }

    public function rollback()
    {
        $this->qb->rollBack();
    }
}
