<?php 

require_once(__DIR__.'/../entity/Promotion.php');
require_once(__DIR__.'/../entity/Movie.php');
require_once(__DIR__.'/../entity/Theater.php');
require_once(__DIR__.'/../System/Database.php');
class StatisticModel{
    private $conn;
    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }
    public function getRevenueForDate($date=null,$page=1){
        try{
            $per_page = 10;
            $offset = ($page -1)* $per_page;
            $sql = "SELECT SUM(TotalPrice) AS DailyRevenue, Date(BookingTime) as Day
            FROM booking";
            if($date!=null){
                $sql.= " WHERE Date(BookingTime) =:date";
            }
            $sql.="
            GROUP BY DATE(BookingTime)
            ORDER BY DATE(BookingTime) Desc
            Limit :offset,:per_page";
            

            $stmt = $this->conn->prepare( $sql );
            if($date!=null){
                $stmt ->bindParam(":date", $date,PDO::PARAM_STR);

            }
            $stmt ->bindParam(":offset", $offset,PDO::PARAM_INT);
            $stmt ->bindParam(":per_page", $per_page,PDO::PARAM_INT);

            $stmt ->execute();
            $list = array();
           
            while ($row=$stmt->fetch(\PDO::FETCH_ASSOC)){
            $list[] =  array("DailyRevenue" =>$row['DailyRevenue'], "Day" =>$row['Day']);
            
             }
             return array("success"=>true , "list"=>$list);
        }catch( Exception $e){
            return array("success"=>false , "error"=>$e->getMessage());
        }
     }
     public function getRevenueForMonth($year=null, $month=null,$page = 1) {
        try {
            $per_page = 10;
            $offset = ($page -1)* $per_page;
            $sql = "SELECT SUM(TotalPrice) AS MonthlyRevenue, DATE_FORMAT(BookingTime, '%Y-%m') AS Month
            FROM booking";
                  
    if($year!=null && $month!=null){
        $sql.= " WHERE YEAR(BookingTime) = :year AND MONTH(BookingTime) = :month ";
    }
    $sql.=" GROUP BY DATE_FORMAT(BookingTime, '%Y-%m')
            ORDER BY DATE_FORMAT(BookingTime, '%Y-%m') DESC
            LIMIT :offset,:per_page";
    
            $stmt = $this->conn->prepare($sql);
            if($year!=null && $month!=null){
            $stmt->bindParam(":year", $year, PDO::PARAM_INT);
            $stmt->bindParam(":month", $month, PDO::PARAM_INT);
            }
            $stmt ->bindParam(":offset", $offset,PDO::PARAM_INT);
            $stmt ->bindParam(":per_page", $per_page,PDO::PARAM_INT);

            $stmt->execute();
    
            $list = array();
           
            while ($row=$stmt->fetch(\PDO::FETCH_ASSOC)){
            $list[] =  array( "MonthlyRevenue" =>$row['MonthlyRevenue'], "Month" =>$row['Month']);
            
             }
             return array("success"=>true , "list"=>$list);
        } catch (Exception $e) {
            return array("success" => false, "error" => $e->getMessage());
        }
    }
    
    public function getRevenueForYear($year=null,$page =1 ) {
        try {
            $sql = "SELECT SUM(TotalPrice) AS YearlyRevenue, YEAR(BookingTime) AS Year
                    FROM booking ";
                      $per_page = 10;
                      $offset = ($page -1)* $per_page;
                if($year!=null){
                    $sql.=   " WHERE YEAR(BookingTime) = :year ";

                }              
                $sql.= " GROUP BY YEAR(BookingTime)
                         ORDER BY YearlyRevenue Desc 
                         Limit :offset,:per_page ";
            $stmt = $this->conn->prepare($sql);
            if($year!=null){
                $stmt->bindParam(":year", $year, PDO::PARAM_INT);
            }
            $stmt ->bindParam(":offset", $offset,PDO::PARAM_INT);
            $stmt ->bindParam(":per_page", $per_page,PDO::PARAM_INT);
    
            $stmt->execute();
            $list = array();
           
            while ($row=$stmt->fetch(\PDO::FETCH_ASSOC)){
            $list[] =  array("YearlyRevenue" => $row['YearlyRevenue'], "Year" => $row['Year']);
            
            }
    
            return array("success" => true, "List" => $list);
        } catch (Exception $e) {
            return array("success" => false, "error" => $e->getMessage());
        }
    }
    
    public function getRevenueForQuarterOfYear($year = null, $quarter = null, $page = 1) {
        try {
            $per_page = 10;
            $offset = ($page - 1) * $per_page;
    
            $sql = "SELECT SUM(TotalPrice) AS QuarterlyRevenue, QUARTER(BookingTime) AS Quarter, YEAR(BookingTime) AS Year
                    FROM booking";
    
            if ($year != null && $quarter != null) {
                $sql .= " WHERE YEAR(BookingTime) = :year AND QUARTER(BookingTime) = :quarter";
            }
    
            $sql .= " GROUP BY QUARTER(BookingTime), YEAR(BookingTime)
                      ORDER BY QuarterlyRevenue DESC LIMIT :offset, :per_page";
    
            $stmt = $this->conn->prepare($sql);
    
            if ($year != null && $quarter != null) {
                $stmt->bindParam(":year", $year, PDO::PARAM_INT);
                $stmt->bindParam(":quarter", $quarter, PDO::PARAM_INT);
            }
    
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
            $stmt->bindParam(":per_page", $per_page, PDO::PARAM_INT);
            $stmt->execute();
    
            $list = array();
    
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $list[] = array(
                    "QuarterlyRevenue" => $row['QuarterlyRevenue'],
                    "Quarter" => $row['Quarter'],
                    "Year" => $row['Year']
                );
            }
    
            return array("success" => true, "List" => $list);
        } catch (Exception $e) {
            return array("success" => false, "error" => $e->getMessage());
        }
    }
    
    
    public function getTopHighestGrossingMovie($page, $date, $timeframe) {
        try {
            $perPage = 10;
            $offset = ($page - 1) * $perPage;
    
            switch ($timeframe) {
                case 'day':
                    $groupBy = 'DATE(b.BookingTime)';
                    $dateFormat = '%Y-%m-%d';
                    break;
                case 'month':
                    $groupBy = 'MONTH(b.BookingTime), YEAR(b.BookingTime)';
                    $dateFormat = '%Y-%m';
                    break;
                case 'year':
                    $groupBy = 'YEAR(b.BookingTime)';
                    $dateFormat = '%Y';
                    break;
               
                default:
                    return array("success" => false, "error" => "Invalid timeframe");
            }
    
            $sql = "SELECT SUM(IF(seat.type = 1, showtime.Price, showtime.Price * 2)) AS TotalRevenue ,Movie.*, DATE_FORMAT(b.BookingTime, :dateFormat) as Timeframe
                FROM ticket
                JOIN detailticket ON ticket.TicketID = detailticket.TicketID
                JOIN seat ON ticket.SeatID = seat.SeatID
                JOIN showtime ON ticket.ShowTimeID = showtime.ShowTimeID
                JOIN Movie ON Movie.MovieID = showtime.MovieID
                JOIN booking AS b ON b.BookingID = detailticket.BookingID
                where DATE_FORMAT(b.BookingTime, :dateFormat) = :date
                GROUP BY Movie.MovieID, Timeframe 
                ORDER BY TotalRevenue DESC
                LIMIT :perPage OFFSET :offset";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':dateFormat', $dateFormat);
            $stmt->execute();
    
            $list = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $temp['movie'] = new Movie(
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
                $temp['TotalRevenue'] = $row['TotalRevenue'];
                $temp['Timeframe'] = $timeframe;
                $list[] = $temp;
            }
            return array("success" => true, "list" => $list);
        } catch (Exception $e) {
            return array("success" => false, "error" => $e->getMessage());
        }
    }
    
  
    public function getTopHighestGrossingTheater($page, $date, $timeframe) {
        try {
            $perPage = 10;
            $offset = ($page - 1) * $perPage;
    
            switch ($timeframe) {
                case 'day':
                    $groupBy = 'DATE(b.BookingTime)';
                    $dateFormat = '%Y-%m-%d';
                    break;
                case 'month':
                    $groupBy = 'MONTH(b.BookingTime), YEAR(b.BookingTime)';
                    $dateFormat = '%Y-%m';
                    break;
                case 'year':
                    $groupBy = 'YEAR(b.BookingTime)';
                    $dateFormat = '%Y';
                    break;
                default:
                    return array("success" => false, "error" => "Invalid timeframe");
            }
          
            $sql = "SELECT SUM(booking.TotalPrice) as Total, theater.*, DATE_FORMAT(booking.BookingTime, :dateFormat) as Timeframe
                FROM booking
                JOIN detailticket on detailticket.BookingID = booking.BookingID
                JOIN ticket on ticket.TicketID = detailticket.TicketID 
                JOIN showtime on showtime.ShowtimeID = ticket.ShowTimeID
                JOIN room on room.RoomID = showtime.RoomID
                JOIN theater on theater.TheaterID = room.TheaterID
                WHERE DATE_FORMAT(booking.BookingTime, :dateFormat) = :date
                GROUP BY theater.TheaterName, Timeframe
                ORDER BY Total DESC
                LIMIT :perPage OFFSET :offset";
         
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':dateFormat', $dateFormat);
            $stmt->execute();
    
            $list = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $temp['theater'] = new Theater( $row['TheaterName'], $row['Address'], $row['Phone'], $row['NumberOfRooms'],$row['TheaterID']);
                $temp['TotalRevenue'] = $row['Total'];
                $temp['Timeframe'] = $timeframe;
                $list[] = $temp;
            }
            return array("success" => true, "list" => $list);
        } catch (Exception $e) {
            return array("success" => false, "error" => $e->getMessage());
        }
    }
    
}
?>