<?php
require_once 'BookingController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    $action = $data['action'];
    switch($action) {
        case 'addBooking':
    echo  json_encode((new BookingController)->addBooking($data));
    break;
    case 'caluateTotalPriceUsingCode':
        echo json_encode((new BookingController)->caluateBookingByCode($data));
    break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
echo json_encode((new BookingController)->removeBooking($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    switch($action) {
        case 'getAllBooking':
            $page = $_GET['page'];
            echo json_encode((new BookingController)->getAllBookings($page));
            break;
        case 'getBookingById':
    $id = $_GET['id'];
    echo json_encode((new BookingController)->getBookingById($id));

            break;
        case 'getAllBookingsByCustomerID': //
            $CustomerID = $_GET['CustomerID'];
            $page = $_GET['page'];
            echo json_encode((new BookingController)->getAllBookingsByCustomerID($CustomerID,$page)) ;   
            break;
        case 'getBookingDetailsByBookingID':
            $id = $_GET['id'];
            echo json_encode((new BookingController)->getBookingDetailsByBookingID($id));
            break;
        


        }       
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    $action = $data['action'];
    switch ($action) {

        case 'update':
            echo json_encode((new BookingController)->updateBooking($data));
break;
            case 'changeStatus':
    echo json_encode((new BookingController)->changeStatusBooking($data));
                break;
    }
}
?>