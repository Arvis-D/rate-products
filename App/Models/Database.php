<?php

namespace App\Models;

use \PDO;

class Database
{
    private $host;
    private $name ;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $name, $username, $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    private function connect()
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

    private function disconnect(&$statement = null)
    {
        $statement = null;
        $this->conn = null;
    }

    /**
     * Used if the query returns a result
     *
     * @param string $queryStr
     * @param array $queryParams
     * @return array $result
     */

    public function stmtQuery($queryStr, $queryParams = [])
    {
        $stmt = $this->connect()->prepare($queryStr);
        $stmt->execute($queryParams);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect($stmt);
        return $result;
    }

    public function stmt($queryStr, $queryParams = [])
    {
        $stmt = $this->connect()->prepare($queryStr);
        $stmt->execute($queryParams);
        $this->disconnect($stmt);
    }
}