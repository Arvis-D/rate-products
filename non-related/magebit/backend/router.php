<?php


use controllers\Index as index;
use controllers\Profile as profile;

class Router
{
    private $request;
    private $site = "/magebit/";

    public function __construct($rqst)
    {
        $this->request = $rqst;
    }

    public function url(){
        switch($this->request){

            case $this->site:
            $index = new index();
            $index->index();
            break;

            case $this->site."signup":
            $index = new index();
            $index->signup();
            break;

            case $this->site."login":
            $index = new index();
            $index->login();
            break;

            case $this->site."profile":
            $profile = new profile();
            $profile->profile();
            break;

            case $this->site."profile/logout":
            $profile = new profile();
            $profile->logout();
            break;

            case $this->site."profile/add":
            $profile = new profile();
            $profile->addAttribute();
            break;

            case $this->site."profile/delete/attribute":
            $profile = new profile();
            $profile->deleteAttribute();
            break;

            case $this->site."profile/attribute/edit":
            $profile = new profile();
            $profile->editAttribute();
            break;

            default:
                header("Location: 404.html");
            break;
        }
    }

}