<?php
require_once 'LanguageController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    echo  json_encode((new LanguageController)->addLanguage($data));
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
echo json_encode((new LanguageController)->removeLanguage($id));
}   
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    switch($action) {
        case 'getAllLanguage':
    echo json_encode((new LanguageController)->getAllLanguages());

            break;
        case 'getLanguageById':
    $id = $_GET['id'];
    echo json_encode((new LanguageController)->getLanguageById($id));

            break;

    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    header('Content-Type: application/json');
    echo json_encode((new LanguageController)->updateLanguage($data));
}
?>