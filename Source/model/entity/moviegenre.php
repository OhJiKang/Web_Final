<?php
    class MovieGenre {
        public $GenreID;
        public $GenreName;
        public $Description;

        function __construct( $GenreName, $Description,$GenreID=null) {
            $this->GenreName = $GenreName;
            $this->Description = $Description;
            if($GenreID!=null)
    {
        $this->GenreID = $GenreID;

    }
        }
        function get_GenreID() {
            return $this->GenreID;
        }
        function get_GenreName() {
            return $this->GenreName;
        }
        function get_Description() {
            return $this->Description;
        }

        function set_GenreID($GenreID) {
            $this->GenreID = $GenreID;
        }
        function set_GenreName($GenreName) {
            $this->GenreName = $GenreName;
        }
        function set_Description($Description) {
            $this->Description = $Description;
        }
    }
?>