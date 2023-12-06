<?php
require_once 'SeatController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new SeatController)->addSeat($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new SeatController)->removeSeat($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllSeat':
            $page = $_GET['page'];
            echo json_encode((new SeatController)->getAllSeats($page));
            break;
        case 'getSeatById':
    $id = $_GET['id'];
    echo json_encode((new SeatController)->getSeatById($id));
            break;
            case 'getSeatByRoomID':
                $roomID = $_GET['room_id'];
                echo json_encode((new SeatController)->getAllSeatsByRoomID($roomID));
                break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new SeatController)->updateSeat($data));
}
?>