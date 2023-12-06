<?php 
require_once(__DIR__.'/../entity/StatusOfTicket.php');
require_once(__DIR__.'/../System/Database.php');

class StatusOfTicketModel {
    public $conn;
    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin StatusOfTicket theo ID
    public function getStatusOfTicketByID($id) {
        $stmt = $this->conn->prepare("SELECT id, name FROM status_of_ticket WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'StatusOfTicket');
        $stmt->execute();
        $StatusOfTicket = $stmt->fetchObject();
        if($StatusOfTicket!=null){
            echo json_encode(array("success"=>true,"StatusOfTicket"=>$StatusOfTicket));
        }else{
            echo json_encode(array("success"=>false,"error"=>"StatusOfTicket không tồn tại"));
        }
    }
  
    // Phương thức thêm mới một StatusOfTicket
    public function addStatusOfTicket(StatusOfTicket $StatusOfTicket){
        try{
            $stmt =$this->conn->prepare("INSERT INTO status_of_ticket (id, name) VALUES (:id, :name)");
            $id = $this->createNewID();
            $name = $StatusOfTicket->getName();

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt ->execute();
            echo json_encode(array("success"=>true));
        }catch(Exception $e){
            echo json_encode(array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một StatusOfTicket theo ID
public function deleteStatusOfTicket($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM status_of_ticket WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => "StatusOfTicket không tồn tại"));
        }
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một StatusOfTicket
public function updateStatusOfTicket(StatusOfTicket $StatusOfTicket) {
    try {
        $stmt = $this->conn->prepare("UPDATE status_of_ticket SET name = :name WHERE id = :id");
        $id = $StatusOfTicket->getId();
        $name = $StatusOfTicket->getName();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => "StatusOfTicket không tồn tại"));
        }
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "error" => $e->getMessage()));
    }
}


    // Phương thức getAll cho StatusOfTicket
    public function getAllStatusOfTicket(){
        $stmt = $this->conn->prepare("SELECT id, name FROM status_of_ticket");
        $stmt->execute();
        $StatusOfTickets = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $StatusOfTicket = new StatusOfTicket($row['id'], $row['name']);
            $StatusOfTickets[] = $StatusOfTicket;
        }
        echo json_encode(array("success" => true, "list" => $StatusOfTickets));
    }
    
        // Phương thức sinh mã ID mới cho StatusOfTicket
        public function createNewID() {
            $query = "SELECT id FROM status_of_ticket ORDER BY CAST(RIGHT(id, LENGTH(id) - 2) AS UNSIGNED) DESC LIMIT 1";
            $result = $this->conn->query($query);
            $lastId = 0;
        
            if ($result->rowCount() > 0) {
                $lastId = intval(substr($result->fetchColumn(), 2));
            }
        
            $newId = "ST" . ($lastId + 1);
            return $newId;
        }

}

?>