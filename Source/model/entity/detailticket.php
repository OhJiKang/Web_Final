<?php
    class DetailTicket {
        public $TicketID;
        public $BookingID;

        function __construct($TicketID, $BookingID) {
            $this->TicketID = $TicketID;
            $this->BookingID = $BookingID;

        }
        function get_TicketID() {
            return $this->TicketID;
        }
        function get_BookingID() {
            return $this->BookingID;
        }

        function set_TicketID($TicketID) {
            $this->TicketID = $TicketID;
       }
       function set_BookingID($BookingID) {
            $this->BookingID = $BookingID;
       }
    }
?>
