<?php
require_once 'MovieController.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {

    
  
    $action = $_GET['action'];
    header('Content-Type: application/json');
    
    switch($action) {
        case 'getMoiveHot':
            $list =    (new MovieController)->getHotMovies();
            echo json_encode($list);
            break; 
        case 'getPremieredMovies':
            $page = $_GET['page'];
            $list =   (new MovieController)->getPremieredMovies($page);
            echo json_encode($list);
            break;
        case 'getUpcomingMovies':
            $page = $_GET['page'];
            $list =    (new MovieController)->getUpcomingMovies($page);
            echo json_encode($list);
            break;
        case 'getMoiveByGenres':
            $page = $_GET['page'];
            $genreid = $_GET['genreid'];
            $list =    (new MovieController)->getMovieByGenreID(  $genreid,$page);
            echo json_encode($list);
            break;
        case 'getMovieByID':
            $movieid = $_GET['movieid'];
            $movie = (new MovieController)->getMovieByMovieID( $movieid);
          echo  json_encode($movie);
            break;
        default:
            echo json_encode(array("success" => false, "message" =>"Request không tồn tại"));
            break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    $action = $data['action'];
    switch ($action) {
        case 'getFormatOfMovie':
            
            break;
        case 'addMovie':
            $list =    (new MovieController)->addMovie($data);
            echo json_encode($list);
            break;
       
        case 'addActor':
            $result = (new MovieController)->addActorOfMovie($data);
            echo json_encode($result);
            break;
        case 'addImage':
            $result = (new MovieController)->addImageOfMovie($data);
            echo json_encode($result);
            break;
        case 'addGenre':
            $result = (new MovieController)->addGenreOfMovie($data);
            echo json_encode($result);
            break;
      
        default:
            echo json_encode(array("success" => false, "message" =>"Request không tồn tại"));
            break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    $action = $data['action'];
    switch ($action) {
        case 'updateMovie':
            $list =    (new MovieController)->updateMovie($data);
            echo json_encode($list);
            break;
        case 'updateActor':
            $result = (new MovieController)->updateActorOfMovie($data);
            echo json_encode($result);
            break;
       
        default:
            echo json_encode(array("success" => false, "message" =>"Request không tồn tại"));
            break;
        }
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');

   $action = $_GET['action'];
   switch ($action) {
        case 'deleteMovie':
            $id = $_GET['id'];

        $result = (new MovieController)->deleteMovie($id);
        echo json_encode($result);
        break;
        case 'deleteActor':
            $id = $_GET['id'];

        $result = (new MovieController)->deleteActorOfMovie($id);
        echo json_encode($result);
        break;
        case 'deleteImage':
            $id = $_GET['id'];
            $result = (new MovieController)->deleteImageOfMovie($id);
            echo json_encode($result);
            break;
        case 'deleteGenre':
            $MovieID = $_GET['MovieID'];
            $GenreID = $_GET['GenreID'];
            $result = (new MovieController)->deleteGenreOfMovie($MovieID,$GenreID);
            echo json_encode($result);
            break;
        }
}
?>