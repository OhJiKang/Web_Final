<?php 
require_once(__DIR__.'/../entity/Language.php');
require_once(__DIR__.'/../System/Database.php');

class LanguageModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin Language theo ID
    public function getLanguageByID($id) {
        $stmt = $this->conn->prepare("SELECT LanguageID, LanguageName FROM language WHERE LanguageID=:LanguageID");
        $stmt->bindParam(':LanguageID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Language');
        $stmt->execute();
        $language = $stmt->fetchObject();
        return $language;
        if($language!=null){
            return array("success"=>true,"language"=>$language);
        }else{
            return array("success"=>false,"error"=>"Language không tồn tại");
        }
    }
  
    // Phương thức thêm mới một Language
    public function addLanguage(Language $Language){
        try{
            $stmt =$this->conn->prepare("INSERT INTO language (LanguageID, LanguageName) VALUES (:LanguageID, :LanguageName)");
            $LanguageID = $this->createNewID();
            $LanguageName = $Language->get_LanguageName();

            $stmt->bindParam(':LanguageID', $LanguageID);
            $stmt->bindParam(':LanguageName', $LanguageName);
            $stmt ->execute();
            return array("success"=>true);
        }catch(Exception $e){
            return array("success"=>false,"error"=>$e->getMessage());
        }
    }
    // Phương thức xóa một Language theo ID
public function deleteLanguage($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM language WHERE LanguageID = :LanguageID");
        $stmt->bindParam(':LanguageID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return array("success" => true);
        } else {
            return array("success" => false, "error" => "Language không tồn tại");
        }
    } catch (Exception $e) {
        return array("success" => false, "error" => $e->getMessage());
    }
}
// Phương thức cập nhật thông tin một Language
public function updateLanguage(Language $Language) {
    try {
        $stmt = $this->conn->prepare("UPDATE language SET LanguageName = :LanguageName WHERE LanguageID = :LanguageID");
        $LanguageID = $Language->get_LanguageID();
        $LanguageName = $Language->get_LanguageName();

        $stmt->bindParam(':LanguageID', $LanguageID);
        $stmt->bindParam(':LanguageName', $LanguageName);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return array("success" => true);
        } else {
            return array("success" => false, "error" => "Language không tồn tại");
        }
    } catch (Exception $e) {
        return array("success" => false, "error" => $e->getMessage());
    }
}


    // Phương thức getAll cho Language
    public function getAllLanguages(){
        $stmt = $this->conn->prepare("SELECT LanguageID, LanguageName FROM language");
        $stmt->execute();
        $Languages = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Language = new Language( $row['LanguageName'],$row['LanguageID']);
            $Languages[] = $Language;
        }
        return  array("success" => true, "Language" => $Languages);
    }
    
        // Phương thức sinh mã ID mới cho Language
        public function createNewID() {
            $query = "SELECT LanguageID FROM language ORDER BY CAST(RIGHT(LanguageID, LENGTH(LanguageID) - 2) AS UNSIGNED) DESC LIMIT 1";
            $result = $this->conn->query($query);
            $lastId = 0;
        
            if ($result->rowCount() > 0) {
                $lastId = intval(substr($result->fetchColumn(), 2));
            }
        
            $newId = "L" . ($lastId + 1);
            return $newId;
        }
    
    }
// $temp = new Language('LanguageName item 12345', 'L001');


// return (new LanguageModel())->getAllLanguage();
?>