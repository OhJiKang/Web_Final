<?php 
require_once '../../model/model/MenuModel.php';
require_once '../../model/entity/Menu.php';
class MenuController {
    function getAllMenus($page) {
        return (new MenuModel())->getAllMenu($page);
    }
    function getMenuById($id) {
        return (new MenuModel())->getMenuByID($id);

    }
    function getMenuByStatus($page,$status) {
        return (new MenuModel())->getAllMenuByStatus($page,$status);

    }
    function addMenu($data){
      
        $Name = $data['Name'];
         
         $Price =  $data['Price'];
         $status =  $data['status'];
         $url_image = $data['file'];
       
         $base64 = str_replace('data:application/octet-stream;base64,', '', $url_image);
         $file = base64_decode($base64);
         $filename = 'images/img/'. uniqid() . '.jpg'; // generate a unique filename
         if(file_put_contents("../../".$filename, $file)) {
             $responses[] = ['status' => 'success', 'message' => 'File saved successfully.'];
         } else {
             return  ['status' => 'error', 'message' => 'Error saving file.'];
         }
        return (new MenuModel())->addMenu(new Menu($Name, $filename, $Price ,$status ));
    }
    function removeMenu($id){
        return (new MenuModel())->deleteMenu($id);

    }
    function updateMenu($data){
        $Name = $data['Name'];
        $ImageURL =  $data['ImageURL'];
        $Price =  $data['Price'];
        $ItemID =  $data['ItemID'];
        $status =  $data['status'];

        $Menu = new Menu($Name, $ImageURL, $Price, $status, $ItemID);
        return (new MenuModel())->updateMenu($Menu);
    }
}

?>