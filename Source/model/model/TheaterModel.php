<?php 
require_once(__DIR__.'/../entity/Theater.php');
require_once(__DIR__.'/../System/Database.php');

class TheaterModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    } 

    // Phương thức lấy thông tin Theater theo ID
    public function getTheaterByID($id) {
        $stmt = $this->conn->prepare("SELECT TheaterID, TheaterName,  Address, Phone, NumberOfRooms FROM theater WHERE TheaterID=:TheaterID");
        $stmt->bindParam(':TheaterID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Theater');
        $stmt->execute();
        $theater = $stmt->fetchObject();
        if($theater!=null){
            return (array("success"=>true,"theater"=>$theater));
        }else{
            return (array("success"=>false,"error"=>"Theater không tồn tại"));
        }
    }

    // Phương thức thêm mới một Theater
    public function addTheater(Theater $Theater){
        try{
            $stmt =$this->conn->prepare("INSERT INTO theater (TheaterID, TheaterName,  Address, Phone, NumberOfRooms) VALUES (:TheaterID, :TheaterName, :Address, :Phone, :NumberOfRooms)");
            $TheaterID = $this->createNewID();
            $TheaterName = $Theater->get_TheaterName();
            $Address = $Theater->get_Address();
            $Phone = $Theater->get_Phone();
            $NumberOfRooms = $Theater->get_NumberOfRooms();

            $stmt->bindParam(':TheaterID', $TheaterID);
            $stmt->bindParam(':TheaterName', $TheaterName);
            $stmt->bindParam(':Address', $Address);
            $stmt->bindParam(':Phone', $Phone);
            $stmt->bindParam(':NumberOfRooms', $NumberOfRooms);
            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một Theater theo ID
public function deleteTheater($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM theater WHERE TheaterID = :TheaterID");
        $stmt->bindParam(':TheaterID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Theater không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Theater
public function updateTheater(Theater $Theater) {
    try {
        $stmt = $this->conn->prepare("UPDATE theater SET TheaterName = :TheaterName, Address = :Address, Phone = :Phone, NumberOfRooms = :NumberOfRooms WHERE TheaterID = :TheaterID");
        $id = $Theater->get_TheaterID();
        $TheaterName = $Theater->get_TheaterName();
        $Phone = $Theater->get_Phone();
        $Address = $Theater->get_Address();
        $NumberOfRooms = $Theater->get_NumberOfRooms();

        $stmt->bindParam(':TheaterID', $id);
        $stmt->bindParam(':TheaterName', $TheaterName);
        $stmt->bindParam(':Address', $Address);    
        $stmt->bindParam(':Phone', $Phone);
        $stmt->bindParam(':NumberOfRooms', $NumberOfRooms);
        
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Theater không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}


    // Phương thức getAll cho Theater
    public function getAllTheater(){
        $stmt = $this->conn->prepare("SELECT TheaterID, TheaterName,  Address, Phone,  NumberOfRooms FROM theater");
        $stmt->execute();
        $Theaters = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Theater = new Theater( $row['TheaterName'], $row['Address'], $row['Phone'], $row['NumberOfRooms'],$row['TheaterID']);
            $Theaters[] = $Theater;
        }
        return (array("success" => true, "list" => $Theaters));
    }
    
        // Phương thức sinh mã ID mới cho Theater
        public function createNewID() {
            $query = "SELECT TheaterID FROM theater ORDER BY CAST(RIGHT(TheaterID, LENGTH(TheaterID) - 2) AS UNSIGNED) DESC LIMIT 1";
            $result = $this->conn->query($query);
            $lastId = 0;
        
            if ($result->rowCount() > 0) {
                $lastId = intval(substr($result->fetchColumn(), 2));
            }
        
            $newId = "TH" . ($lastId + 1);
            return $newId;
        }

}
$temp = new Theater('TheaterName 3 neeeeeeeee', 'Address theater 3', 'P003', 3, 'TH001');


?>