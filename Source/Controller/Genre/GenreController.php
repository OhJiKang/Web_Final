<?php 
require_once '../../model/model/MovieGenreModel.php';
require_once '../../model/entity/MovieGenre.php';
class GenreController {
    function getAllMovieGenres($page) {
        return (new MovieGenreModel())->getGenreAll($page);
    }
    function getMovieGenreById($id) {
        return (new MovieGenreModel())->getGenreByID($id);

    }
    function addMovieGenre($data){

        $GenreName =   $data['GenreName'];
        $Description =  $data['Description'] ;
        return (new MovieGenreModel())->addGenre(new MovieGenre($GenreName, $Description));
    }
    function removeMovieGenre($id){
        return (new MovieGenreModel())->deleteGenreById($id);

    }
    function getAllGenresByMovie($movieid){
        return (new MovieGenreModel())->getGenreAllByMoiveID($movieid);
    }
    function updateMovieGenre($data){
         $GenreID = $data['GenreID'];
         $GenreName =   $data['GenreName'];
         $Description =  $data['Description'] ;
        $MovieGenre = new MovieGenre( $GenreName, $Description,$GenreID);
        return (new MovieGenreModel())->updateGenre($MovieGenre);

    }
}

?>