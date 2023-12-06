<?php
require_once(__DIR__.'/../entity/MovieImage.php');
require_once(__DIR__.'/../System/Database.php');
class MovieImageModel{
    private $conn; 
    public function __construct(){
        $this->conn = Database::getConnection();
    }
    private function createNewImageID(){
        $query = "SELECT ImageID FROM movieimage ORDER BY CAST(RIGHT(ImageID, LENGTH(ImageID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "MI" . ($lastId + 1);
        return $newId;
    }
    public function deleteImage( $movieImageid){
        try {
            $stmt = $this->conn->prepare("DELETE FROM movieimage where ImageID = $movieImageid"); 
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (array("success" => true));
            } else {
                return (array("success" => false, "error" => "image không tồn tại"));
        }}catch(Exception $e){
            return (array("success" => false, "message" => $e->getMessage()));
        }
    }

    public function getMoiveImageID($id){
   
        $stmt = $this->conn->prepare("SELECT ImageID, MovieID , ImagePath,type FROM movieimage WHERE MovieID = :id");
        $stmt->bindParam(":id", $id);
         $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->execute();
        $images  = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $image = new MovieImage($row['ImagePath'], $row['MovieID'],$row['type'], $row['ImageID']);
            $images[] = $image;
        }
        return json_encode(array("listImages" => $images));
       
    }
    public function uppdateImageMoive(MovieImage $moiveimage){
        try {   
        $stmt = $this->conn ->prepare("UPDATE movieimage SET ImagePath = :imagePath, MovieID = :movieID where MovieID = :movieID");
        $id = $moiveimage->get_ImageID();
        $ImagePath = $moiveimage->get_ImagePath(); 
        $movie = $moiveimage->get_MovieID(); 
     
        $stmt->bindParam(":imagePath", $ImagePath);
        $stmt->bindParam(":movie", $movie);

        $stmt -> bindParam(":movieID", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "image không tồn tại"));
        }} catch(Exception $e){
            return (array("success" => false, "message" => $e->getMessage()));
        }
        }
    
    public function addMoiveImage(MovieImage $movieImage){
        try {
            $stmt = $this->conn->prepare("INSERT INTO movieimage (MovieID, ImagePath,ImageID,type) VALUES(:movieID,:ImagePath, :ImageID,:type)");
            $id = $this ->createNewImageID();
            $moiveid = $movieImage ->get_MovieID();
            $type  = $movieImage ->getType();
            $image = $movieImage->get_ImagePath();
            $stmt->bindParam(":movieID", $moiveid);
        
            $stmt -> bindParam(":ImagePath", $image );
            $stmt -> bindParam(":ImageID", $id );
            $stmt -> bindParam(":type", $type );
            $stmt ->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

            
        }catch(Exception $e){ 
            return false;
        }
    }
}

?>