<?php 
require_once '../../model/model/TheaterModel.php';
require_once '../../model/entity/Theater.php';
class TheaterController {
    function getAllTheaters() {
        return (new TheaterModel())->getAllTheater();
    }
    function getTheaterById($id) {
        return (new TheaterModel())->getTheaterByID($id);

    }
    function addTheater($data){
        
        $TheaterName = $data['TheaterName'];
        $Address = $data['Address'];
        $Phone = $data['Phone'];
        $NumberOfRooms = $data['NumberOfRooms'];
        $Theater = new Theater($TheaterName, $Address, $Phone,$NumberOfRooms);

        return (new TheaterModel())->addTheater($Theater);
    }
    function removeTheater($id){
        return (new TheaterModel())->deleteTheater($id);

    }
    function updateTheater($data){
        $TheaterName = $data['TheaterName'];
        $Address = $data['Address'];
        $Phone = $data['Phone'];
        $TheaterID = $data['TheaterID'];
        $NumberOfRooms = $data['NumberOfRooms'];
        $Theater = new Theater($TheaterName, $Address, $Phone,$NumberOfRooms,$TheaterID);
        return (new TheaterModel())->updateTheater($Theater);

    }
}

?>