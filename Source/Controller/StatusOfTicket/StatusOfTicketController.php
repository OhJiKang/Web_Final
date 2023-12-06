<?php 
require_once '../../model/model/StatusOfTicketModel.php';
require_once '../../model/entity/StatusOfTicket.php';
class StatusOfTicketController {
    function getAllStatusOfTickets() {
        return (new StatusOfTicketModel())->getAllStatusOfTicket();
    }
    function getStatusOfTicketById($id) {
        return (new StatusOfTicketModel())->getStatusOfTicketByID($id);

    }
    function addStatusOfTicket($data){
        $name = $data['name'];
        return (new StatusOfTicketModel())->addStatusOfTicket(new StatusOfTicket($name));
    }
    function removeStatusOfTicket($id){
        return (new StatusOfTicketModel())->deleteStatusOfTicket($id);

    }
    function updateStatusOfTicket($data){
       $name =  $data['name'];
       $id = $data['id'];
        $StatusOfTicket = new StatusOfTicket($name,$id);
        return (new StatusOfTicketModel())->updateStatusOfTicket($StatusOfTicket);

    }
}

?>