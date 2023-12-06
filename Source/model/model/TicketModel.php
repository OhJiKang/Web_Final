<?php
require_once(__DIR__.'/../entity/Ticket.php');
require_once(__DIR__.'/../entity/DetailTicket.php');
require_once(__DIR__.'/../System/Database.php');
class TicketModel{
    private $db; 
    public function __construct(){
        $this->db = Database::getConnection();
    }
    private function createNewID(){
        $query = "SELECT TicketID FROM  Ticket ORDER BY CAST(RIGHT(TicketID, LENGTH(TicketID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->db->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "TK" . ($lastId + 1);
        return $newId;
    }
    public function getAllTicketByBookingID($bookingid) {
        try {
            $stmt = $this->db->prepare("SELECT Ticket.* from Ticket JOIN detailticket as dt ON dt.TicketID = Ticket.TicketID 
                                        WHERE dt.BookingID = :BookingID 
                                        ");
            $stmt->bindParam(":BookingID", $bookingid);
            $stmt->execute();
            
            $listTicket = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $listTicket[] = new Ticket($row['ShowtimeID'], $row['SeatID'], $row['status'], $row['TicketID']);
            }
            return $listTicket;
        } catch (PDOException $e) {
            // Log or handle the error as appropriate
            error_log("Error retrieving tickets for booking ID {$bookingid}: {$e->getMessage()}");
            return false;
        }
    }
    
    public function addTicket(Ticket $ticket){
        try {
            $stmt = $this->db->prepare("INSERT INTO Ticket(TicketID,ShowTimeID,SeatID,Status) VALUES(:TicketID,:ShowTimeID,:SeatID,:Status)");
            $id = $this->createNewID();
            $ShowTimeID = $ticket -> get_ShowtimeID();
            $SeatID = $ticket -> get_SeatID();
            $Status = $ticket -> getStatus();
            $stmt->bindParam(':TicketID',$id);
            $stmt->bindParam(':ShowTimeID',$ShowTimeID);         
               $stmt->bindParam(':SeatID',$SeatID);            
               $stmt->bindParam(':Status',$Status);
            $stmt->execute();
            return array("success"=>true,"TicketID"=>$id);
        }catch(Exception $e){
        return (array('success' => false, 'message' => $e->getMessage()));
        }
    }
    public function deleteTicket(Ticket $ticket){
        try {
            $stmt = $this->db->prepare("DELETE FROM Ticket WHERE TicketID=:TicketID");
            $stmt->bindParam(':TicketID',$ticket->get_TicketID());
            $stmt->execute();
            if($stmt ->RowCount()>0){
                return (array('success' => true ));

            }else {
                return (array('success' => false ,"message"=>"Ticket does not exist"));
            }
        }catch(Exception $e){
            return (array('success' => false,'message' => $e->getMessage()));
        }
    }
    public function getAllTicketByShowTimeID($ShowTimeID){
        try{
        $stmt = $this->db->prepare("SELECT TicketID,ShowTimeID,SeatID,Status FROM Ticket where ShowTimeID = '$ShowTimeID'
        ORDER BY CAST(RIGHT(TicketID, LENGTH(TicketID) - 2) AS UNSIGNED) DESC
        ");
        $stmt->execute();
        $listTicket = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $listTicket[] = new Ticket($row['ShowTimeID'],$row['SeatID'],$row['Status'],$row['TicketID']);
        }
        return (array('success' => true, 'listTicket' => $listTicket));
        }
    catch(PDOException $e){
        return (array('success' => false, 'error' => $e->getMessage()));

    }
}
    public function getAllTicket($page){
        $page = intval($page);
        $number =  35;
        $offset = ($page - 1) * $number;
        $stmt = $this->db->prepare("SELECT TicketID,ShowTimeID,SeatID,Status FROM Ticket ORDER BY CAST(RIGHT(TicketID, LENGTH(TicketID) - 2) AS UNSIGNED) DESC LIMIT $offset,$number");
        $stmt->execute();
        $listTicket = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $listTicket[] = new Ticket($row['ShowTimeID'],$row['SeatID'],$row['Status'],$row['TicketID']);
        }
        
        return (array('success' => true, 'listTicket' => $listTicket));
    }
    public function getTicketById($id){
       
        $stmt = $this->db->prepare("SELECT TicketID,ShowTimeID,SeatID,Status FROM Ticket where TicketID =:id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $ticket  = null;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ticket = new Ticket($row['ShowTimeID'],$row['SeatID'],$row['Status'],$row['TicketID']);
        }
        if($ticket==null){
        return (array('success' => false, 'message' => "Ticket không tồn tại"));

        }
        return (array('success' => true, 'ticket' => $ticket));
    }
    public function deleteTicketbyBookingID($booking_id){
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("DELETE FROM detailticket WHERE BookingID=:BookingID");
            $stmt->bindParam(':BookingID',$booking_id);
            $stmt->execute();
            $stmt = $this->db->prepare("DELETE FROM Ticket WHERE TicketID IN (SELECT TicketID FROM detailticket WHERE BookingID=:BookingID)");
            $stmt->bindParam(':BookingID',$booking_id);
            $stmt->execute();
            $this->db->commit();
            return (array('success' => true ));
        }catch(Exception $e){
            $this->db->rollBack();
            return (array('success' => false,'message' => $e->getMessage()));
        }
    }
    public function addTicketsDetails(DetailTicket $ticket){
         try {
            $stmt = $this->db->prepare("INSERT INTO `detailticket`(`TicketID`, `BookingID`) VALUES (:TicketID,:BookingID)");
            
            $BookingID = $ticket -> get_BookingID();
            $ticketid = $ticket->get_TicketID();
            $stmt->bindParam(':TicketID', $ticketid);
            $stmt->bindParam(':BookingID', $BookingID);
            $stmt->execute();
            return array("success"=>true );
        }catch(Exception $e){
        return (array('success' => false, 'message' => $e->getMessage()));
        }
    }
    public function updateTicket(Ticket $ticket){
        try {
            $stmt = $this->db->prepare("UPDATE Ticket SET ShowTimeID=:ShowTimeID,SeatID=:SeatID,Status=:Status WHERE TicketID=:TicketID");
            $id = $ticket->get_TicketID();
            $ShowTimeID = $ticket -> get_ShowtimeID();
            $SeatID = $ticket -> get_SeatID();
            $Status = $ticket -> getStatus();
            $stmt->bindParam(':TicketID',$id);
            $stmt->bindParam(':ShowTimeID',$ShowTimeID);
            $stmt->bindParam(':SeatID',$SeatID);
            $stmt->bindParam(':Status',$Status);
            $stmt->execute();
            if($stmt ->rowCount()>0){
                return (array('success' => true ));

            }else {
                return (array('success' => false ,"message"=>"Ticket does not exist"));
            }
        }catch(Exception $e){
            return (array('success' => false,'message' => $e->getMessage()));
        }
    }
}
?>