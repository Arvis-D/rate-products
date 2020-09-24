<?php

namespace App\Helper\MySql;

use \PDO;

class Database
{
    private string $host;
    private string $name ;
    private string $username;
    private string $password;
    public PDO $pdo;
    private $queries = 0;

    public function __construct($host, $name, $username, $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->pdo = $this->createPDO();
    }

    private function createPDO(): ?PDO
    {
        try {
            $this->conn = new PDO(
                "mysql:host=".$this->host.
                ";dbname=".$this->name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }
        catch(\PDOException $e){
            echo "Connection failed: " . $e->getMessage();
            $this->conn = null;
        }
        return $this->conn;
    }

    public function write(QueryInterface $query): void
    {
        $this->queries++;
        $stmt = $this->pdo->prepare($query->getQuery());
        $stmt->execute($query->getParams());
    }

    public function read(QueryInterface $query): array
    {
        $this->queries++;
        $stmt = $this->pdo->prepare($query->getQuery());
        $stmt->execute($query->getParams());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __destruct()
    {
        
    }
}