<?php 
require_once(__DIR__.'/../entity/MenuDetail.php');
require_once(__DIR__.'/../System/Database.php');

class MenuDetailModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }
    
    // Phương thức lấy thông tin Menu theo ID
     // Phương thức lấy thông tin Menu theo ID
     public function getMenuDetailByBookingID($id) {
        $stmt = $this->conn->prepare("SELECT 
                md.Number,	
                md.Total,	
                md.BookingID ,
                md.ItemID	,
                m.Name ,
                m.Price,
                m.ImageURL,
                m.status
            FROM menudetail as md 
            JOIN menu as m ON m.ItemID = md.ItemID  
            WHERE md.BookingID=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        $list = array();
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $menudetail = new MenuDetail($row['Number'], $row['Total'], $row['BookingID'], $row['ItemID']);
            $menu = new Menu($row['Name'], $row['ImageURL'], $row['Price'], $row['status'], $row['ItemID']); 
            $list[] = array('detailmenu' => $menudetail, 'menu' => $menu);
        }
        return $list;
    }
    
    // Phương thức thêm mới một Menu
    public function addMenu(MenuDetail $menuDetail){
        try{
            $stmt =$this->conn->prepare("INSERT INTO menudetail (Number,Total,BookingID, ItemID) VALUES (:Number,:Total,:BookingID, :ItemID)");
            $ItemID = $menuDetail->get_ItemID();
            $number = $menuDetail->get_Number();
            $total = $menuDetail->get_Total();
            $BookingID = $menuDetail->get_BookingID();

            $stmt->bindParam(':Number', $number);
            $stmt->bindParam(':Total', $total);
            $stmt->bindParam(':ItemID', $ItemID);
            $stmt->bindParam(':BookingID', $BookingID);
            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một Menu theo ID
    public function deleteMenudetailByBooking($booking){
        try {
            $stmt = $this->conn->prepare("DELETE FROM menudetail WHERE BookingID = :BookingID");
            $stmt->bindParam(':BookingID', $booking);
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
public function deleteMenu($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM menudetail WHERE BookingID = :BookingID");
        $stmt->bindParam(':BookingID', $id);
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
public function updateMenu(MenuDetail $menuDetail) {
    try {
        $stmt = $this->conn->prepare("UPDATE menudetail SET ItemID = :ItemID, Number = :Number, Total = :Total WHERE BookingID = :BookingID");
        $number = $menuDetail->get_Number();
        $total = $menuDetail->get_Total();

        $stmt->bindParam(':Number', $number);
        $stmt->bindParam(':Total', $total);
        
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

   

}

?>