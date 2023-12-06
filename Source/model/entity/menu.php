<?php
    class Menu {
        public $ItemID;
        public $Name;
        public $Price;
        public $ImageURL;
        public $status;
        function __construct($Name, $ImageURL, $Price,$status ,$ItemID = null) {
            $this->Name = $Name;
            $this->Price = $Price;
            $this->ImageURL = $ImageURL;
            $this->status = $status;
            if($ItemID!=null){
                $this->ItemID = $ItemID;
            }
        }
        function getStatus() { return $this->status;}
        function setStatus($status) { 
            $this->status = $status;
        }
        function get_ItemID() {
            return $this->ItemID;
        }
        function get_Name() {
            return $this->Name;
        }
        function get_Price() {
            return $this->Price;
        }
        function get_ImageURL() {
            return $this->ImageURL;
        }
    
        function set_ItemID($ItemID) {
            $this->ItemID = $ItemID;
       }
       function set_Name($Name) {
            $this->Name = $Name;
       }
       function set_Price($Price) {
            $this->Price = $Price;
       }
       function set_ImageURL($ImageURL) {
        $this->ImageURL = $ImageURL;
        }
    }
?>