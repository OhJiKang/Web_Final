<?php
require_once 'PromotionController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new PromotionController)->addPromotion($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
echo json_encode((new PromotionController)->removePromotion($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    switch($action) {
        case 'getAllPromotion':
            $page = $_GET['page'];
    echo json_encode((new PromotionController)->getAllPromotions($page));

            break;
            case 'getPromotionsVorcher':
                $page = $_GET['page'];
        echo json_encode((new PromotionController)->getPromotionsVorcher($page));
    
                break;
                case 'getPromotionsEvent':
                    $page = $_GET['page'];
            echo json_encode((new PromotionController)->getPromotionsEvent($page));
        
                    break;
        case 'getPromotionById':
    $id = $_GET['id'];
    echo json_encode((new PromotionController)->getPromotionById($id));

            break;

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    header('Content-Type: application/json');
    echo json_encode((new PromotionController)->updatePromotion($data));
}
?>