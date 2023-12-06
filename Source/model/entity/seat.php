<?php 
    class Seat {
        public $SeatID;
        public $SeatName;
        public $Type;
        public $RoomID;

        function __construct($SeatName, $RoomID, $Type, $SeatID=null) {

            $this->SeatName = $SeatName;
            $this->Type = $Type;
            $this->RoomID = $RoomID;
            if($SeatID!=null){
                $this->SeatID = $SeatID;
            }
        }
        function get_SeatID() {
            return $this->SeatID;
        }
        function get_SeatName() {
            return $this->SeatName;
        }
        function get_Type() {
            return $this->Type;
        }
        function get_RoomID() {
            return $this->RoomID;
        }

        function set_SeatID($SeatID) {
            $this->SeatID = $SeatID;
        }
        function set_SeatName($SeatName) {
            $this->SeatName = $SeatName;
        }
        function set_Type($Type) {
            $this->Type = $Type;
        }
        function set_RoomID($RoomID) {
            $this->RoomID = $RoomID;
        }
    }
?>