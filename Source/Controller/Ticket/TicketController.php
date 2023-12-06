<?php 
require_once '../../model/model/TicketModel.php';
require_once '../../model/entity/Ticket.php';
class TicketController {

    function getAllTickets($page) {
        return (new TicketModel())->getAllTicket($page);
    }
    function getTicketById($id) {
        return (new TicketModel())->getTicketById($id);
    }
    function  getAllTicketByShowTime($showTime) {
        return (new TicketModel())->getAllTicketByShowTimeID($showTime);
    }

    function addTicket($data){
      
         $ShowtimeID = $data['ShowtimeID'];
         $SeatID = $data['SeatID'];
         $Status = $data['Status'];
   
        return (new TicketModel())->addTicket(new Ticket($ShowtimeID, $SeatID,$Status ));
    }
    function removeTicket($id){
        return (new TicketModel())->deleteTicket($id);

    }
    function updateTicket($data){
        $TicketID = $data['TicketID'];
        $ShowtimeID = $data['ShowtimeID'];
        $SeatID = $data['SeatID'];
        $Status = $data['Status'];
  
        $Ticket = new Ticket($ShowtimeID, $SeatID,$Status, $TicketID );
        return (new TicketModel())->updateTicket($Ticket);

    }
}

?>