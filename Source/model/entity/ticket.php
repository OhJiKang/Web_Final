<?php
    class Ticket {
        public $TicketID;
        public $ShowtimeID;
        public $SeatID;
        public $Status;

        function __construct( $ShowtimeID, $SeatID,$Status, $TicketID=null )  {
            $this->ShowtimeID = $ShowtimeID;
            $this->SeatID = $SeatID;
            $this->Status = $Status;
            if( $TicketID != null ){
            $this->TicketID = $TicketID;

            }
        }
        public function getStatus() { return $this->Status; }
        public function setStatus($status) { $this->Status = $status; }
        function get_TicketID() {
            return $this->TicketID;
        }
        function get_ShowtimeID() {
            return $this->ShowtimeID;
        }
        function get_SeatID() {
            return $this->SeatID;
        }

        function set_TicketID($TicketID) {
            $this->TicketID = $TicketID;
        }
        function set_ShowtimeID($ShowtimeID) {
            $this->ShowtimeID = $ShowtimeID;
        }
        function set_SeatID($SeatID) {
            $this->SeatID = $SeatID;
        }
    }
?>