<?php
require_once 'TicketController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new TicketController)->addTicket($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    echo json_encode((new TicketController)->removeTicket($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getAllTicket':
            $page = $_GET['page'];
    echo json_encode((new TicketController)->getAllTickets($page));

            break;
                case 'getTicketById':
            $id = $_GET['id'];
            echo json_encode((new TicketController)->getTicketById($id));

            break;
        case 'getAllTicketsByShowTimeId':
            $ShowTimeId = $_GET['ShowTimeId'];
            echo json_encode((new TicketController)->getAllTicketByShowTime($ShowTimeId));
            break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new TicketController)->updateTicket($data));
}
?>