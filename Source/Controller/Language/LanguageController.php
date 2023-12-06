<?php 
require_once '../../model/model/LanguageModel.php';
require_once '../../model/entity/Language.php';
class LanguageController {
    function getAllLanguages() {
        return (new LanguageModel())->getAllLanguages();
    }
    function getLanguageById($id) {
        return (new LanguageModel())->getLanguageById($id);

    }
    function addLanguage($data){
        $name = $data['name'];
        return (new LanguageModel())->addLanguage(new Language($name));
    }
    function removeLanguage($id){
        return (new LanguageModel())->deleteLanguage($id);
    }
    function updateLanguage($data){
       $name =  $data['name'];
       $id = $data['id'];
        $language = new Language($name,$id);
        return (new LanguageModel())->updateLanguage($language);

    }
}

?>