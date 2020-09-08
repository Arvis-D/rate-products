<?php

namespace App\Repository;

use Doctrine\Migrations\Query\Query;
use \PDO;

class MySQLDatabase
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

    public function sql(string $sqlStr, array $params = null): void
    {
        $this->queries++;
        $stmt = $this->pdo->prepare($sqlStr);
        $stmt->execute($params);
    }

    public function sqlFetch(string $sqlStr, array $params = null): array
    {
        $this->queries++;
        $stmt = $this->pdo->prepare($sqlStr);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __destruct()
    {
        
    }
}