<?php
     class DetailMovieGenre {
        public $MovieID;
        public $GenreID;

        function __construct($MovieID, $GenreID) {
            $this->MovieID = $MovieID;
            $this->GenreID = $GenreID;

        }
        function get_MovieID() {
            return $this->MovieID;
        }
        function get_GenreID() {
            return $this->GenreID;
        }

        function set_MovieID($MovieID) {
            $this->MovieID = $MovieID;
       }
       function set_GenreID($GenreID) {
            $this->GenreID = $GenreID;
       }
    }
?>