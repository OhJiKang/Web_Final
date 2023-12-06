<?php
require_once(__DIR__.'/../System/Database.php');
require_once(__DIR__.'/../entity/ActorOfMovie.php');
class ActorModel{
    public $conn;
    public function __construct(){
        $this->conn = Database::getConnection();
    }
    public function getActorOfMovie($movieid){
        $stmt = $this->conn->prepare("SELECT ActorID, NameActor, MovieID FROM actorof_movie WHERE MovieID = :movieid");
        $stmt->bindParam(":movieid", $movieid);
        $stmt->execute();
        $actors = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $actor = new ActorOfMovie($row['NameActor'], $row['MovieID'], $row['ActorID']);
            $actors[] = $actor;
        }
        return ( $actors);
    }
    private function createNewID(){
        $query = "SELECT ActorID FROM actorof_movie ORDER BY CAST(RIGHT(ActorID, LENGTH(ActorID) - 1) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 1));
        }
    
        $newId = "A" . ($lastId + 1);
        return $newId;
    }
    
    public function updateActorOfMovie(ActorOfMovie $actor){
        try {
            $stmt = $this->conn->prepare("UPDATE actorof_movie SET NameActor = :name WHERE ActorID =:id ");
       $id = $actor->get_ActorID();
       $name = $actor->get_NameActor();
       
       $stmt ->bindParam(':name',$name);
    
       $stmt->bindParam(':id',$id);
       $stmt ->execute();
       if ($stmt->rowCount() > 0) {
        return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Actor không tồn tại"));
        
  }
  }catch(Exception $e){
    return (array("success"=>false, "error"=>$e->getMessage()));
  }

  }

    
    public function addActorOfMovie(ActorOfMovie $actor){
        try {
            $stmt = $this->conn->prepare("INSERT INTO actorof_movie (ActorID,NameActor, MovieID ) VALUES(:id,:name,:idmovie)");
            $id = $this->createNewID();
            $name = $actor->get_NameActor();
            $movie = $actor->get_MovieID();
            $stmt ->bindParam(":id",$id);
            $stmt ->bindParam(":name",$name);
            $stmt -> bindParam(":idmovie",$movie);
            $stmt->execute();

            if($stmt->rowCount()>0){
                return (array("success"=>true,"message"=>"Thêm thành công"));
            }else{
                return (array("success"=>false,"message"=>"Thêm thất bại"));

            }
        }catch (Exception $e) {
            return (array("success" => false, "error" => $e->getMessage()));
        }
    }
    public function deleteActorOfMovie($actorid){
      try{  $stmt = $this->conn->prepare("DELETE FROM actorof_movie where ActorID = :actorId");
        $stmt ->bindParam(":actorId",$actorid);
        $stmt ->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Actor không tồn tại"));
        }}catch (Exception $e) {
            return (array("success" => false, "error" => $e->getMessage()));
        }
    }
    
}
$temp = new ActorOfMovie("Temperat423ure","M002","A11");
(new ActorModel())->deleteActorOfMovie("A10");
?>