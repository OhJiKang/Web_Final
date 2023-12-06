<?php 
require_once '../../model/model/SeatModel.php';
require_once '../../model/entity/Seat.php';
class SeatController {
    function getAllSeats($page) {
        return (new SeatModel())->getAllSeat($page);
    }
    function getSeatById($id) {
        return (new SeatModel())->getSeatById($id);

    }
    function getAllSeatsByRoomID($roomID) {
        return (new SeatModel())->getAllSeatByRoom($roomID);
    }
    
    function addSeat($data){
       
        $listSeat  = $data['listSeat'];
        $RoomID  = $data['RoomID'];
        foreach($listSeat as $rowseat){
            $Type = $rowseat['Type'] ;
            $Number = $rowseat['Number'] ;
            $Name = $rowseat['Name'] ;
            for($i=1;$i<=$Number;$i++){
                $SeatName = $Name . $i ;
                (new SeatModel())->addSeat(new Seat($SeatName, $RoomID, $Type));
            }
        }
        
        return  true;
    }
    function removeSeat($id){
        return (new SeatModel())->deleteSeat($id);
    }
    function updateSeat($data){
        $SeatName  = $data['SeatName'];
        $RoomID  = $data['RoomID'];
        $Type  = $data['Type'];
        $SeatID = $data['SeatID'];
        $Seat = new Seat($SeatName, $RoomID, $Type, $SeatID);
        return (new SeatModel())->updateSeat($Seat);

    }
}

?>