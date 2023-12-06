<?php
    class Room {
        public $RoomID;
        public $RoomName;
        public $NumberOfSeats;
        public $TheaterID;

        function __construct($RoomName, $TheaterID, $NumberOfSeats, $RoomID=null) {

            $this->RoomName = $RoomName;
            $this->NumberOfSeats = $NumberOfSeats;
            $this->TheaterID = $TheaterID;
            if($RoomID!=null){
                $this->RoomID = $RoomID;
            }
        }
        function get_RoomID() {
            return $this->RoomID;
        }
        function get_RoomName() {
            return $this->RoomName;
        }
        function get_NumberOfSeats() {
            return $this->NumberOfSeats;
        }
        function get_TheaterID() {
            return $this->TheaterID;
        }
      

        function set_RoomID($RoomID) {
            $this->RoomID = $RoomID;
        }
        function set_RoomName($RoomName) {
            $this->RoomName = $RoomName;
        }
        function set_NumberOfSeats($NumberOfSeats) {
            $this->NumberOfSeats = $NumberOfSeats;
        }
        function set_TheaterID($TheaterID) {
            $this->TheaterID = $TheaterID;
        }
    }
?>