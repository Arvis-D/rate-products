<?php

/**
 * Deals with sessions, views and data recieved from model
 */




include_once __DIR__ . "/../views/view.php";
include_once __DIR__ . "/../models/userModel.php";


class profileController{
    private $profile;
    private $userModel;

    public function __construct(){
        $this->profile = new View("profile");
        $this->userModel = new userModel();
    }
    public function profile(){
           $data = $this->userModel->getUserData($_SESSION["email"]);

            $attributes = [];
            foreach($data["attributes"] as $attribute){
                $view = new View("subviews/attribute");
                $view->set($attribute);
                array_push($attributes, $view);
            }

           $_SESSION["id"] = $data["user"]["id"];
           $this->profile->render($data, $attributes);
    }

    public function logout(){
        session_destroy();
        header("Location: /magebit/");
    }

    public function addAttribute(){
        $this->userModel->addAttribute($_SESSION["id"], $_POST["attribute_name"], $_POST["attribute_value"]);
        header("Location: /magebit/profile");
    }

    public function deleteAttribute(){
        if(isset($_SESSION["email"]))$this->userModel->deleteAttribute($_POST["attribute_id"]);
        header("Location: /magebit/profile");
    }

    public function editAttribute(){
        if(isset($_SESSION["email"]))$this->userModel->editAttribute($_POST["attribute_id"], $_POST["attribute_name"], $_POST["attribute_value"]);
        header("Location: /magebit/profile");
    }

}