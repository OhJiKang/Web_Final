<?php
require_once 'StatusOfTicketController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new StatusOfTicketController)->addStatusOfTicket($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new StatusOfTicketController)->removeStatusOfTicket($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllStatusOfTicket':
    echo json_encode((new StatusOfTicketController)->getAllStatusOfTickets());

            break;
        case 'getStatusOfTicketById':
    $id = $_GET['id'];
    echo json_encode((new StatusOfTicketController)->getStatusOfTicketById($id));

            break;

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new StatusOfTicketController)->updateStatusOfTicket($data));
}
?>