<?php 
require_once(__DIR__.'/../entity/Seat.php');
require_once(__DIR__.'/../System/Database.php');

class SeatModel {
    public $conn;  

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin Seat theo ID
    public function getSeatByID($id) {
        $stmt = $this->conn->prepare("SELECT SeatID, SeatName,  Type, RoomID FROM seat WHERE SeatID=:SeatID");
        $stmt->bindParam(':SeatID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Seat');
        $stmt->execute();
        $Seat = $stmt->fetchObject();
        if($Seat!=null){
            return (array("success"=>true,"Seat"=>$Seat));
        }else{
            return (array("success"=>false,"error"=>"Seat không tồn tại"));
        }
    }
  
    // Phương thức thêm mới một Seat
    public function addSeat(Seat $Seat){
        try{
            $stmt =$this->conn->prepare("INSERT INTO seat (SeatID, SeatName,  Type, RoomID) VALUES (:SeatID, :SeatName, :Type, :RoomID)");
            $SeatID = $this->createNewID();
            $SeatName = $Seat->get_SeatName();
            $Type = $Seat->get_Type();
            $RoomID = $Seat->get_RoomID();

            $stmt->bindParam(':SeatID', $SeatID);
            $stmt->bindParam(':SeatName', $SeatName);
            $stmt->bindParam(':Type', $Type);
            $stmt->bindParam(':RoomID', $RoomID);
            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một Seat theo ID
public function deleteSeat($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM seat WHERE SeatID = :SeatID");
        $stmt->bindParam(':SeatID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Seat không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Seat
public function updateSeat(Seat $Seat) {
    try {
        $stmt = $this->conn->prepare("UPDATE seat SET SeatName = :SeatName, Type = :Type WHERE SeatID = :SeatID");
        $id = $Seat->get_SeatID();
        $SeatName = $Seat->get_SeatName();
        $Type = $Seat->get_Type();
       
        
        $stmt->bindParam(':SeatID', $id);
        $stmt->bindParam(':SeatName', $SeatName);
        $stmt->bindParam(':Type', $Type);    
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Seat không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}


    // Phương thức getAll cho Seat
public function getAllSeat($page){
    $page = intval($page);
    $number =  20;
    $offset = ($page - 1) * $number;
    $stmt = $this->conn->prepare("SELECT SeatID, SeatName,  Type, RoomID FROM seat limit $offset,$number ");
    $stmt->execute();
    $Seats = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Seat = new Seat( $row['SeatName'], $row['RoomID'], $row['Type'],$row['SeatID']);
        $Seats[] = $Seat;
    }
    return (array("success" => true, "list" => $Seats));
}
public function getAllSeatByRoom($RoomID){
 
    $stmt = $this->conn->prepare("SELECT SeatID, SeatName,  Type, RoomID FROM seat where RoomID = :RoomID ");
    $stmt ->bindParam(":RoomID",$RoomID);
    $stmt->execute();
    $Seats = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Seat = new Seat( $row['SeatName'], $row['RoomID'], $row['Type'],$row['SeatID']);
        $Seats[] = $Seat;
    }
    return (array("success" => true, "list" => $Seats));
}
    // Phương thức sinh mã ID mới cho Seat
    public function createNewID() {
        $query = "SELECT SeatID FROM Seat ORDER BY CAST(RIGHT(SeatID, LENGTH(SeatID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "SE" . ($lastId + 1);
        return $newId;
    }

}


?>