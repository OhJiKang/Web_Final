<?php 
require_once '../../model/model/StudioModel.php';
require_once '../../model/entity/Studio.php';
class StudioController {
    function getAllStudios() {
        return (new StudioModel())->getAll();
    }
    function getStudioById($id) {
        return (new StudioModel())->getStudioByID($id);

    }
    function addStudio($data){
        
         $StudioName = $data['StudioName'];
         $Address = $data['Address'];
         $Phone = $data['Phone'];
         $Email = $data['Email'];
        return (new StudioModel())->addStudio(new Studio($StudioName, $Address, $Phone, $Email));
    }
    function removeStudio($id){
        return (new StudioModel())->removeStudio($id);

    }
    function updateStudio($data){
        $StudioName = $data['StudioName'];
        $Address = $data['Address'];
        $Phone = $data['Phone'];
        $Email = $data['Email'];
        $StudioID = $data['StudioID'];
        $Studio = new Studio($StudioName, $Address, $Phone, $Email,$StudioID);
        return (new StudioModel())->updateStudio($Studio);

    }
}

?>