<?php
    class MenuDetail {
        public $Number;
        public $Total;
        public $ItemID;
        public $BookingID;

        function __construct($Number, $Total, $BookingID, $ItemID) {
            $this->Number = $Number;
            $this->Total = $Total;
            $this->ItemID = $ItemID;
            $this->BookingID = $BookingID;
        }
        function get_Number() {
            return $this->Number;
        }
        function get_Total() {
            return $this->Total;
        }
        function get_ItemID() {
            return $this->ItemID;
        }
        function get_BookingID() {
            return $this->BookingID;
        }

        function set_Number($Number) {
            $this->Number = $Number;
       }
       function set_Total($Total) {
            $this->Total = $Total;
       }
       function set_ItemID($ItemID) {
            $this->ItemID = $ItemID;
       }
       function set_BookingID($BookingID) {
            $this->BookingID = $BookingID;
       }
    }
?>