<?php 
require_once '../../model/model/ShowTimeModel.php';
require_once '../../model/entity/ShowTime.php';
class ShowTimeController {
    function getAllShowTimes( $page) {
        return (new ShowTimeModel())->getAllShowtime( $page);
    }
    function getShowTimeById($id) {
        return (new ShowTimeModel())->getShowtimeByID($id);

    }
    function addShowTime($data){
        $Price = $data['Price'];
         $StartTime = $data['StartTime'];
         $MovieID = $data['MovieID'];
         $EndTime = $data['EndTime'];
         $RoomID = $data['RoomID'];
         $FormatID = $data['FormatID'];
        return (new ShowTimeModel())->addShowTime(new ShowTime($Price, $StartTime, $MovieID, $EndTime, $RoomID, $FormatID));
    }
    function removeShowTime($id){
        return (new ShowTimeModel())->deleteShowtime($id);

    }
    function getShowTimeByDateAndGenre($date,$genre){
        return (new ShowTimeModel())->getShowtimesByDateandGenre($date,$genre);
    }
    function getShowTimeByDate($date){
        return (new ShowTimeModel())->getShowtimesByDate($date);
    }
    function getShowTimeByMovieIDandTheater($movieID, $TheaterID, $date){
        return (new ShowTimeModel())->getShowtimesByMovieIDandTheater($movieID, $TheaterID, $date);
    }
    function getAllShowtimeByMovieID($movieID, $date){
        return (new ShowTimeModel())->getAllShowtimeByMovieID($movieID,$date);

    }
    function getAllShowtimesByTheaterAndDate($TheaterID, $Date){
        return (new ShowTimeModel())->getShowtimesByTheaterAndDate($TheaterID,$Date);
    }
    function updateShowTime($data){
        $Price = $data['Price'];
        $StartTime = $data['StartTime'];
        $MovieID = $data['MovieID'];
        $EndTime = $data['EndTime'];
        $RoomID = $data['RoomID'];
        $FormatID = $data['FormatID'];
        $ShowtimeID = $data['ShowtimeID'];
        $ShowTime = new ShowTime($Price, $StartTime, $MovieID, $EndTime, $RoomID, $FormatID, $ShowtimeID);
        return (new ShowTimeModel())->updateShowTime($ShowTime);

    }
}

?>