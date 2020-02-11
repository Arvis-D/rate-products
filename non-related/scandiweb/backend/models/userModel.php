<?php
include_once "database/userTable.php";
include_once "database/attributesTable.php";


class userModel{
    private $attributesTable;
    private $userTable;


    public function __construct(){
        $this->attributesTable = new attributesTable();
        $this->userTable = new userTable();

    }
    public function signup($name, $email, $password){
        if($this->userTable->selectCountByEmail($email) > 0){
            return false;
        }
        else{
            $this->userTable->createUser($name, $email, $password);
            return true;
        }
    }
    public function login($email, $password){
        if($this->userTable->selectCountByEmailAndPassword($email, $password) == 1){
            return true;
        }
        else return false;
    }
    public function getUserData($email){
        $user = $this->userTable->selectNameIdByEmail($email);
        $user_id = $user[0]["id"];

        $attributes = $this->attributesTable->selectAttributesByUserId($user_id);

        $data["attributes"] = $attributes;
        $data["user"] = $user[0];
        return $data;
    }
    public function addAttribute($uid, $attrName, $attrValue){
        $this->attributesTable->insertAttribute($uid, $attrName, $attrValue);
    }

    public function deleteAttribute($id){
        $this->attributesTable->deleteAttributeById($id);
    }

    public function editAttribute($id, $attrName, $attrContent){
        $this->attributesTable->updateAttributeById($id, $attrName, $attrContent);
    }

}