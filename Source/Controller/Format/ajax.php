<?php
require_once 'FormatController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new FormatController)->addFormat($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
echo json_encode((new FormatController)->removeFormat($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    switch($action) {
        case 'getAllFormat':
        echo json_encode((new FormatController)->getAllFormats());

            break;
        case 'getFormatById':
    $id = $_GET['id'];
    echo json_encode((new FormatController)->getFormatById($id));

            break;
        case 'getAllFormatsByMovieId':
            $movieId = $_GET['movieId'];
            echo json_encode((new FormatController)->getAllFormatsOfMovie($movieId)) ;   
    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new FormatController)->updateFormat($data));
}
?>