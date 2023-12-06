<?php
require_once 'TheaterController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new TheaterController)->addTheater($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new TheaterController)->removeTheater($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllTheater':
    echo json_encode((new TheaterController)->getAllTheaters());

            break;
        case 'getTheaterById':
    $id = $_GET['id'];
    echo json_encode((new TheaterController)->getTheaterById($id));

            break;

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new TheaterController)->updateTheater($data));
}
?>