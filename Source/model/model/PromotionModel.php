<?php 
require_once(__DIR__.'/../entity/Promotion.php');
require_once(__DIR__.'/../System/Database.php');

class PromotionModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin Promotion theo ID
    public function getPromotionByID($id) {
        $stmt = $this->conn->prepare("SELECT  PromotionName, Description, StartTime, EndTime, Discount, Code,type,PromotionID,url_Image FROM promotion WHERE PromotionID=:PromotionID");
        $stmt->bindParam(':PromotionID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Promotion');
        $stmt->execute();
        $Promotion = $stmt->fetchObject();
        if($Promotion!=null){
            return (array("success"=>true,"Promotion"=>$Promotion));
        }else{
            return (array("success"=>false,"error"=>"Promotion không tồn tại"));
        }
    }
    public function getPromotionsVorcher($page){
        $page = intval($page); 
        $number = 12;
        $offset = ($page - 1) * $number;
        $query = "SELECT 	
        PromotionID	,
        PromotionName,	
        Description	,
        StartTime,
        EndTime,
        Discount,
        Code,
        type,
        url_Image 
        from promotion WHERE type = 2 and endtime >= NOW()  limit $offset,$number";
        $stmt = $this->conn->prepare($query);
       
        $stmt->execute();
        $Promotions = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Promotion = new Promotion($row['PromotionName'], $row['StartTime'], $row['Description'], $row['EndTime'], $row['Discount'], $row['Code'], $row['type'], $row['url_image'], $row['PromotionID']);
            $Promotions[] = $Promotion;
        }
        return (array("success" => true, "list" => $Promotions));
    }
    public function getPromotionsByCode($code){
        $stmt = $this->conn->prepare("SELECT PromotionName, Description, StartTime, EndTime, Discount, Code, type, PromotionID, url_Image FROM promotion WHERE Code=:Code");
        $stmt->bindParam(':Code', $code);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $result = $stmt->fetchAll();
    
        if(count($result) > 0) {
            $Promotion = new Promotion($result[0]['PromotionName'], $result[0]['StartTime'], $result[0]['Description'], $result[0]['EndTime'], $result[0]['Discount'], $result[0]['Code'], $result[0]['type'], $result[0]['url_Image'], $result[0]['PromotionID']);
            return $Promotion;
        } else {
            return null;
        }
    }
    
    public function getPromotionsEvent($page){
        $page = intval($page); 
        $number = 12;
        $offset = ($page - 1) * $number;
    $query = "SELECT 	
        PromotionID	,
        PromotionName,	
        Description	,
        StartTime,
        EndTime,
        Discount,
        Code,
        type,
        url_image 
        from promotion WHERE type = 1 and endtime >= NOW()  limit $offset,$number";
        $stmt = $this->conn->prepare($query);
       
        $stmt->execute();
        $Promotions = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Promotion = new Promotion($row['PromotionName'], $row['StartTime'], $row['Description'], $row['EndTime'], $row['Discount'], $row['Code'], $row['type'], $row['url_image'], $row['PromotionID']);
            $Promotions[] = $Promotion;
        }
        return (array("success" => true, "list" => $Promotions));
    }
    // Phương thức thêm mới một Promotion
    public function addPromotion(Promotion $Promotion){
        try{
            $stmt =$this->conn->prepare("INSERT INTO promotion (PromotionID, PromotionName, Description, StartTime, EndTime, Discount, Code,type,url_image) VALUES (:PromotionID, :Description, :StartTime, :PromotionName,:EndTime, :Discount, :Code,:type,:url_image)");
            $PromotionID = $this->createNewID();
            $PromotionName = $Promotion->get_PromotionName();
            $Description = $Promotion->get_Description();
            $StartTime = $Promotion->get_StartTime();
            $EndTime = $Promotion->get_EndTime();
            $Discount = $Promotion->get_Discount();
            $Code = $Promotion->get_Code();
            $type = $Promotion->GetType();
            $url_image = $Promotion->getUrlImage();
            $stmt->bindParam(':PromotionID', $PromotionID);
            $stmt->bindParam(':PromotionName', $PromotionName);
            $stmt->bindParam(':Description', $Description);
            $stmt->bindParam(':StartTime', $StartTime);
            $stmt->bindParam(':EndTime', $EndTime);
            $stmt->bindParam(':Discount', $Discount);
            $stmt->bindParam(':Code', $Code);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':url_image', $url_image);

            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một Promotion theo ID
public function deletePromotion($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM promotion WHERE PromotionID = :PromotionID");
        $stmt->bindParam(':PromotionID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Promotion không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Promotion
public function updatePromotion(Promotion $Promotion) {
    try {
        $stmt =$this->conn->prepare("UPDATE promotion SET PromotionName = :PromotionName, Description = :Description, StartTime = :StartTime, EndTime = :EndTime, Discount = :Discount, Code = :Code, type = :type, url_image = :url_image WHERE PromotionID=:PromotionID");
        $PromotionID = $Promotion->get_PromotionID();
        $PromotionName = $Promotion->get_PromotionName();
        $Description = $Promotion->get_Description();
        $StartTime = $Promotion->get_StartTime();
        $EndTime = $Promotion->get_EndTime();
        $Discount = $Promotion->get_Discount();
        $Code = $Promotion->get_Code();
        $type = $Promotion->GetType();
        $url_image = $Promotion->getUrlImage();
        $stmt->bindParam(':PromotionID', $PromotionID);
        $stmt->bindParam(':PromotionName', $PromotionName);
        $stmt->bindParam(':Description', $Description);
        $stmt->bindParam(':StartTime', $StartTime);
        $stmt->bindParam(':EndTime', $EndTime);
        $stmt->bindParam(':Discount', $Discount);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':Code', $Code);
        $stmt->bindParam(':url_image', $url_image);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Promotion không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}

    // Phương thức getAll cho Promotion
    public function getAllPromotion($page){
        $page = intval($page); 
        $number = 12;
        $offset = ($page - 1) * $number;
        $stmt = $this->conn->prepare("SELECT PromotionID, PromotionName,  Description, StartTime, EndTime,  Discount, Code,type,url_image FROM promotion limit $offset,$number ");
        $stmt->execute();
        $Promotions = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Promotion = new Promotion($row['PromotionName'], $row['StartTime'], $row['Description'], $row['EndTime'], $row['Discount'], $row['Code'], $row['type'], $row['url_image'], $row['PromotionID']);
            $Promotions[] = $Promotion;
        }
        return (array("success" => true, "list" => $Promotions));
    }
    
        // Phương thức sinh mã ID mới cho Promotion
        public function createNewID() {
            $query = "SELECT PromotionID FROM promotion ORDER BY CAST(RIGHT(PromotionID, LENGTH(PromotionID) - 2) AS UNSIGNED) DESC LIMIT 1";
            $result = $this->conn->query($query);
            $lastId = 0;
        
            if ($result->rowCount() > 0) {
                $lastId = intval(substr($result->fetchColumn(), 2));
            }
        
            $newId = "P" . ($lastId + 1);
            return $newId;
        }
    }



?>