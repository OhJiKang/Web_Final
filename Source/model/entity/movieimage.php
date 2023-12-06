<?php 
    class MovieImage {
        public $ImageID;
        public $ImagePath;
        public $MovieID;
        public $type;


        function __construct( $ImagePath, $MovieID,$type,$ImageID=null) {
            $this->ImagePath = $ImagePath;
      
            $this->MovieID = $MovieID;
            $this->type = $type;
            if($ImageID!=null){
            $this->ImageID = $ImageID;

            }
        }
        function getType() {
            return $this->type;
        }
        function setType($type) {
            $this->type = $type;
        }
        function get_ImageID() {
            return $this->ImageID;
        }
        function get_ImagePath() {
            return $this->ImagePath;
        }
      
        function get_MovieID() {
            return $this->MovieID;
        }

        function set_ImageID($ImageID) {
            $this->ImageID = $ImageID;
        }
        function set_ImagePath($ImagePath) {
            $this->ImagePath = $ImagePath;
        }
       
        function set_MovieID($MovieID) {
            $this->MovieID = $MovieID;
        }
    }
?>