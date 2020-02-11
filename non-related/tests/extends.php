<?php 

class asd{
    public $name;

    public function setName($name){
        $this->name = $name;
    }
}



class child extends asd{
    private $hours;
}


$a = new child;

$a->setName("asdasdasd");
echo $a->name;