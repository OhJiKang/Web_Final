<?php
    class Showtime {
        public $ShowtimeID;
        public $Price;
        public $MovieID;
        public $StartTime;
        public $EndTime;
        public $RoomID;
        public $FormatID;


        function __construct($Price, $StartTime, $MovieID, $EndTime, $RoomID, $FormatID, $ShowtimeID=null) {
            $this->Price = $Price;
            $this->MovieID = $MovieID;
            $this->StartTime = $StartTime;
            $this->EndTime = $EndTime;
            $this->RoomID = $RoomID;
            $this->FormatID = $FormatID;
            if($ShowtimeID!=null){
                $this->ShowtimeID = $ShowtimeID;
            }
        }
        function get_ShowtimeID() {
            return $this->ShowtimeID;
        }
        function get_Price() {
            return $this->Price;
        }
        function get_MovieID() {
            return $this->MovieID;
        }
        function get_StartTime() {
            return $this->StartTime;
        }
        function get_EndTime() {
            return $this->EndTime;
        }
        function get_RoomID() {
            return $this->RoomID;
        }   
        function get_FormatID() {
            return $this->FormatID;
        }


        function set_ShowtimeID($ShowtimeID) {
            $this->ShowtimeID = $ShowtimeID;
        }
        function set_Price($Price) {
            $this->Price = $Price;
        }
        function set_MovieID($MovieID) {
            $this->MovieID = $MovieID;
        }
        function set_StartTime($StartTime) {
            $this->StartTime = $StartTime;
        }
        function set_EndTime($EndTime) {
            $this->EndTime = $EndTime;
        }
        function set_RoomID($RoomID) {
            $this->RoomID = $RoomID;
        }
        function set_FormatID($FormatID) {
            $this->FormatID = $FormatID;
        }
    }
?>