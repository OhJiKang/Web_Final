<?php 

require_once (__DIR__.'/../System/Database.php');
require_once (__DIR__.'/../entity/Manager.php');

class ManagerModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin manager theo ID
    public function getManagerByID($id) {
        $stmt = $this->conn->prepare("SELECT ManagerID, FullName,  Email, Phone, account_id FROM manager WHERE ManagerID=:ManagerID");
        $stmt->bindParam(':ManagerID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Manager');
        $stmt->execute();
        $manager = $stmt->fetchObject();
        header('Content-Type: application/json');
        
        if($manager!=null){
            return json_encode(array("success"=>true,"manager"=>$manager));
        }else{
            return json_encode(array("success"=>false,"error"=>"Manager không tồn tại"));
        }
    }

    // Phương thức lấy thông tin manager theo email
    public function getManagerByEmail($email) {
        $stmt = $this->conn->prepare(" SELECT ManagerID, FullName,  Email, Phone, account_id FROM manager WHERE Email=:Email ");
        $stmt->bindParam(':Email', $email);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Manager');
        $stmt->execute();
        $manager = $stmt->fetchObject();

        if($manager!=null){
            return json_encode(array("success"=>true,"manager"=>$manager));
        }else{
        header('Content-Type: application/json');

            return json_encode(array("success"=>false,"error"=>"Manager không tồn tại"));
        }
    }
    public function getAllManager($page = 1) {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $stmt = $this->conn->prepare("
            SELECT 
                m.ManagerID, 
                m.FullName, 
                m.Email, 
                m.Phone, 
                m.account_id, 
                a.password 
            FROM 
                manager m 
                INNER JOIN account a ON m.account_id = a.id 
            LIMIT 
                :offset, :perPage
        ");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $managers = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $manager = new Manager(
                $row['FullName'], 
                $row['Email'], 
                $row['Phone'], 
                $row['account_id'],
                $row['ManagerID']
            );
             $manager->setPassword($row['password']);
            $managers[] = $manager;
        }
        return json_encode(array("success" => true, "list" => $managers));
    }
    
   
    // Phương thức thêm mới một manager
    public function addManager(Manager $manager){
        try{
            $stmt =$this->conn->prepare("INSERT INTO manager (ManagerID, FullName, Email, Phone, account_id) VALUES (:id, :name, :email, :phone ,:account_id)");
            $id = $this->createNewIDManager();
            $name = $manager->get_FullName();
            $email = $manager->get_Email();
            // return json_encode(array("id"=>$id));
           
            $phone = $manager->get_Phone();
            $account_id = $manager->get_AccountId();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
      
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':account_id', $account_id);
            $stmt ->execute();
            return json_encode(array("success"=>true));
        }catch(Exception $e){
            return json_encode(array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một manager theo ID
public function deleteManager($email) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM manager WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        header('Content-Type: application/json');

        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Manager không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một manager
public function updateManager(Manager $manager) {
    try {
        $stmt = $this->conn->prepare("UPDATE manager SET FullName = :FullName, Phone = :Phone WHERE ManagerID = :ManagerID");
        $id = $manager->get_ManagerID();
        $name = $manager->get_FullName();
        $email = $manager->get_Email();

        $phone = $manager->get_Phone();
        $stmt->bindParam(':ManagerID', $id);
        $stmt->bindParam(':FullName', $name);
       
     
        $stmt->bindParam(':Phone', $phone);

        
        $stmt->execute();
        header('Content-Type: application/json');
        
        if ($stmt->rowCount() > 0) {
            return json_encode(array("success" => true));
        } else {
            return json_encode(array("success" => false, "error" => "Manager không tồn tại"));
        }
    } catch (Exception $e) {
        return json_encode(array("success" => false, "error" => $e->getMessage()));
    }
}


    // Phương thức sinh mã ID mới cho manager
    private function createNewIDManager(){
        $query = "SELECT ManagerID FROM manager ORDER BY CAST(RIGHT(ManagerID, LENGTH(ManagerID) - 2) AS UNSIGNED) DESC LIMIT 1";
            
        $result = $this->conn->query($query);
        $lastId = intval(substr($result->fetchColumn(), 2));
        if($lastId == null){
            return "MG1";
        }
        $newId = "MG" . ($lastId + 1);
        return $newId;
    }
    
    
}
// $temp = new Manager("HUỳnH nhậ121t Lin3424234h","linhuhynh","04234","AC26");


// echo (new ManagerModel())->getManagerByEmail("M2@gmail.com");
?>