<?php 
require_once '../../model/model/FormatModel.php';
require_once '../../model/entity/Format.php';
class FormatController {
    function getAllFormats() {
        return (new FormatModel())->getAllFormat();
    }
    function getFormatById($id) {
        return (new FormatModel())->getFormatByID($id);

    }
    function addFormat($data){
        $name = $data['name'];
        return (new FormatModel())->addFormat(new Format($name));
    }
    function removeFormat($id){
        return (new FormatModel())->deleteFormat($id);

    }
    function updateFormat($data){
       $name =  $data['name'];
       $id = $data['id'];
        $Format = new Format($name,$id);
        return (new FormatModel())->updateFormat($Format);

    }
    public function getAllFormatsOfMovie($movieid){
        return (new FormatModel())->getFormateOfMovie($movieid);
    }
}

?>