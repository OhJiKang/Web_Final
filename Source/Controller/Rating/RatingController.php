<?php 
require_once '../../model/model/RatingModel.php';
require_once '../../model/entity/Rating.php';
class RatingController {
    function getAllRatings($page ) {
        return  ((new RatingModel())->getAllRating($page));
    }
    function getAllRatingsByMovieID($id,$page ) {
        return(new RatingModel())->getAllRatingByMovie($id,$page);
    }
    function getRatingById($id) {
        return (new RatingModel())->getRatingByID($id);

    }
    function addRating($data){
         $Score = $data['Score'];
         $Comment = $data['Comment'];
         $Day = $data['Day'];
         $MovieID = $data['MovieID'];
         $CustomerID = $data['CustomerID'];
        return (new RatingModel())->addRating(new Rating($Score, $Day, $Comment, $MovieID, $CustomerID));
    }
    function removeRating($id){
        return (new RatingModel())->deleteRating($id);

    }
    function updateRating($data){
        $RatingID = $data['RatingID'];
        $Score = $data['Score'];
        $Comment = $data['Comment'];
        $Day = $data['Day'];
        $MovieID = $data['MovieID'];
        $CustomerID = $data['CustomerID'];
        $Rating = new Rating($Score, $Day, $Comment, $MovieID, $CustomerID,$RatingID);
        return (new RatingModel())->updateRating($Rating);
    }
}

?>