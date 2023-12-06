<?php
    class Language {
        public $LanguageID;
        public $LanguageName;

        public function __construct($LanguageName, $LanguageID = null) {
            $this->LanguageName = $LanguageName;
            if($LanguageID!=null){
                $this->LanguageID = $LanguageID;
            }
        }
        function get_LanguageID() {
            return $this->LanguageID;
        }
        function get_LanguageName() {
            return $this->LanguageName;
        }

        function set_LanguageID($LanguageID) {
            $this->LanguageID = $LanguageID;
       }
       function set_LanguageName($LanguageName) {
            $this->LanguageName = $LanguageName;
       }
    }
?>