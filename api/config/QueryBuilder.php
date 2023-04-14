<?php

namespace Config;

use PDO;
use PDOException;

class QueryBuilder
{
    protected $table;
    protected $connection;
    protected $select = '*';
    protected $where = [];
    protected $joins = [];
    protected $limit = '';
    protected $query = '';
    protected $orderBy = 'id DESC';
    protected $groupBy = '';
    protected $params = [];

    public function __construct()
    {
        $this->connection = (new Database())->connect();
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($fields = '*'): self
    {
        $this->select = is_array($fields) ? implode(',', $fields) : $fields;
        return $this;
    }

    public function where(string $field, string $operator, string $value): self
    {
        $this->where[] = "$field $operator ?";
        $this->params[] = $value;

        return $this;
    }

    public function join(string $table, string $tableColumn, string $operator, string $mainColumn): self
    {
        $this->joins[] = "JOIN $table ON $tableColumn $operator $mainColumn";
        return $this;
    }

    public function limit(int $limit, int $offset)
    {
        $this->limit = "LIMIT $limit OFFSET $offset";
        return $this;
    }

    public function orderBy(string $field = 'id', string $order = 'DESC')
    {
        $this->orderBy = "$field $order";
        return $this;
    }

    public function groupBy(string $field)
    {
        $this->groupBy = "$field";
        return $this;
    }

    public function first()
    {
        $this->limit(1, 0);

        $result = $this->get();

        return empty($result) ? null : $result[0];
    }

    public function find($id)
    {
        $this->where('id', '=', $id);

        $result = $this->first();

        return empty($result) ? null : $result;
    }

    private function buildQuery($select = null): string
    {
        $select = $select ?: $this->select;

        $query = "SELECT $select FROM {$this->table}";

        if (!empty($this->joins)) {
            $query .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->where)) {
            $query .= ' WHERE ' . implode(' AND ', $this->where);
        }

        if (!empty($this->groupBy)) {
            $query .= ' GROUP BY ' . $this->groupBy;
        }

        if (!empty($this->orderBy)) {
            $query .= ' ORDER BY ' . $this->orderBy;
        }

        if (!empty($this->limit)) {
            $query .= ' ' . $this->limit;
        }

        return $query;
    }

    public function get()
    {
        $query = $this->buildQuery();
        
        $result = $this->execute($query, $this->params)->fetchAll(PDO::FETCH_ASSOC);
        
        $this->params = [];

        return $result;
    }

    public function insert($values)
    {
        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

    public function update($id, $values)
    {
        $fields = array_keys($values);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE id =' . $id;

        $this->execute($query, array_values($values));

        return $id;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ' . $id;

        $this->execute($query);

        return $id;
    }

    public function deleteWhere($where)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;

        $this->execute($query);

        return true;
    }

    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollback()
    {
        $this->connection->rollBack();
    }
}
