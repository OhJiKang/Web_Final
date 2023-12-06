<?php 
    class Manager {
        public $ManagerID;
        public $FullName;
     
        public $Email;
        public $Phone;
        public $account_id;
        public $password;
      public  function __construct( $FullName, $Email, $Phone, $account_id,$managerID=null )  {
            $this->FullName = $FullName;
          
            $this->Email = $Email;
            $this->Phone = $Phone;
            $this->account_id = $account_id;
            if($managerID!=null){
            $this->ManagerID = $managerID;

            }
        }
        function getPassword() {
            return $this->password;
        }
        function setPassword( $password ) {
            $this -> password = $password;
        }
        function get_ManagerID() {
            return $this->ManagerID;
        }
        function get_FullName() {
            return $this->FullName;
        }
       
        function get_Email() {
            return $this->Email;
        }
        function get_Phone() {
            return $this->Phone;
        }
        function get_AccountId() {
            return $this->account_id;
        }

        function set_ManagerID($ManagerID) {
            $this->ManagerID = $ManagerID;
       }
       function set_FullName($FullName) {
            $this->FullName = $FullName;
       }
     
       function set_Email($Email) {
            $this->Email = $Email;
       }
       function set_Phone($Phone) {
            $this->Phone = $Phone;
       }
       function set_AccountId($account_id) {
        $this->account_id = $account_id;
        }
    }

?>