<?php
require_once 'RoomController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new RoomController)->addRoom($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new RoomController)->removeRoom($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllRoom':
    echo json_encode((new RoomController)->getAllRooms());

            break;
        case 'getRoomById':
    $id = $_GET['id'];
    echo json_encode((new RoomController)->getRoomById($id));

            break;

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new RoomController)->updateRoom($data));
}
?>