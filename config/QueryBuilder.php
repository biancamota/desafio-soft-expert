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

    public function __construct(string $table = null)
    {
        $this->connection = (new Database())->connect();
        $this->table = $table;
    }

    public function select($fields = '*'): self
    {
        $this->select = is_array($fields) ? implode(',', $fields) : $fields;
        return $this;
    }

    public function where(string $field, string $operator, string $value): self
    {
        $this->where[] = "$field $operator $value";

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
        $this->limit = "$field $order";
        return $this;
    }

    private function buildQuery(): string
    {
        $query = "SELECT {$this->select} FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $query .= ' ' . implode(' ', $this->joins);
        }
        
        if (!empty($this->where)) {
            $query .= ' WHERE ' . implode(' AND ', $this->where);
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
       return $this->execute($this->buildQuery())->fetchAll(PDO::FETCH_ASSOC);
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
}