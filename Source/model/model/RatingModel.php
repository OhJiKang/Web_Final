<?php 
require_once(__DIR__.'/../entity/Rating.php');
require_once(__DIR__.'/../System/Database.php');

class RatingModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    // Phương thức lấy thông tin Rating theo ID
    public function getRatingByID($id) {
        $stmt = $this->conn->prepare("SELECT RatingID, Score, Comment, Day, MovieID, CustomerID FROM rating WHERE RatingID=:RatingID");
        $stmt->bindParam(':RatingID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Rating');
        $stmt->execute();
        $Rating = $stmt->fetchObject();
        if($Rating!=null){
            return (array("success"=>true,"Rating"=>$Rating));
        }else{
            return (array("success"=>false,"error"=>"Rating không tồn tại"));
        }
    }
    
    // Phương thức thêm mới một Rating
    public function addRating(Rating $Rating){
        try{
            $stmt =$this->conn->prepare("INSERT INTO rating (RatingID, Score, Comment, Day, MovieID, CustomerID) VALUES (:RatingID, :Comment, :Day, :Score,:MovieID, :CustomerID)");
            $RatingID = $this->createNewID();
            $Score = $Rating->get_Score();
            $Comment = $Rating->get_Comment();
            $Day = $Rating->get_Day();
            $MovieID = $Rating->get_MovieID();
            $CustomerID = $Rating->get_CustomerID();

            $stmt->bindParam(':RatingID', $RatingID);
            $stmt->bindParam(':Score', $Score);
            $stmt->bindParam(':Comment', $Comment);
            $stmt->bindParam(':Day', $Day);
            $stmt->bindParam(':MovieID', $MovieID);
            $stmt->bindParam(':CustomerID', $CustomerID);

            $stmt ->execute();
            return (array("success"=>true));
        }catch(Exception $e){
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    // Phương thức xóa một Rating theo ID
public function deleteRating($id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM Rating WHERE RatingID = :RatingID");
        $stmt->bindParam(':RatingID', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Rating không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}
// Phương thức cập nhật thông tin một Rating
public function updateRating(Rating $Rating) {
    try {
        $stmt =$this->conn->prepare("UPDATE rating SET Score = :Score, Comment = :Comment, Day = :Day, MovieID = :MovieID, CustomerID = :CustomerID WHERE RatingID=:RatingID");
        $RatingID = $Rating->get_RatingID();
        $Score = $Rating->get_Score();
        $Comment = $Rating->get_Comment();
        $Day = $Rating->get_Day();
        $MovieID = $Rating->get_MovieID();
        $CustomerID = $Rating->get_CustomerID();

        $stmt->bindParam(':RatingID', $RatingID);
        $stmt->bindParam(':Score', $Score);
        $stmt->bindParam(':Comment', $Comment);
        $stmt->bindParam(':Day', $Day);
        $stmt->bindParam(':MovieID', $MovieID);
        $stmt->bindParam(':CustomerID', $CustomerID);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return (array("success" => true));
        } else {
            return (array("success" => false, "error" => "Rating không tồn tại"));
        }
    } catch (Exception $e) {
        return (array("success" => false, "error" => $e->getMessage()));
    }
}

    // Phương thức getAll cho Rating
public function getAllRating($page){
    $page = intval($page); 
    $number = 12;
    $offset = ($page - 1) * $number;
    $stmt = $this->conn->prepare("SELECT RatingID, Score,  Comment, Day,  MovieID, CustomerID FROM rating  ORDer by Day desc limit $offset , $number");
    $stmt->execute();
    $Ratings = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Rating = new Rating($row['Score'], $row['Day'], $row['Comment'], $row['MovieID'], $row['CustomerID'],$row['RatingID']);
        $Ratings[] = $Rating;
    }
    return (array("success" => true, "list" => $Ratings));
}
public function getAllRatingByMovie($id,$page){
    $page = intval($page); 
    $number = 12;
    $offset = ($page - 1) * $number;
    $stmt = $this->conn->prepare("SELECT RatingID, Score,  Comment, Day,  MovieID, CustomerID FROM rating where MovieID = :id  ORDer by Day desc limit $offset , $number");
    $stmt ->bindParam(":id", $id);
    $stmt->execute();
    $Ratings = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Rating = new Rating($row['Score'], $row['Day'], $row['Comment'], $row['MovieID'], $row['CustomerID'],$row['RatingID']);
        $Ratings[] = $Rating;
    }
    return (array("success" => true, "list" => $Ratings));
}
    // Phương thức sinh mã ID mới cho Rating
    public function createNewID() {
        $query = "SELECT RatingID FROM rating ORDER BY CAST(RIGHT(RatingID, LENGTH(RatingID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "RT" . ($lastId + 1);
        return $newId;
    }
    function getAverageRating($movieID) {
    
        $sql = "SELECT AVG(Score) AS AvgRating FROM rating WHERE MovieID = :MovieID";
        
        $stmt = $this->conn->prepare($sql);
        $stmt ->bindParam(":MovieID", $movieID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result["AvgRating"]!=0) {
            $avgRating = $result["AvgRating"];
            return $avgRating;
        } else {

            $avgRating = 0.0;
            return $avgRating;
        }
    }
    
}




?>