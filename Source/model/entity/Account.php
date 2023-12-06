<?php
class Account{
    public $id;
    public $email;
    public $password;
    public $role_id;
    public function __construct( $email, $password, $role_id=null,$id=null) {
        $this->email = $email;
        $this->password = $password;
        if($id!=null){
        $this->id = $id;}
      
        if($role_id!=null){
        $this->role_id = $role_id;
        }
    }
    public function getId(){
        return $this->id;
    }
    public function getEmail(){
        return $this->email;

    }
function getPassword(){
    return $this->password;
}
    public function getRole(){
        return $this->role_id;
    }
    public function setID($id){
        $this->id = $id;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setRole($role){
        $this->role_id = $role;
    }
}
?>