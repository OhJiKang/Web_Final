<?php 
require_once(__DIR__.'/../entity/Menu.php');
require_once(__DIR__.'/../System/Database.php');

class MenuModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }
   
    // Phương thức lấy thông tin Menu theo ID
    public function getMenuByID($id) {
        $stmt = $this->conn->prepare("SELECT Name,  ImageURL ,Price,status ,ItemID FROM menu WHERE ItemID=:ItemID");
        $stmt->bindParam(':ItemID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Menu');
        $stmt->execute();
        $menu = $stmt->fetchObject();
        if($menu!=null){
            return (array("success"=>true,"menu"=>$menu));
        }else{
            return (array("success"=>false,"error"=>"Menu không tồn tại"));
        }
    }
    
    // Phương thức thêm mới một Menu
    public function addMenu(Menu $Menu){
        try{
            $stmt =$this->conn->prepare("INSERT INTO menu (ItemID, Name,  Price, ImageURL,status) VALUES (:ItemID, :Name, :Price, :ImageURL,:status)");
            $ItemID = $this->createNewID();
            $Name = $Menu->get_Name();
            $Price = $Menu->get_Price();
            $ImageURL = $Menu->get_ImageURL();
            $status = $Menu->getStatus();
            $stmt->bindParam(':ItemID', $ItemID);
            $stmt->bindParam(':Name', $Name);
            $stmt->bindParam(':Price', $Price);
            $stmt->bindParam(':ImageURL', $ImageURL);
            $stmt->bindParam(':status', $status);
            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một Menu theo ID
public function deleteMenu($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM menu WHERE ItemID = :ItemID");
        $stmt->bindParam(':ItemID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Menu không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Menu
public function updateMenu(Menu $Menu) {
    try {
        $stmt = $this->conn->prepare("UPDATE menu SET Name = :Name, Price = :Price, ImageURL = :ImageURL,status = :status WHERE ItemID = :ItemID");
        $id = $Menu->get_ItemID();
        $Name = $Menu->get_Name();
        $Price = $Menu->get_Price();
        $ImageURL = $Menu->get_ImageURL();
        $status = $Menu->getStatus();

        $stmt->bindParam(':ItemID', $id);
        $stmt->bindParam(':Name', $Name);
        $stmt->bindParam(':Price', $Price);    
        $stmt->bindParam(':ImageURL', $ImageURL);
        $stmt->bindParam(':status', $status);
        
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Menu không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
    
    // Phương thức getAll cho Menu
    public function getAllMenu($page) {
        $limit = 15; 
        $offset = ($page - 1) * $limit; 
    
    
        $query = "SELECT Name, ImageURL, Price,status ,ItemID FROM menu LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        $menus = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $menu = new Menu($row['Name'], $row['ImageURL'],$row['Price'], $row['status'], $row['ItemID']);
            $menus[] = $menu;
        }
    
        return array('menus' => $menus);
    }
    public function getAllMenuByStatus($page,$status) {
        $limit = 15; 
        $offset = ($page - 1) * $limit; 
    
    
        $query = "SELECT Name, ImageURL, Price,status, ItemID FROM menu where status = $status LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        $menus = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $menu = new Menu($row['Name'], $row['Price'], $row['ImageURL'], $row['status'], $row['ItemID']);
            $menus[] = $menu;
        }
    
        return array('menus' => $menus);
    }
    
        // Phương thức sinh mã ID mới cho Menu
        private function createNewID() {
            $query = "SELECT ItemID FROM Menu ORDER BY CAST(RIGHT(ItemID, LENGTH(ItemID) - 1) AS UNSIGNED) DESC LIMIT 1";
            $result = $this->conn->query($query);
            $lastId = 0;
        
            if ($result->rowCount() > 0) {
                $lastId = intval(substr($result->fetchColumn(), 1));
            }
        
            $newId = "I" . ($lastId + 1);
            return $newId;
        } 

}

?>