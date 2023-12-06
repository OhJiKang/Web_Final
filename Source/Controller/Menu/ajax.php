<?php
require_once 'MenuController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new MenuController)->addMenu($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
echo json_encode((new MenuController)->removeMenu($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    switch($action) {
        case 'getAllMenu':
            $page = $_GET['page'];
        echo json_encode((new MenuController)->getAllMenus($page));
            break;
        case 'getMenuById':
    $id = $_GET['id'];
    echo json_encode((new MenuController)->getMenuById($id));
            break;
            case 'getMenuByStatus':
                $page = $_GET['page'];
                $status = $_GET['status'];
                echo json_encode((new MenuController)->getMenuByStatus($page,$status));
                    break;
        

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    header('Content-Type: application/json');
    echo json_encode((new MenuController)->updateMenu($data));
}
?>