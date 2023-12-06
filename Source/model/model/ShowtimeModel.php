<?php 
require_once(__DIR__.'/../entity/Showtime.php');
require_once(__DIR__.'/../System/Database.php');

class ShowtimeModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin Showtime theo ID
    public function getShowtimeByID($ShowtimeID) {
        try {
            $query = "SELECT Price, StartTime, MovieID, EndTime, RoomID, FormatID, ShowtimeID FROM showtime WHERE ShowtimeID = :ShowtimeID";
    
           
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ShowtimeID', $ShowtimeID);
    
         
    
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Showtime');
            $stmt->execute();
            $Showtime = $stmt->fetchObject();
    
            if ($Showtime !== null) {
                return array("success"=>true,"Showtime"=>$Showtime);
            } else {
                return array("success"=>false,"error"=>"Showtime không tồn tại");
            }
        } catch (PDOException $e) {
            return array("success"=>false,"error"=>"Lỗi truy vấn: ".$e->getMessage());
        }
    }
    
    
    // Phương thức thêm mới một Showtime
    public function addShowtime(Showtime $Showtime){
        try{
            $this->conn->beginTransaction();
    
            // Kiểm tra xem có showtime khác trong khoảng thời gian và phòng chiếu tương tự hay không
            $stmt = $this->conn->prepare("SELECT ShowtimeID FROM showtime WHERE RoomID = :RoomID AND ((StartTime <= :StartTime AND EndTime >= :StartTime) OR (StartTime <= :EndTime AND EndTime >= :EndTime))");
            $StartTime = $Showtime->get_StartTime();
            $EndTime = $Showtime->get_EndTime();
            $RoomID = $Showtime->get_RoomID();
            $stmt->bindParam(':StartTime', $StartTime);
            $stmt->bindParam(':EndTime', $EndTime);
            $stmt->bindParam(':RoomID', $RoomID);
            $stmt->execute();
            $result = $stmt->fetch();
    
            if ($result) {
                // Nếu tìm thấy showtime khác thì hủy bỏ thêm mới và trả về kết quả với thông báo lỗi
                return (array("success"=>false,"error"=>"Không thể thêm mới showtime do đã tồn tại showtime khác trong khoảng thời gian và phòng chiếu tương tự"));
            } else {
                // Nếu không tìm thấy showtime khác thì thêm mới showtime
                $stmt = $this->conn->prepare("INSERT INTO showtime (ShowtimeID, Price, StartTime, EndTime, MovieID, RoomID, FormatID) VALUES (:ShowtimeID, :Price, :StartTime, :EndTime, :MovieID, :RoomID, :FormatID)");
                $ShowtimeID = $this->createNewID();
                $Price = $Showtime->get_Price();
                $StartTime = $Showtime->get_StartTime();
                $EndTime = $Showtime->get_EndTime();
                $MovieID = $Showtime->get_MovieID();
                $RoomID = $Showtime->get_RoomID();
                $FormatID = $Showtime->get_FormatID();
    
                $stmt->bindParam(':ShowtimeID', $ShowtimeID);
                $stmt->bindParam(':Price', $Price);
                $stmt->bindParam(':StartTime', $StartTime);
                $stmt->bindParam(':EndTime', $EndTime);
                $stmt->bindParam(':MovieID', $MovieID);
                $stmt->bindParam(':RoomID', $RoomID);
                $stmt->bindParam(':FormatID', $FormatID);
    
                $stmt->execute();
                $this->conn->commit();
                return (array("success"=>true));
            }
        }catch(Exception $e){
            $this->conn->rollBack();
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
     
    // Phương thức xóa một Showtime theo ID
public function deleteShowtime($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM showtime WHERE ShowtimeID = :ShowtimeID");
        $stmt->bindParam(':ShowtimeID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Showtime không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Showtime
public function updateShowtime(Showtime $Showtime) {
    try {
        $stmt =$this->conn->prepare("UPDATE showtime SET Price = :Price, FormatID = :FormatID, StartTime = :StartTime, EndTime = :EndTime, MovieID = :MovieID, RoomID = :RoomID WHERE ShowtimeID=:ShowtimeID");
        $ShowtimeID = $Showtime->get_ShowtimeID();
        $Price = $Showtime->get_Price();
        $StartTime = $Showtime->get_StartTime();
        $EndTime = $Showtime->get_EndTime();
        $MovieID = $Showtime->get_MovieID();
        $RoomID = $Showtime->get_RoomID();
        $FormatID = $Showtime->get_FormatID();


        $stmt->bindParam(':ShowtimeID', $ShowtimeID);
        $stmt->bindParam(':Price', $Price);
        $stmt->bindParam(':StartTime', $StartTime);
        $stmt->bindParam(':EndTime', $EndTime);
        $stmt->bindParam(':MovieID', $MovieID);
        $stmt->bindParam(':RoomID', $RoomID);
        $stmt->bindParam(':FormatID', $FormatID);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Showtime không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}


    // Phương thức getAll cho Showtime
    public function getAllShowtime($page) {
        try {
            $page = intval($page); 
            $number = 12;
            $offset = ($page - 1) * $number;
            $query = "SELECT Price, MovieID, StartTime, EndTime, RoomID, FormatID, ShowtimeID FROM showtime ORDER By StartTime DESC LIMIT $offset , $number ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $Showtimes = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $Showtime = new Showtime( $row['Price'], $row['StartTime'],$row['MovieID'] , $row['EndTime'], $row['RoomID'], $row['FormatID'], $row['ShowtimeID']);
                $Showtimes[] = $Showtime;
            }   
            if ($Showtimes !== null) {
                return array("success"=>true,"ShowtimeList"=>$Showtimes);
            } else {
                return array("success"=>false,"error"=>"Không tìm thấy Showtime");
            }
        } catch (PDOException $e) {
            return array("success"=>false,"error"=>"Lỗi truy vấn: ".$e->getMessage());
        }
    }
    
    public function getShowtimesByMovieIDandTheater($movieID, $theater, $date=null) {
        $query = "SELECT s.ShowtimeID, s.Price, s.StartTime, s.EndTime, r.RoomID, s.FormatID
            FROM Showtime s
            JOIN Room r ON s.RoomID = r.RoomID
            WHERE s.MovieID = :MovieID AND r.TheaterID = :TheaterID
          ";
    
        if ($date !== null) {
            $query .= " AND DATE(s.StartTime) = :date";
        }
        $query .="  ORDER BY s.StartTime DESC";
        $stmt = $this->conn->prepare($query);
        $stmt ->bindParam(":MovieID",$movieID);
        $stmt ->bindParam(":TheaterID",$theater);
        
        if ($date !== null) {
            $stmt->bindParam(':date', $date);
        }
        
        $stmt->execute();
        $Showtimes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Showtime = new Showtime( $row['Price'], $row['StartTime'], $movieID, $row['EndTime'], $row['RoomID'], $row['FormatID'], $row['ShowtimeID']);
            $Showtimes[] = $Showtime;
        }   
        return (array("success" => true, "list" => $Showtimes));
    }
    public function getShowtimesByTheaterAndDate($theater, $date){
        $query = "SELECT s.ShowtimeID, s.Price, s.StartTime, s.EndTime, r.RoomID, s.FormatID,s.MovieID, s.ShowtimeID
            FROM Showtime s
            JOIN Room r ON s.RoomID = r.RoomID
            Where r.TheaterID = :TheaterID AND DATE(s.StartTime) = :date
            ORDER BY s.StartTime DESC
            " ;
    
       
        $stmt = $this->conn->prepare($query);
        $stmt ->bindParam(":TheaterID",$theater);
        $stmt->bindParam(':date', $date);

        $stmt->execute();
        $Showtimes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Showtime = new Showtime( $row['Price'], $row['StartTime'], $row['MovieID']  , $row['EndTime'], $row['RoomID'], $row['FormatID'], $row['ShowtimeID']);
            $Showtimes[] = $Showtime;
        }
        
        return (array("success" => true, "list" => $Showtimes));
    }
    public function getShowtimesByDateandGenre( $date,$GenreID){
        $query = "SELECT s.ShowtimeID, s.Price, s.StartTime, s.EndTime, r.RoomID, s.FormatID,s.MovieID , dg.GenreID
        FROM Showtime s
        JOIN Room r ON s.RoomID = r.RoomID 
        JOIN Movie m On m.MovieID = s.MovieID
        JOIN detailmoviegenre dg  On dg.MovieID = m.MovieID  
            WHERE  DATE(s.StartTime) = :date and dg.GenreID = :GenreID
            ORDER BY s.StartTime DESC
            ";
    
     
    
        $stmt = $this->conn->prepare($query);
       
        
       
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':GenreID', $GenreID);
     
        
        $stmt->execute();
        $Showtimes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Showtime = new Showtime( $row['Price'], $row['StartTime'], $row['MovieID'], $row['EndTime'], $row['RoomID'], $row['FormatID'], $row['ShowtimeID']);
    
            $Showtimes[] = $Showtime;
        }
        
        return (array("success" => true, "list" => $Showtimes));
    }
    public function getShowtimesByDate( $date){
        $query = "SELECT s.ShowtimeID, s.Price, s.StartTime, s.EndTime, r.RoomID, s.FormatID,s.MovieID
            FROM Showtime s
            JOIN Room r ON s.RoomID = r.RoomID
            WHERE  DATE(s.StartTime) = :date";
    
     
    
        $stmt = $this->conn->prepare($query);
       
        
       
            $stmt->bindParam(':date', $date);
     
        
        $stmt->execute();
        $Showtimes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Showtime = new Showtime( $row['Price'], $row['StartTime'], $row['MovieID'], $row['EndTime'], $row['RoomID'], $row['FormatID'], $row['ShowtimeID']);
    
            $Showtimes[] = $Showtime;
        }
        
        return (array("success" => true, "list" => $Showtimes));
    }
    
     public function getAllShowtimeByMovieID($moiveid, $date = null){
        $query = "SELECT ShowtimeID, Price, MovieID, StartTime, EndTime, RoomID, FormatID FROM showtime WHERE MovieID = :MovieID";
        if ($date !== null) {
            $query .= " AND DATE(StartTime) = :date";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":MovieID", $moiveid);
        if ($date !== null) {
            $stmt->bindParam(':date', $date);
        }
        $stmt->execute();
        $Showtimes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Showtime = new Showtime($row['Price'], $row['StartTime'], $row['MovieID'], $row['EndTime'], $row['RoomID'], $row['FormatID'], $row['ShowtimeID']);
            $Showtimes[] = $Showtime;
        }
        return array("success" => true, "list" => $Showtimes);
    }
    
    
        // Phương thức sinh mã ID mới cho Showtime
        public function createNewID() {
            $query = "SELECT ShowtimeID FROM showtime ORDER BY CAST(RIGHT(ShowtimeID, LENGTH(ShowtimeID) - 2) AS UNSIGNED) DESC LIMIT 1";
            $result = $this->conn->query($query);
            $lastId = 0;
        
            if ($result->rowCount() > 0) {
                $lastId = intval(substr($result->fetchColumn(), 2));
            }
        
            $newId = "SH" . ($lastId + 1);
            return $newId;
        }
}
$temp = new Showtime(10000, '2022-10-10 10:10:10','M001', '2022-10-10 11:11:11', 'RO001', 'F001', 'SH001');



?>