<?php
require_once(__DIR__.'/../entity/MovieGenre.php');
require_once(__DIR__.'/../System/Database.php');
# create class MovieGenreModel
 class MovieGenreModel {
     private $conn;
     public function __construct(){
         $this->conn = Database::getConnection();
     }
     private function createNewGenreID(){
        $query = "SELECT GenreID FROM moviegenre ORDER BY CAST(RIGHT(GenreID, LENGTH(GenreID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "GE" . ($lastId + 1);
        return $newId;
    }
    public function getGenreAllByMoiveID($moive){
        try {
            $query = $this->conn->prepare("Select mg.* from detailmoviegenre as dt , moviegenre as mg where  dt.MovieID = :moive and dt.GenreID = mg.GenreID");
            $query->bindParam(':moive', $moive);
            $query->execute();
    
            $genres = array();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $genre = new MovieGenre($row['GenreName'], $row['Description'], $row['GenreID']);
                $genres[] = $genre;
            }
            return $genres;
        }catch(Exception $e){
        return (array("success"=>false,"error"=>$e->getMessage()));

        }
        }
        public function getGenreAll($page) {
            $limit = 10; 
            $offset = ($page - 1) * $limit; 
        
           
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM moviegenre");
            $stmt->execute();
            $total = $stmt->fetchColumn();
        
           
            $num_pages = ceil($total / $limit);
        
            
            $query = "SELECT GenreID, GenreName, Description FROM moviegenre LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
        
            $genres = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $genre = new MovieGenre($row['GenreName'], $row['Description'], $row['GenreID']);
                $genres[] = $genre;
            }
            return array(
                'genres' => $genres,
                'pagination' => array(
                    'total' => $total,
                    'limit' => $limit,
                    'num_pages' => $num_pages,
                    'current_page' => $page,
                ),
            );
        }
        
    
    public function getGenreByID($id) {
     try{
        $stmt = $this->conn->prepare("SELECT  GenreID, GenreName, Description		 FROM moviegenre WHERE GenreID =:GenreID");
        $stmt->bindParam(':GenreID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'MovieGenre');
        $stmt->execute();
        $genre = $stmt->fetchObject();
        if($genre!=null){
            return (array("success"=>true,"genre"=>$genre));
        }else{
            return (array("success"=>false,"error"=>"Thê loại này không tồn tại"));
        }
     }catch(\PDOException $e){
        return (array("success"=>false,"error"=>$e->getMessage()));
     }


    }
    public function addGenre(MovieGenre $genre) {
    try{    $stmt = $this->conn->prepare("INSERT INTO moviegenre (GenreName, Description, GenreID) VALUES (:GenreName, :Description, :GenreID)");
      $id = $this ->createNewGenreID();
      $name = $genre->get_GenreName();
      $description = $genre->get_Description();
        $stmt->bindParam(':GenreName', $name);
        $stmt->bindParam(':Description', $description);
        $stmt->bindParam(':GenreID', $id);
        $stmt->execute();
        return (array("success"=>true));
    }catch(Exception $e){
        return (array("success"=>false,"error"=>$e->getMessage()));
     }
    }

    public function deleteGenreById($id){
        try{ $stmt = $this->conn->prepare("DELETE FROM moviegenre WHERE GenreID= :GenreID");
        $stmt -> bindParam(':GenreID', $id);
        $stmt->execute(); 
        if($stmt ->rowCount() > 0){
            return (array("success"=>true));
        }else{ return (array("success"=>false , "message"=>"Could not delete Genre")); }}
        catch(Exception $e){ return (array("success"=>false , "error"=>$e->getMessage())); }

    }
    public function updateGenre(MovieGenre $genre) {
        try {
            $stmt = $this->conn->prepare("UPDATE moviegenre SET GenreName = :GenreName, Description = :Description WHERE GenreID = :GenreID");
            $id = $genre ->get_GenreID();
            $name = $genre->get_GenreName();
            $description = $genre->get_Description();
            $stmt->bindParam(':GenreID', $id);
            $stmt->bindParam(':GenreName', $name);
            $stmt->bindParam(':Description', $description);
            $stmt->execute();
            if($stmt ->rowCount() > 0){
                return (array("success"=>true));
            }else{ return (array("success"=>false , "message"=>"Could not update Genre")); }
        }catch(Exception $e){
             return (array("success"=>false , "error"=>$e->getMessage()));
             }
            }
}

 
?>