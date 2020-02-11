<?php
namespace models\database;


use \PDO;
class Database{
    private $host = "127.0.0.1";
    private $name = "magebit";
    private $username = "root";
    private $password = "";
    private $conn;

    protected function connect(){
        try {
            $this->conn = new PDO(
            
                "mysql:host=".$this->host.";dbname=".$this->name, $this->username, $this->password
        );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
            $this->conn = null;
        }
        return $this->conn;
    }

    protected function disconnect(&$statement = null){
        $statement = null;
        $this->conn = null;
    }

    public function isConnected(){
        return ($this->conn == null ? false : true);
    }

}