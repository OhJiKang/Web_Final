<?php 
require_once(__DIR__.'/../entity/Format.php');
require_once(__DIR__.'/../System/Database.php');

class FormatModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }
    public function getFormateOfMovie($movieID){
        try {
            $stmt = $this->conn->prepare("Select DISTINCT f.FormatID, f.NameFormat from Format as f JOIN showtime as st on st.FormatID = f.FormatID Join Movie as m on m.MovieID = st.MovieID WHERE m.MovieID = :MovieID");
            $stmt ->bindParam(':MovieID',$movieID);
            $stmt->execute();
            $formats = array();
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $format = new format(
                   $row['NameFormat'],  $row['FormatID']
                );
                $formats[] = $format;
            }
        
    
            if($format!=null){
                return (array("success"=>true,"format"=>$formats));
            }else{
                return (array("success"=>false,"error"=>"Format không tồn tại"));
            }
        }catch(Exception $e){
            return array("success"=>false, "error"=>$e->getMessage());
        }
    }
    // Phương thức lấy thông tin format theo ID
    public function getFormatByID($id) {
        $stmt = $this->conn->prepare("SELECT FormatID, NameFormat FROM format WHERE FormatID=:FormatID");
        $stmt->bindParam(':FormatID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Format');
        $stmt->execute();
        $format = $stmt->fetchObject();
        if($format!=null){
            return (array("success"=>true,"format"=>$format));
        }else{
            return (array("success"=>false,"error"=>"Format không tồn tại"));
        }
    }
  
    // Phương thức thêm mới một Format
    public function addFormat(Format $format){
        try{
            $stmt =$this->conn->prepare("INSERT INTO format (FormatID, NameFormat) VALUES (:FormatID, :NameFormat)");
            $FormatID = $this->createNewFormatID();
            $NameFormat = $format->get_NameFormat();

            $stmt->bindParam(':FormatID', $FormatID);
            $stmt->bindParam(':NameFormat', $NameFormat);
            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }

    // Phương thức xóa một Format theo ID
    public function deleteFormat($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM format WHERE FormatID = :FormatID");
            $stmt->bindParam(':FormatID', $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (array("success" => true));
            } else {
                return (array("success" => false, "error" => "Format không tồn tại"));
            }
        } catch (Exception $e) {
            return (array("success" => false, "error" => $e->getMessage()));
        }
    }
    private function createNewFormatID(){
        $query = "SELECT FormatID FROM format ORDER BY CAST(RIGHT(FormatID, LENGTH(FormatID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "FM" . sprintf('%03d', $lastId + 1);
        return $newId;
    }
    
    // Phương thức cập nhật thông tin một Format
    public function updateFormat(Format $format) {
        try {
            $stmt = $this->conn->prepare("UPDATE format SET NameFormat = :NameFormat WHERE FormatID = :FormatID");
            $id = $format->get_FormatID();
            $NameFormat = $format->get_NameFormat();
            
            $stmt->bindParam(':FormatID', $id);
            $stmt->bindParam(':NameFormat', $NameFormat);
            
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (array("success" => true));
            } else {
                return (array("success" => false, "error" => "Format không tồn tại"));
            }
        } catch (Exception $e) {
            return (array("success" => false, "error" => $e->getMessage()));
        }
    }
    public function getAllFormat() {
        $query = "SELECT * FROM format";
        $result = $this->conn->query($query);
        $formats = array();
    
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $format = new format(
               
                   $row['NameFormat'],  $row['FormatID']
                );
                $formats[] = $format;
            }
        }
    
        return (array("success" => true, "formats" => $formats));

    }
    
}

    //
?>