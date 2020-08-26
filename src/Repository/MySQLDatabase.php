<?php

namespace App\Repository;

use \PDO;

class MySQLDatabase
{
    private string $host;
    private string $name ;
    private string $username;
    private string $password;
    private PDO $pdo;

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

    /**
     * Used if the query returns a result
     *
     * @param string $queryStr
     * @param array $queryParams
     * @return array $result
     */

    public function query($queryStr, $queryParams = []): array
    {
        $stmt = $this->pdo->prepare($queryStr);
        $stmt->execute($queryParams);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function stmt($queryStr, $queryParams = []): void
    {
        $stmt = $this->pdo->prepare($queryStr);
        $stmt->execute($queryParams);
    }
}