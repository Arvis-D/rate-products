<?php

include_once __DIR__ . "/../views/view.php";
include_once __DIR__ . "/../models/userModel.php";


class indexController{
    private $index;
    private $userModel;

    public function __construct(){
        $this->index = new View("index");
        $this->userModel = new userModel();
    }
    public function index(){
        if(isset($_SESSION["username"]))header("Location: /magebit/profile");
        else $this->index->render();
    }

    public function signup(){
        if($this->userModel->signup($_POST["username"], $_POST["email"], $_POST["password"])){
            $_SESSION["email"] = $_POST["email"];
            header("Location: /magebit/profile");
        }
        else {
            $_SESSION["email_exists"] = "User with such email address already exists";
            header("Location: /magebit/");
        }
    }

    public function login(){
        if($this->userModel->login($_POST["email"], $_POST["password"])){
            session_destroy();
            session_start();
            $_SESSION["email"] = $_POST["email"];
            header("Location: /magebit/profile");
        }
        else {
            $_SESSION["login_error"] = "Incorrect email or password";
            header("Location: /magebit/");
        }
    }
}