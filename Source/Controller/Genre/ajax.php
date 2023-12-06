<?php
require_once 'GenreController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new GenreController)->addMovieGenre($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new GenreController)->removeMovieGenre($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAll':
            $page = $_GET['page'];
            echo json_encode((new GenreController)->getAllMovieGenres($page));
            break;
        case 'getGenreById':
            $id = $_GET['id'];
            echo json_encode((new GenreController)->getMovieGenreById($id));
            break;
            case 'getGenresByMovieId':
            $movieid = $_GET['movieid'];
            $list = (new GenreController)->getAllGenresByMovie($movieid);
            echo $list;
            break;

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new GenreController)->updateMovieGenre($data));
}
?>