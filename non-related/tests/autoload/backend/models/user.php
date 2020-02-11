<?php

namespace models;
use models\database\table as table;

class user extends table{
    private $table;

    function __construct(){
        $this->table = new table;
        $this->table->connect();
        echo get_class($this). "<br>" . $this->table->tablename;
    }

    public $success = "YESS";
}