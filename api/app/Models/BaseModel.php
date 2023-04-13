<?php

namespace App\Models;

use Config\QueryBuilder;
use Exception;

abstract class BaseModel
{
    protected $table;
    protected $qb;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->qb = new QueryBuilder($table);
    }

    public function setTable($table)
    {
        $this->table = $table;
        $this->qb->setTable($table);
    }

    public function getAll()
    {
        if(!empty($this->qb->get())) {
            return $this->qb->get();
        }

        throw new Exception("No record found", 404);
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
