<?php
class StatusOfTicket {
    public $id;
    public $name;
    public function __construct($name, $id = null) {
        $this->name = $name;
        if($id!=null){
            $this->id = $id;
        }
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function setId($id){
        $this->id = $id;
    }
}
?>