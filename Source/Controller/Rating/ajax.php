<?php
require_once 'RatingController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new RatingController)->addRating($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new RatingController)->removeRating($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllRating':
            $page = $_GET['page'];
            echo json_encode((new RatingController)->getAllRatings($page));

            break;
        case 'getRatingById':
        $id = $_GET['id'];
        echo json_encode((new RatingController)->getRatingById($id));

            break;
            case 'getAllRatingsByMovieId':
                $movieId = $_GET['movieId'];
                $page = $_GET['page'];
                echo json_encode((new RatingController)->getAllRatingsByMovieID($movieId,$page));
                break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new RatingController)->updateRating($data));
}

?>