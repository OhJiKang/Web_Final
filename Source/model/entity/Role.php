<?php 

 class Role{
    public $id;
    public $name;
    public function __construct($id, $name){
        $this->name = $name;
        $this->id = $id;
    }
    public function getID(){
        return $this->id;
    }
    public function getName(){

        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
}

 ?>