<?php
include_once "controllers/indexController.php";
include_once "controllers/profileController.php";


class Router{
    private $request;
    private $site = "/magebit/";

    public function __construct($rqst){
        $this->request = $rqst;
    }

    public function url(){
        switch($this->request){

            case $this->site:
            $index = new indexController();
            $index->index();
            break;

            case $this->site."signup":
            $index = new indexController();
            $index->signup();
            break;

            case $this->site."login":
            $index = new indexController();
            $index->login();
            break;

            case $this->site."profile":
            $profile = new profileController();
            $profile->profile();
            break;

            case $this->site."profile/logout":
            $profile = new profileController();
            $profile->logout();
            break;

            case $this->site."profile/add":
            $profile = new profileController();
            $profile->addAttribute();
            break;

            case $this->site."profile/delete/attribute":
            $profile = new profileController();
            $profile->deleteAttribute();
            break;

            case $this->site."profile/attribute/edit":
            $profile = new profileController();
            $profile->editAttribute();
            break;

            default:

            break;
        }
    }

}