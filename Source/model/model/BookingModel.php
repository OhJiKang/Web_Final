<?php 
require_once (__DIR__.'/../entity/Booking.php');
require_once (__DIR__.'/../entity/Menu.php');
require_once (__DIR__.'/../entity/MenuDetail.php');
require_once (__DIR__.'/../entity/Ticket.php');
require_once (__DIR__.'/../entity/DetailTicket.php');
require_once (__DIR__.'/../System/Database.php');
require_once (__DIR__.'/TicketModel.php');
require_once (__DIR__.'/MenuDetailModel.php');
class BookingModel {
    private $conn;
    public function __construct(){
        $this->conn = Database::getConnection();
    }
    private function createNewID(){
        $query = "SELECT BookingID FROM Booking ORDER BY CAST(RIGHT(BookingID, LENGTH(BookingID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "BK" . ($lastId + 1);
        return $newId;
    }
   
   
    public function getBookingDetails($bookingid){
        $stmt = $this->conn->prepare("SELECT 
        BookingID,
        NumberOfTickets,
        TotalPrice,
        BookingTime,
        Voucher ,
        customer_id,
        status
    FROM Booking
    where BookingID = :id
    ");
    $stmt ->bindParam(":id",$bookingid);
    $stmt ->setFetchMode(PDO::FETCH_CLASS,'Booking');
    $stmt ->execute();
    $booking = $stmt->fetchObject();

    if($booking==null){
        return array("booking"=>null);
    }
    $ListTicket = (new TicketModel())->getAllTicketByBookingID($bookingid);
    $ListMenu = (new MenuDetailModel())->getMenuDetailByBookingID($bookingid);
    return array("booking"=>$booking, "menu"=>$ListMenu,"ticket"=>$ListTicket);
    }

    public function getAllBookingsByCustomerID($customer_id,$page = 1 ) {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $stmt = $this->conn->prepare("SELECT 
            BookingID,
            NumberOfTickets,
            TotalPrice,
            BookingTime,
            Voucher ,
            customer_id,
            status
        FROM Booking
        where customer_id =:id
        
        ORDER BY CAST(RIGHT(BookingID, LENGTH(BookingID) - 2) AS UNSIGNED) DESC
        LIMIT 
    :perPage OFFSET :offset");
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $customer_id);
        $stmt->execute();
        $bookings = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $booking = new Booking($row['NumberOfTickets'],$row['BookingTime'],$row['TotalPrice'],$row['Voucher'],$row['customer_id'],$row['status'],$row['BookingID']);   
            $ListTicket = (new TicketModel())->getAllTicketByBookingID($row['BookingID']);
            $ListMenu = (new MenuDetailModel())->getMenuDetailByBookingID($row['BookingID']);
            $bookings[] =  array("booking"=>$booking, "menu"=>$ListMenu,"ticket"=>$ListTicket);
        }
        return $bookings;
    }
    public function getAllBookings($page = 1 ) {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $stmt = $this->conn->prepare("SELECT 
            BookingID,
            NumberOfTickets,
            TotalPrice,
            BookingTime,
            Voucher ,
            customer_id,
            status
        FROM Booking
        
        ORDER BY CAST(RIGHT(BookingID, LENGTH(BookingID) - 2) AS UNSIGNED) DESC
LIMIT 
    :perPage OFFSET :offset");
    
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
        $stmt->execute();
        $bookings = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $booking =  new Booking($row['NumberOfTickets'],$row['BookingTime'],$row['TotalPrice'],$row['Voucher'],$row['customer_id'],$row['status'],$row['BookingID']);
            $bookings[] = $booking;
        }
    
        return (array("success"=>true, "bookings"=>$bookings));
    }
    
    function getBookingByID($Bookingid){
        $stmt = $this->conn->prepare("SELECT* FROM Booking WHERE BookingID = :Bookingid");
        $stmt ->bindParam(':Bookingid',$Bookingid);
        $stmt ->setFetchMode(PDO::FETCH_CLASS,'Booking');
        $stmt ->execute();
        $booking = $stmt->fetchObject();
        if($booking!=null) {
        return (array('success' => true, 'Booking'=>$booking));
        }else{
        return (array('success' => false,'message'=>"Booking not found"));

        }

   }
   function addBooking(Booking $booking){
   try{ $stmt = $this->conn->prepare("INSERT INTO Booking VALUES(:id,:numberticket,:total,:datetime,:voucher,:customer_id,:status)");
    $id = $this->createNewID();
    $numberticket = $booking->get_NumberOfTickets();
    $total = $booking->get_TotalPrice();
    $datetime = $booking->get_BookingTime();
    $voucher = $booking->get_Voucher();
    $customer_id = $booking->getCustomerId();
    $status = $booking->getStatus();
    $stmt->bindParam(":id",$id);
    $stmt->bindParam(":numberticket",$numberticket);
    $stmt->bindParam(":total",$total);
    $stmt->bindParam(":datetime",$datetime);
    $stmt->bindParam(":voucher",$voucher);
    $stmt->bindParam(":customer_id",$customer_id);
    $stmt->bindParam(":status",$status);
    $stmt ->execute();
          
    return (array("success"=>true,"message"=>"Thêm thành công","booking_id"=>$id));
}catch(Exception $e){

    return   (array("success"=>false,"error"=>$e->getMessage()));
    
    
         
    }} 
    function deleteBooking($id){
        try{
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare("DELETE FROM detailticket WHERE BookingID=:BookingID");
            $stmt->bindParam(':BookingID',$id);
            $stmt->execute();
            $stmt = $this->conn->prepare("DELETE FROM Ticket WHERE TicketID IN (SELECT TicketID FROM detailticket WHERE BookingID=:BookingID)");
            $stmt->bindParam(':BookingID',$id);
            $stmt->execute();
            $stmt = $this->conn->prepare("DELETE FROM menudetail WHERE BookingID = :BookingID");
            $stmt->bindParam(':BookingID', $id);
            $stmt->execute();
            $stmt = $this->conn->prepare("DELETE FROM Booking WHERE BookingID = :id");
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            $this->conn->commit();
            return (array("success" => true));
        }catch(Exception $e){
            $this->conn->rollBack();
            return (array("success" => false, "error" => $e->getMessage()));
        }
    }
    
   
    function updateBooking(Booking $booking){
        try{ 
            $stmt = $this->conn->prepare("UPDATE Booking SET NumberOfTickets=:numberticket, TotalPrice=:total, Voucher=:voucher,customer_id=:customer_id ,status = :status WHERE BookingID=:id");
            $id = $booking->get_BookingID();
            $numberticket = $booking->get_NumberOfTickets();
            $total = $booking->get_TotalPrice();
            $voucher = $booking->get_Voucher();
            $customer_id = $booking->getCustomerId();
            $status = $booking->getStatus();
            $stmt->bindParam(":id",$id);
            $stmt->bindParam(":numberticket",$numberticket);
            $stmt->bindParam(":total",$total);
            $stmt->bindParam(":voucher",$voucher);
            $stmt->bindParam(":customer_id",$customer_id);
            $stmt->bindParam(":status",$status);
            $stmt ->execute();
                   
            if ($stmt->rowCount() > 0) {
                return (array("success" => true));
            } else {
                return (array("success" => false, "error" => "Booking không tồn tại"));
            }
        } catch(Exception $e){
            return (array("Success"=>false,"error"=>$e->getMessage()));
        }
    }
    function updateBookingStatus($booking_id, $status){
        try{ 
            $stmt = $this->conn->prepare("UPDATE Booking SET status = :status WHERE BookingID=:id");
            $stmt->bindParam(":id", $booking_id);
            $stmt->bindParam(":status", $status);
            $stmt ->execute();
                   
            if ($stmt->rowCount() > 0) {
                return (array("success" => true));
            } else {
                return (array("success" => false, "error" => "Booking không tồn tại"));
            }
        } catch(Exception $e){
            return (array("Success"=>false,"error"=>$e->getMessage()));
        }
    }

    }

?>