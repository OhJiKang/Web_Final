<?php 
require_once(__DIR__.'/../entity/Room.php');
require_once(__DIR__.'/../entity/Seat.php');
require_once(__DIR__.'/../System/Database.php');

class RoomModel {
    public $conn;  

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin room theo ID
    public function getRoomByID($id) {
        $stmt = $this->conn->prepare("SELECT  RoomName,  NumberOfSeats, TheaterID ,RoomID FROM room WHERE RoomID=:RoomID");
        $stmt->bindParam(':RoomID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Room');
        $stmt->execute();
        $room = $stmt->fetchObject();
        if($room!=null){
            return (array("success"=>true,"room"=>$room));
        }else{
            return (array("success"=>false,"error"=>"Room không tồn tại"));
        }
    }
  
    // Phương thức thêm mới một Room
    public function addRoom(Room $Room){
        try{
            $stmt =$this->conn->prepare("INSERT INTO room (RoomID, RoomName,  NumberOfSeats, TheaterID) VALUES (:RoomID, :RoomName, :NumberOfSeats, :TheaterID)");
            $RoomID = $this->createNewID();
            $RoomName = $Room->get_RoomName();
            $NumberOfSeats = $Room->get_NumberOfSeats();
            $TheaterID = $Room->get_TheaterID();

            $stmt->bindParam(':RoomID', $RoomID);
            $stmt->bindParam(':RoomName', $RoomName);
            $stmt->bindParam(':NumberOfSeats', $NumberOfSeats);
            $stmt->bindParam(':TheaterID', $TheaterID);
            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    
   

    
public function deleteRoom($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM room WHERE RoomID = :RoomID");
        $stmt->bindParam(':RoomID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Room không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Room
public function updateRoom(Room $Room) {
    try {
        $stmt = $this->conn->prepare("UPDATE room SET RoomName = :RoomName, NumberOfSeats = :NumberOfSeats WHERE RoomID = :RoomID");
        $id = $Room->get_RoomID();
        $RoomName = $Room->get_RoomName();
        $NumberOfSeats = $Room->get_NumberOfSeats();
       
        
        $stmt->bindParam(':RoomID', $id);
        $stmt->bindParam(':RoomName', $RoomName);
        $stmt->bindParam(':NumberOfSeats', $NumberOfSeats);    
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Room không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}


    // Phương thức getAll cho Room
public function getAllRoom(){
    $stmt = $this->conn->prepare("SELECT RoomID, RoomName,  NumberOfSeats, TheaterID FROM room");
    $stmt->execute();
    $Rooms = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Room = new Room( $row['RoomName'] , $row['TheaterID'], $row['NumberOfSeats'],$row['RoomID']);
        $Rooms[] = $Room;
    }
    return (array("success" => true, "list" => $Rooms));
}

    // Phương thức sinh mã ID mới cho Room
    public function createNewID() {
        $query = "SELECT RoomID FROM room ORDER BY CAST(RIGHT(RoomID, LENGTH(RoomID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "RO" . ($lastId + 1);
        return $newId;
    }

}

//$temp = new Room('RoomName 3', 'TH001', 3);



?>