<?php

namespace models\database;
use \PDO;


class attributesTable extends Database{


    public function createTable(){
        $sth = $this->connect()->prepare(

            "CREATE 
             TABLE attributes(
                id int PRIMARY KEY AUTO_INCREMENT,
                user_id int,
                attribute_name varchar(256),
                attribute_content varchar(1000)
            )"

        );
        $sth->execute();
        $this->disconnect($sth);
    }


    public function insertAttribute($userId, $attributeName, $attributeValue){
        $sth = $this->connect()->prepare(
            "INSERT
             INTO attributes (user_id, attribute_name, attribute_content)
             VALUES(:uid, :attrName, :attrValue)"
        );
        $sth->execute(["uid" => $userId, "attrName" => $attributeName, "attrValue" => $attributeValue]);
        $this->disconnect($sth);
    }

    public function selectAttributesByUserId($id){
        $sth = $this->connect()->prepare(

            "SELECT * FROM attributes WHERE user_id = :id"

        );
        $sth->execute(["id" => $id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect($sth);
        return $result;
    }

    public function deleteAttributeById($id){
        $sth = $this->connect()->prepare(

            "DELETE FROM attributes WHERE id = :id"

        );
        $sth->execute(["id" => $id]);
        disconnect($sth);
    }

    public function updateAttributeById($id, $attributeName, $attributeValue){
        $sth = $this->connect()->prepare(

            "UPDATE attributes SET attribute_name = :attrname , attribute_content = :attrcontent WHERE id = :id"

        );
        $sth->execute(["id" => $id, "attrname" => $attributeName, "attrcontent" => $attributeValue]);
        $this->disconnect($sth);
    }
}