<?php
    /**
     * Summary of rating
     */
    class Rating {
        public $RatingID;
        public $Score;
        public $Comment;
        public $Day;
        public $MovieID;
        public $CustomerID;

        function __construct( $Score, $Day, $Comment, $MovieID, $CustomerID,$RatingID=null ) {
            $this->Score = $Score;
            $this->Comment = $Comment;
            $this->Day = $Day;
            $this->MovieID = $MovieID;
            $this->CustomerID = $CustomerID;
            if($RatingID!=null){
                $this->RatingID = $RatingID;
            }
        }
        function get_RatingID() {
            return $this->RatingID;
        }
        function get_Score() {
            return $this->Score;
        }
        function get_Comment() {
            return $this->Comment;
        }
        function get_Day() {
            return $this->Day;
        }
        function get_MovieID() {
            return $this->MovieID;
        }
        function get_CustomerID() {
            return $this->CustomerID;
        }


        function set_RatingID($RatingID) {
            $this->RatingID = $RatingID;
        }
        function set_Score($Score) {
            $this->Score = $Score;
        }
        function set_Comment($Comment) {
            $this->Comment = $Comment;
        }
        function set_Day($Day) {
            $this->Day = $Day;
        }
        function set_MovieID($MovieID) {
            $this->MovieID = $MovieID;
        }
        function set_CustomerID($CustomerID) {
            $this->CustomerID = $CustomerID;
        }
    }
?>