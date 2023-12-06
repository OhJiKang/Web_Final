<?php 
require_once '../../model/model/RoomModel.php';
require_once '../../model/entity/Room.php';
class RoomController {
    function getAllRooms() {
        return (new RoomModel())->getAllRoom();
    }
    function getRoomById($id) {
        return (new RoomModel())->getRoomByID($id);

    }
    function addRoom($data){
        
         $RoomName = $data['RoomName'];
          $NumberOfSeats = $data ['NumberOfSeats'];
         $TheaterID = $data['TheaterID'];
        return (new RoomModel())->addRoom(new Room($RoomName, $NumberOfSeats, $TheaterID));
    }
    function removeRoom($id){
        return (new RoomModel())->deleteRoom($id);

    }
    function updateRoom($data){
        $RoomName = $data['RoomName'];
        $NumberOfSeats = $data ['NumberOfSeats'];
       $TheaterID = $data['TheaterID'];
        $RoomID = $data['RoomID'];
        $Room = new Room($RoomName, $NumberOfSeats, $TheaterID,$RoomID);
        return (new RoomModel())->updateRoom($Room);

    }
}

?>