<?php
require_once(__DIR__.'/../entity/Movie.php');
require_once(__DIR__.'/../entity/detailmoviegenre.php');
require_once(__DIR__.'/../System/Database.php'); 
require_once(__DIR__.'/LanguageModel.php');
require_once(__DIR__.'/MovieGenreModel.php');
require_once(__DIR__.'/ActorModel.php');
require_once(__DIR__.'/StudioModel.php');
require_once(__DIR__.'/../entity/Format.php');
require_once(__DIR__.'/MovieImageModel.php');

class MovieModel{
    public $conn;
    
    public function __construct() {
        $this->conn = Database::getConnection();
    }
    public function getMovieById($id) {
        $sql = "SELECT MovieID, MovieName, Director, Year, Premiere, URLTrailer, Time, StudioID, LanguageID ,story,age FROM movie WHERE MovieID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result) {
            $row = new Movie(
                $result['MovieName'],
                $result['Year'],
                $result['Director'],
                $result['Premiere'],
                $result['URLTrailer'],
                $result['Time'],
                $result['StudioID'],
                $result['LanguageID'],
                $result['story'],
                $result['age'],
                $result['MovieID']
            );
            return array("success"=>true,"movie"=>$row);
        } else {
            return array("success" => false, "message" => "Không tìm thấy phim với ID này");
        }
    }
    
    
    public function getMoviesAll($page) {
        $page = intval($page); 
        $number = 12;
        $offset = ($page - 1) * $number;
        $sql = "SELECT 
            MovieID,
            MovieName,
            Director,
            Year,
            Premiere,
            URLTrailer,
            Time,
            StudioID,
            story,
            age,

            LanguageID 
        FROM `movie` 
        ORDER BY CAST(RIGHT(MovieID, LENGTH(MovieID) - 2) AS UNSIGNED) DESC 
        LIMIT $offset,$number";
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();
        $listmovie = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp = new Movie(
                $row['MovieName'],
                $row['Year'],
                $row['Director'],
                $row['Premiere'],
                $row['URLTrailer'],
                $row['Time'],
                $row['StudioID'],
                $row['LanguageID'],
                $row['story'],
                $row['age'],

                $row['MovieID']
            );
          
            $listmovie[] = $temp;
        }
        return ( $listmovie);
    }
    
    private function createNewID(){
        $query = "SELECT MovieID FROM movie ORDER BY CAST(RIGHT(MovieID, LENGTH(MovieID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $lastId = 0;
    
        if ($stmt->rowCount() > 0) {
            $lastId = intval(substr($stmt->fetchColumn(), 2));
        }
    
        $newId = "MV" . ($lastId + 1);
        return $newId;
    }
    public function getPremieredMovies($page) {
        $page = intval($page); 
        $number = 12;
        $offset = ($page - 1) * $number;
        $sql = "SELECT 
            MovieID,
            MovieName,
            Director,
            Year,
            Premiere,
            URLTrailer,
            Time,
            StudioID,
            story,
            age,

            LanguageID 
        FROM `movie` 
        WHERE Premiere <= NOW() -- chỉ lấy những bộ phim đã được khởi chiếu
        ORDER BY CAST(RIGHT(MovieID, LENGTH(MovieID) - 2) AS UNSIGNED) DESC 
        LIMIT $offset,$number";
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();
        $listmovie = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp = new Movie(
                $row['MovieName'],
                $row['Year'],
                $row['Director'],
                $row['Premiere'],
                $row['URLTrailer'],
                $row['Time'],
                $row['StudioID'],
                $row['LanguageID'],
                $row['story'],
                $row['age'],

                $row['MovieID']
            );
          
            $listmovie[] = $temp;
        }
        return ( $listmovie);
    }
    public function getUpcomingMovies($page) {
        $page = intval($page); 
        $number = 12;
        $offset = ($page - 1) * $number;
        $sql = "SELECT 
            MovieID,
            MovieName,
            Director,
            Year,
            Premiere,
            URLTrailer,
            Time,
            StudioID,
            story,
            age,

            LanguageID 
        FROM `movie` 
        WHERE Premiere > NOW() -- chỉ lấy những bộ phim đã được khởi chiếu
        ORDER BY CAST(RIGHT(MovieID, LENGTH(MovieID) - 2) AS UNSIGNED) DESC 
        LIMIT $offset,$number";
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();
        $listmovie = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp = new Movie(
                $row['MovieName'],
                $row['Year'],
                $row['Director'],
                $row['Premiere'],
                $row['URLTrailer'],
                $row['Time'],
                $row['StudioID'],
                $row['LanguageID'],
                $row['story'],
                $row['age'],

                $row['MovieID']
            );
          
            $listmovie[] = $temp;
        }
        return ( $listmovie);
    }
    public function getHotMovies() {
     

    
        $sql = "SELECT 
            m.MovieID,
            m.MovieName,
            m.Director,
            m.Year,
            m.Premiere,
            m.URLTrailer,
            m.Time,
            s.StudioName,
            m.story,
            m.age,
            l.LanguageName
        FROM `movie` m
        INNER JOIN `studio` s ON m.StudioID = s.StudioID
        INNER JOIN `language` l ON m.LanguageID = l.LanguageID
        ORDER BY CAST(RIGHT(m.MovieID, LENGTH(m.MovieID) - 2) AS UNSIGNED)  DESC 
        LIMIT 5";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->execute();
        $listmovie = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp = new Movie(
                $row['MovieName'],
                $row['Year'],
                $row['Director'],
                $row['Premiere'],
                $row['URLTrailer'],
                $row['Time'],
                $row['StudioName'], 
                $row['LanguageName'],
                $row['story'],
                $row['age'],
               
                $row['MovieID']
            );
    
            $listmovie[] = $temp;

        }
        return ($listmovie);
    }
    public function getMoviesByGenre($genre, $page = 1 ) {
        $number_page = 12;
        $genre = htmlspecialchars(strip_tags($genre)); // Chống SQL injection
        $sql = "SELECT 
                    m.MovieID,
                    m.MovieName,
                    m.Director,
                    m.Year,
                    m.Premiere,
                    m.URLTrailer,
                    m.Time,
                    m.StudioID,
                    m.LanguageID ,
                    m.story,
                    m.age

                FROM 
                    movie m
                    INNER JOIN detailmoviegenre mg ON m.MovieID = mg.MovieID
                    INNER JOIN moviegenre g ON mg.GenreID = g.GenreID
                WHERE 
                    m.Premiere <= NOW() AND
                    g.GenreID = :genre
                ORDER BY 
                    m.Premiere DESC
                LIMIT :limit OFFSET :offset";
        $limit = $number_page;
        $offset = ($page - 1) * $number_page;
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $listmovie = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp = new Movie(
                $row['MovieName'],
                $row['Year'],
                $row['Director'],
                $row['Premiere'],
                $row['URLTrailer'],
                $row['Time'],
                $row['StudioID'],
                $row['LanguageID'],
                $row['story'],
                $row['age'],
                $row['MovieID']
            );
            $listmovie[] = $temp;
        }
        return $listmovie;
    
    }

    public function addGenreForMovie(DetailMovieGenre $db){
      try {
        $sql = "INSERT INTO `detailmoviegenre` (`MovieID`, `GenreID`) VALUES (:MovieID, :GenreID)";
        $stmt = $this->conn->prepare($sql);
        $movieid =  $db->get_MovieID();
        $genreid = $db->get_GenreID();
        $stmt->bindParam(':MovieID', $movieid);
        $stmt->bindParam(':GenreID', $genreid);
        $stmt->execute();
        if($stmt ->rowCount()>0){
            return true;
        }else{
            return  false;
        }
      }catch(PDOException $e){
        return false;
      }
    }
    public function deleteGenreForMovie(DetailMovieGenre $db){
        try {
            $sql = "DELETE FROM `detailmoviegenre` WHERE `MovieID` = :MovieID AND `GenreID` = :GenreID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MovieID', $db->get_MovieID());
            $stmt->bindParam(':GenreID', $db->get_GenreID());
            $stmt->execute();
            if($stmt ->rowCount()>0){
                return true;
            }else{
                return  false;
            }
        }catch(PDOException $e){
            return false;
        }
    }
    
    public function addMoive(Movie $moive){
        try {
            $stmt = $this->conn->prepare("INSERT INTO `movie`(`MovieID`, `MovieName`, `Director`, `Year`, `Premiere`, `URLTrailer`, `Time`, `StudioID`, `LanguageID`, `story`, `age`) 
            VALUES (:MovieID, :MovieName, :Director, :Year, :Premiere, :URLTrailer, :Time, :StudioID, :LanguageID, :story, :age)");
            
            $id = $this->createNewID();
            $moiveName = $moive->get_MovieName();
            $Diretor = $moive->get_Director();
            $year = $moive->get_Year(); 
            $premiere = $moive->get_Premiere(); 
            $urltrailer = $moive->get_URLTrailer();
            $time = $moive->get_Time();
            $studioid = $moive->get_StudioID(); 
            $languageid = $moive->get_LanguageID();
            $story = $moive->get_story();
            $age = $moive->getAge();
            $stmt->bindParam(':story', $story);
            $stmt->bindParam(':MovieID', $id);
            $stmt->bindParam(':MovieName', $moiveName);
            $stmt->bindParam(':Director', $Diretor);
            $stmt->bindParam(':Year', $year);
            $stmt->bindParam(':Premiere', $premiere);
            $stmt->bindParam(':URLTrailer', $urltrailer);
            $stmt->bindParam(':Time', $time);
            $stmt->bindParam(':StudioID', $studioid);
            $stmt->bindParam(':LanguageID', $languageid);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':story', $story);
    
            $stmt->execute();
            if($stmt->rowCount()>0){
                return (array("success" => true,"id"=>$id));
            }else{
                return (array("success" => false, "message" => "Could not add movie to database"));
            }
        } catch(PDOException $e) {
            return (array("success" => false, "message" => "Error: " . $e->getMessage()));
        }
    }
    
    public function searchMovie($search) {
        $search = "%{$search}%";
        $stmt = $this->conn->prepare("SELECT 
            MovieID,
            MovieName,
            Director,
            Year,
            Premiere,
            URLTrailer,
            Time,
            StudioID,
            age,
            story,
            LanguageID 
        FROM `movie`
        WHERE `MovieName` LIKE :search 
        ORDER BY `MovieID` DESC");
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        
        $listmoive = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $listmoive[] = new Movie(
                $row['MovieName'],
                $row['Year'],
                $row['Director'],
                $row['Premiere'],
                $row['URLTrailer'],
                $row['Time'],
                $row['StudioID'],
                $row['LanguageID'],
                $row['story'],
                $row['age'],
                $row['MovieID']
            );
        }
        return (array("listmoive" => $listmoive));
    }
    
    public function deleteMovie($movieId){
     try{  $this->conn->beginTransaction();
    
        // Thực hiện các truy vấn DELETE trên 3 bảng trong transaction
        $stmt1 = $this->conn->prepare("DELETE FROM detailmoviegenre WHERE MovieID = ?");
        $stmt1->execute([$movieId]);
        
        $stmt2 = $this->conn->prepare("DELETE FROM movieimage WHERE MovieID = ?");
        $stmt2->execute([$movieId]);
        
        $stmt3 = $this->conn->prepare("DELETE FROM showtime WHERE MovieID = ?");
        $stmt3->execute([$movieId]);
    
        // Nếu không có lỗi xảy ra, commit transaction
        $this->conn->commit();
        return (array("success" => true));      
        }catch(Exception $e){
            $this->conn->rollBack();
            return (array("success" => false,"error" => $e->getMessage()));
            
        }
    }
    public function updateMovie(Movie $movie){
            try {

            $stmt = $this->conn->prepare("UPDATE `movie` SET `MovieName`=:MovieName, `Director`=:Director,
             `Year`=:Year, `Premiere`=:Premiere, `URLTrailer`=:URLTrailer, `Time`=:time, `StudioID`=:StudioID, 
             `LanguageID`=:LanguageID ,story=:story,age=:age WHERE `MovieID`=:MovieID");

            $id = $movie->get_MovieID();      
            $movieName = $movie->get_MovieName();
            $director = $movie->get_Director();
            $year = $movie->get_Year(); 
            $premiere = $movie->get_Premiere(); 
            $urltrailer = $movie->get_URLTrailer();
            $studioid = $movie->get_StudioID(); 
            $languageid = $movie->get_LanguageID();
            $story = $movie->get_story();
            $age = $movie->getAge();
            $time = $movie->get_Time();

            $stmt->bindParam(':MovieID', $id);
            $stmt->bindParam(':MovieName', $movieName);
            $stmt->bindParam(':Director', $director);
            $stmt->bindParam(':Year', $year);
            $stmt->bindParam(':Premiere', $premiere);
            $stmt->bindParam(':URLTrailer', $urltrailer);
            $stmt->bindParam(':time', $time);
            $stmt->bindParam(':StudioID', $studioid);
            $stmt->bindParam(':story', $story);
            $stmt->bindParam(':LanguageID', $languageid);
            $stmt->bindParam(':age', $age);
    
            $stmt->execute();
            if($stmt ->rowCount()>0){
                return (array("success" => true));
            }else{
                return (array("success" => false,"message" => "Thêm thất bại"));
            }
            
        }catch(Exception $e){
            return (array("success" => false,"error" => $e->getMessage()));
            
        }
    }
    
}

?>
