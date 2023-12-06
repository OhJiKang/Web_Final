<?php
    class Movie {
        public $MovieID;
        public $MovieName;
        public $Director;
        public $Year;
        public $Premiere;
        public $URLTrailer;
        public $Time;
        public $StudioID;
        public $LanguageID;
        public $story;
        public $age;

        public $ListActor ;
        public $ListGenre ;
        public $listImage ;
        public $rating ;
        function __construct( $MovieName, $Year, $Director, $Premiere, $URLTrailer, $Time, $StudioID, $LanguageID,$story,$age,$MovieID=null) {
            $this->MovieName = $MovieName;
            $this->Director = $Director;
            $this->Year = $Year;
            $this->Premiere = $Premiere;
            $this->URLTrailer = $URLTrailer;
            $this->Time = $Time;
            $this->StudioID = $StudioID;
            $this->LanguageID = $LanguageID;
            $this->story = $story;
            $this->age = $age;
            if($MovieID!=null){
            $this->MovieID = $MovieID;

            }

        }
        function getAge(){
           return $this->age;
        }
        function setAge($age){
            $this ->age = $age;
        }
        function set_story($story){
            $this->story = $story;
        }   
        function get_story(){
            return $this->story;
        }
        function set_rating( $rating ) {
            $this->rating = $rating;
        }
        function get_rating() {
           return $this->rating;
        }
        function get_MovieID() {
            return $this->MovieID;
        }
        function get_MovieName() {
            return $this->MovieName;
        }
        function get_Director() {
            return $this->Director;
        }
        function get_Year() {
            return $this->Year;
        }
        function get_Premiere() {
            return $this->Premiere;
        }
        function get_URLTrailer() {
            return $this->URLTrailer;
        }
        function get_Time() {
            return $this->Time;
        }
        function get_StudioID() {
            return $this->StudioID;
        }
        function get_LanguageID() {
            return $this->LanguageID;
        }
        function set_MovieID($MovieID) {
        $this->MovieID = $MovieID;
        }
        function set_MovieName($MovieName) {
            $this->MovieName = $MovieName;
        }
        function set_Director($Director) {
            $this->Director = $Director;
        }
        function set_Year($Year) {
            $this->Year = $Year;
        }
        function set_Premiere($Premiere) {
            $this->Premiere = $Premiere;
        }
        function set_URLTrailer($URLTrailer) {
            $this->URLTrailer = $URLTrailer;
        }
        function set_Time($Time) {
            $this->Time = $Time;
        }
        function set_StudioID($StudioID) {
            $this->StudioID = $StudioID;
        }
        function set_LanguageID($LanguageID) {
            $this->LanguageID = $LanguageID;
        }
        function add_ListActor($ListActor) {
            $this->ListActor = $ListActor;
        }
        function add_ListGenre($ListGenre) {
            $this->ListGenre= $ListGenre;
        }
        function get_ListActor() {
            return $this->ListActor;
        }
        function get_ListGenre() {
            return $this->ListGenre;
        }
        function add_ListImage($ListImage) {
            $this->listImage = $ListImage;
        }
       
    }
?>