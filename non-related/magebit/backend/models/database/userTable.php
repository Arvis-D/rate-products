<?php

namespace models\database;

use \PDO;
class userTable extends Database{


    public function getAllUsers(){
        $sth = $this->connect()->prepare(

            "SELECT *  
             FROM users"

        );
        $result = $sth->execute();
        $this->disconnect($sth);
        return $result;
    }


    public function createTable(){
        $sth = $this->connect()->prepare(

            "CREATE TABLE users(
            id int PRIMARY KEY AUTO_INCREMENT,
            username varchar(1000),
            pwd varchar(1000),
            email varchar(1000)
        )"

        );
        $sth->execute();
        $this->disconnect($sth);
    }

    public function insertSomething(){
        $sth = $this->connect()->prepare(

            "INSERT 
             INTO attributes 
             VALUES('4','2','asdasdasd','asdasdas')");

        $sth->execute();
        $this->disconnect($sth);
    }

    public function createUser($username, $email, $password){
        $sth = $this->connect()->prepare(

            "INSERT 
             INTO users (username, pwd, email) 
             VALUES(:username, :pwd, :email)"

        );
        $sth->execute(["username" => $username, "pwd" => $password, "email" => $email]);
        $this->disconnect($sth);
    }

    public function selectCountByEmail($email){
        $sth = $this->connect()->prepare(

            "SELECT COUNT(*) FROM users WHERE email = :email "

        );
        $sth->execute(["email" => $email]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect($sth);
        return $result[0]["COUNT(*)"];
    }

    public function selectPasswordByEmail($email){
        $sth = $this->connect()->prepare(

            "SELECT pwd FROM users WHERE email = :email;"

        );
        $sth->execute(["email" => $email]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect($sth);
        return $result[0]["pwd"];
    }


    public function selectNameIdByEmail($email){
        $sth = $this->connect()->prepare(

            "SELECT username, id FROM users WHERE email = :email"

        );
        $sth->execute(["email" => $email]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect($sth);
        return $result;
    }
}