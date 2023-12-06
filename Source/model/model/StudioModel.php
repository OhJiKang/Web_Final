<?php 
require_once(__DIR__.'/../entity/Studio.php');
require_once(__DIR__.'/../System/Database.php');

class StudioModel{
     public $conn;
     function __construct(){
          $this->conn = Database::getConnection();
          }


          function getAll(){

          $stmt = $this->conn->prepare("Select 
          StudioID	,
          StudioName	,
          Address	,
          Phone,	
          Email from Studio");

          $stmt ->execute();
          $studios = array();

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $studio = new Studio($row['StudioName'],$row['Address'],$row['Phone'],$row['Email'],$row['StudioID']);
               $studios[] = $studio;
          }
          return array("success"=>true, "studios"=>$studios);

     }
     public function createNewIDStudio(){
          $query = "SELECT StudioID FROM Studio ORDER BY CAST(RIGHT(StudioID, LENGTH(StudioID) - 2) AS UNSIGNED) DESC LIMIT 1";
          $result = $this->conn->query($query);
          $lastId = 0;
      
          if ($result->rowCount() > 0) {
              $lastId = intval(substr($result->fetchColumn(), 2));
          }
      
          $newId = "ST" . ($lastId + 1);
          return $newId;
      }
      
      
          function addStudio(studio $studio){
     try{
          $stmt = $this->conn->prepare("INSERT INTO studio values (:studioId,:studioName,:Address,:Phone,:Email)");
          $id = $this->createNewIDStudio();
          $name = $studio->get_StudioName();
          $address = $studio->get_Address();
          $phone = $studio->get_Phone();
          $email = $studio->get_Email();
          $stmt ->bindParam(':studioId',$id);
          $stmt ->bindParam(':studioName',$name);
          $stmt ->bindParam(':Address',$address);
          $stmt ->bindParam(':Phone',$phone);
          $stmt ->bindParam(':Email',$email);
          $stmt ->execute();
          
          return array("Success"=>true,"message"=>"Thêm thành công");
     }catch(Exception $e){

          return   array("Success"=>false,"error"=>$e->getMessage());
          
          
               
          }}    
          function getStudioByID($studid){
               $stmt = $this->conn->prepare("SELECT* FROM Studio WHERE StudioID = :studid");
               $stmt ->bindParam(':studid',$studid);
               $stmt ->setFetchMode(PDO::FETCH_CLASS,'Studio');
               $stmt ->execute();
               $studio = $stmt->fetchObject();
               if($studio!=null) {
               return array('success' => true, 'studio'=>$studio);
               }else{
               return array('success' => false,'message'=>"Studio not found");

               }

          }
          function removeStudio($id){
               try{
                    $stmt = $this->conn->prepare("DELETE FROM studio WHERE StudioId = :id");
                    $stmt ->bindParam(":id",$id);
                    $stmt ->execute();
                    if ($stmt->rowCount() > 0) {
                         return array("success" => true);
                     } else {
                         return array("success" => false, "error" => "Studio không tồn tại");
                     
               }}catch(EXception $e)
        {
          return array("success" => false, "error" => $e->getMessage());

               }
          }    
          function updateStudio(Studio $studio){
               try {
                    $stmt = $this->conn->prepare("UPDATE Studio SET 
                    StudioName = :name,
                    Address = :address,
                    Email = :email,
                    Phone = :phone
                    WHERE StudioID =:id
                    ");
               $id = $studio->get_StudioID();
               $name = $studio->get_StudioName();
               $address = $studio->get_Address();
               $phone = $studio->get_Phone();
               $email = $studio->get_Email();  
               $stmt ->bindParam(':name',$name);
               $stmt ->bindParam(':address',$address);
               $stmt ->bindParam(':phone',$phone);
               $stmt ->bindParam(':email',$email);
               $stmt->bindParam(':id',$id);
               $stmt ->execute();
               if ($stmt->rowCount() > 0) {
                    return array("success" => true);
                } else {
                    return array("success" => false, "error" => "Studio không tồn tại");
                
          }
          }catch(Exception $e){
               return array("success"=>false, "error"=>$e->getMessage());
          }

          }

     }
  

 
?>