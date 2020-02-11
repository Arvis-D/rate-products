<?php

include_once "DB.php";

class userTable extends Database{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }


    public function getAllUsers(){
        $sth = $this->database->connect()->prepare(

            "SELECT *  
             FROM users"

        );
        $result = $sth->execute();
        $this->database->disconnect($sth);
        return $result;
    }


    public function createTable(){
        $sth = $this->database->connect()->prepare(

            "CREATE TABLE users(
            id int PRIMARY KEY AUTO_INCREMENT,
            username varchar(1000),
            pwd varchar(256),
            email varchar(1000)
        )"

        );
        $sth->execute();
        $this->database->disconnect($sth);
    }

    public function insertSomething(){
        $sth = $this->database->connect()->prepare(

            "INSERT 
             INTO attributes 
             VALUES('4','2','asdasdasd','asdasdas')");

        $sth->execute();
        $this->database->disconnect($sth);
    }

    public function createUser($username, $email, $password){
        $sth = $this->database->connect()->prepare(

            "INSERT 
             INTO users (username, pwd, email) 
             VALUES(:username, :pwd, :email)"

        );
        $sth->execute(["username" => $username, "pwd" => $password, "email" => $email]);
        $this->database->disconnect($sth);
    }

    public function selectCountByEmail($email){
        $sth = $this->database->connect()->prepare(

            "SELECT COUNT(*) FROM users WHERE email = :email "

        );
        $sth->execute(["email" => $email]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($sth);
        return $result[0]["COUNT(*)"];
    }

    public function selectCountByEmailAndPassword($email, $password){
        $sth = $this->database->connect()->prepare(

            "SELECT COUNT(*) FROM users WHERE email = :email && pwd = :pwd"

        );
        $sth->execute(["email" => $email, "pwd" => $password]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($sth);
        return $result[0]["COUNT(*)"];
    }


    public function selectNameIdByEmail($email){
        $sth = $this->database->connect()->prepare(

            "SELECT username, id FROM users WHERE email = :email"

        );
        $sth->execute(["email" => $email]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($sth);
        return $result;
    }
}