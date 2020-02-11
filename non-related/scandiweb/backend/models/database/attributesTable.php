<?php

include_once "DB.php";

class attributesTable extends Database{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }


    public function createTable(){
        $sth = $this->database->connect()->prepare(

            "CREATE 
             TABLE attributes(
                id int PRIMARY KEY AUTO_INCREMENT,
                user_id int,
                attribute_name varchar(256),
                attribute_content varchar(1000)
            )"

        );
        $sth->execute();
        $this->database->disconnect($sth);
    }


    public function insertAttribute($userId, $attributeName, $attributeValue){
        $sth = $this->database->connect()->prepare(
            "INSERT
             INTO attributes (user_id, attribute_name, attribute_content)
             VALUES(:uid, :attrName, :attrValue)"
        );
        $sth->execute(["uid" => $userId, "attrName" => $attributeName, "attrValue" => $attributeValue]);
        $this->database->disconnect($sth);
    }

    public function selectAttributesByUserId($id){
        $sth = $this->database->connect()->prepare(

            "SELECT * FROM attributes WHERE user_id = :id"

        );
        $sth->execute(["id" => $id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($sth);
        return $result;
    }

    public function deleteAttributeById($id){
        $sth = $this->database->connect()->prepare(

            "DELETE FROM attributes WHERE id = :id"

        );
        $sth->execute(["id" => $id]);
        $this->database->disconnect($sth);
    }

    public function updateAttributeById($id, $attributeName, $attributeValue){
        $sth = $this->database->connect()->prepare(

            "UPDATE attributes SET attribute_name = :attrname , attribute_content = :attrcontent WHERE id = :id"

        );
        $sth->execute(["id" => $id, "attrname" => $attributeName, "attrcontent" => $attributeValue]);
        $this->database->disconnect($sth);
    }
}