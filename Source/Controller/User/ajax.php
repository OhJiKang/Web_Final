<?php
session_start();
require_once 'UserController.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    $action = $data['action'];
    switch($action) {
        case 'login':
            $email = $data['email'];
            $password = $data['password'];
            $userController = new UserController();
            $temp = $userController->login($email,$password);
            if($temp['success']){
                $_SESSION['user'] = $temp; 
                echo json_encode($temp);
            }else{
                echo json_encode(array('success' => false,'message' =>"Đăng nhập thất bại"));
            }
            break;
        case 'register':
            $register = (new UserController())->registerCustomer($data);
            if($register['success']){
                $_SESSION['user'] = $register; 
                echo json_encode($register);
            }else{
                echo json_encode($register);
            }
            break;
            
        case 'addManger':
            $addManger = (new UserController())->addManager($data);
            if($addManger['success']){
                $_SESSION['user'] = $addManger; 
                echo json_encode($addManger);
            }else{
                echo json_encode($addManger);
            }
            break;
    
            
        }
            
        
        }
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $action = $_GET['action'];
    header('Content-Type: application/json');

    switch($action){
        case 'getAllCustomer';
    $page = $_GET['page'];

            $list = (new UserController)->getAllCustomer($page);
            echo $list;
            break;
        case 'getAllManger':
    $page = $_GET['page'];

            $list = (new UserController)->getAllManager($page);
            echo $list;
            break;
        case 'getUserById':
            $id = $_GET['id'];

            echo json_encode((new UserController)->getUserById($id));
            break;
        case 'getUserByEmail':
            $email = $_GET['email'];
            echo json_encode((new UserController)->getUserByEmail($email));
            break;
        default:
            echo json_encode(array("success"=>true,"message"=>"Request không tồn tại"));
            break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $data = file_get_contents("php://input");
    header('Content-Type: application/json');


        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
        $action = $data['action'];
   
    switch($action){
        case 'changePassword':
            $id = $data['id'];
            $newPassword = $data['new_password'];
            $oldPassword = $data['old_password'];
            echo (new UserController())->changePassword($id, $newPassword, $oldPassword);
            break;
        case 'update_customer':
            $result = (new UserController())->updateInformationForCustomer($data);
            echo ($result);
            break;
        case 'update_customer_for_admin':
            $result = (new UserController())->updateCustomerForAdmin($data);
            echo json_encode($result);
            break;
        case 'update_manager':
                $result = (new UserController())->updateInformationForManager($data);
                echo $result;
             break;
        default:
                echo json_encode(array("success"=>true,"message"=>"Request không tồn tại"));
                break;
        }
}
if($_SERVER['REQUEST_METHOD'] =='DELETE'){
    $email = $_GET['email'];
    header('Content-Type: application/json');
    $result = (new UserController())->deteleManager($email);
    echo json_encode($result);
}
?>