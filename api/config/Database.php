<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $driver;
    private $port;

    public function __construct()
    {
        $this->host = Enviroment::getEnv('DB_HOST');
        $this->dbname = Enviroment::getEnv('DB_DATABASE');
        $this->username = Enviroment::getEnv('DB_USERNAME');
        $this->password = Enviroment::getEnv('DB_PASSWORD');
        $this->driver = Enviroment::getEnv('DB_DRIVER');
        $this->port = Enviroment::getEnv('DB_PORT');
    }

    public function connect(): PDO
    {
        try {
            $dsn = $this->driver . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname . ';';
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            exit("Erro de conexão: " . $e->getMessage());
        }
    }
}
