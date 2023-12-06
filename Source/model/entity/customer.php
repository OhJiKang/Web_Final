<?php
require_once 'ActorOfMovie.php';
    class Customer {
        public $CustomerID;
        public $FullName;
        public $Address;
        public $Email;
        public $Phone;
        public $account_id;
        public $password;
        
       
        function __construct($FullName, $Email, $Address, $Phone, $account_id, $customerID=null) {
            $this->FullName = $FullName;
            $this->Address = $Address;
            $this->Email = $Email;
            $this->Phone = $Phone;
            $this->account_id = $account_id;
            if($customerID!=null){
                $this->CustomerID =$customerID;
            }
        }
        function getPassword() {
            return $this->password;
        }
        function setPassword( $password ) {
            $this -> password = $password;
        }
        function get_CustomerID() {
            return $this->CustomerID;
        }
        function get_FullName() {
            return $this->FullName;
        }
        function get_Address() {
            return $this->Address;
        }
        function get_Email() {
            return $this->Email;
        }
        function get_Phone() {
            return $this->Phone;
        }
   

        function set_CustomerID($CustomerID) {
             $this->CustomerID = $CustomerID;
        }
        function set_FullName($FullName) {
             $this->FullName = $FullName;
        }
        function set_Address($Address) {
             $this->Address = $Address;
        }
        function set_Email($Email) {
             $this->Email = $Email;
        }
        function set_Phone($Phone) {
             $this->Phone = $Phone;
        }
      function get_Account_Id() {
        return $this->account_id;
      }
      function set_Account_Id($account_id) {
        $this->account_id = $account_id;
      }
    }
?>