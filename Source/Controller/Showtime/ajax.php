<?php
require_once 'ShowTimeController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new ShowTimeController)->addShowTime($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $movieid = $_GET['movieid'];
    echo json_encode((new ShowTimeController)->removeShowTime($movieid));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllShowTime':
            $page = $_GET['page'];
            echo json_encode((new ShowTimeController)->getAllShowTimes($page));
            break;
        case 'getShowTimeById':
            $id = $_GET['id'];
        
            echo json_encode((new ShowTimeController)->getShowTimeById($id));

            break;
            case 'getAllShowTimesByMovie':
                $movieid = $_GET['movieid'];
                $date = $_GET['date'];
                echo json_encode((new ShowTimeController)->getAllShowtimeByMovieID($movieid,$date));
            
                        break;
            case 'getShowTimeByMovieandTheater':
                $movieid = $_GET['movieid'];
                $Theaterid = $_GET['Theaterid'];
                $date = $_GET['date'];
                echo json_encode((new ShowTimeController)->getShowTimeByMovieIDandTheater($movieid,$Theaterid,$date));
            
                        break;
            case 'getShowTimeByDate':
                $date = $_GET['date'];
                echo json_encode((new ShowTimeController)->getShowTimeByDate($date));
                break;
            case 'getShowTimeByDateAndGenre':
                $date = $_GET['date'];
                $genre = $_GET['genre'];
                echo json_encode((new ShowTimeController)->getShowTimeByDateAndGenre($date,$genre));
               
                break;
            case 'getShowTimeByDateAndTheater':
                $date = $_GET['date'];
                $Theaterid = $_GET['Theaterid'];
                echo json_encode((new ShowTimeController)->getAllShowtimesByTheaterAndDate($Theaterid,$date));
                break;

    }   
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new ShowTimeController)->updateShowTime($data));
}
?>