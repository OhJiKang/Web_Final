<?php 
require_once '../../model/model/MovieModel.php';
require_once '../../model/model/RatingModel.php';
require_once '../../model/model/MovieGenreModel.php';
require_once '../../model/model/ActorModel.php';
require_once '../../model/model/LanguageModel.php';
require_once '../../model/entity/Movie.php';
require_once '../../model/entity/movieimage.php';
class MovieController{
    public function getPremieredMovies($page){
        $movies = (new MovieModel)->getPremieredMovies($page);
 
        
        foreach($movies as $movie ){
            $movieID = $movie->get_MovieID();
            // return $movies;
            $movie->set_rating((new RatingModel())->getAverageRating($movieID));
            $images = (new MovieImageModel())->getMoiveImageID($movieID);
            $obj = json_decode($images);
            $imagePaths = array();
           
            foreach ($obj->listImages as $movieImage) {
                $imagePaths[] = $movieImage;
            }
            $movie->add_ListImage($imagePaths);
            $actors = (new ActorModel())->getActorOfMovie($movieID);
            $movie->add_ListActor($actors);
            $genres = (new MovieGenreModel())->getGenreAllByMoiveID($movieID);
            $movie->add_ListGenre($genres);
        }
        return $movies;
    }

    public function getUpcomingMovies($page){
        $movies = (new MovieModel)->getUpcomingMovies($page);
 
        
        foreach($movies as $hotMovie ){
            $movieID = $hotMovie->get_MovieID();
            // return $movies;
            $hotMovie->set_rating((new RatingModel())->getAverageRating($movieID));
            $images = (new MovieImageModel())->getMoiveImageID($movieID);
            $obj = json_decode($images);
            $imagePaths = array();
           
            foreach ($obj->listImages as $movieImage) {
                $imagePaths[] = $movieImage;
            }
            $hotMovie->add_ListImage($imagePaths);
            $actors = (new ActorModel())->getActorOfMovie($movieID);
            $hotMovie->add_ListActor($actors);
            $genres = (new MovieGenreModel())->getGenreAllByMoiveID($movieID);
            $hotMovie->add_ListGenre($genres);
        }
        return $movies;
    }
    public function updateMovie($data){
        
        $MovieName = $data['MovieName'];
        $Director = $data['Director'];
        $Year = $data['Year'];
        $Premiere = $data['Premiere'];
        $URLTrailer = $data['URLTrailer'];
        $Time = $data['Time'];
        $StudioID = $data['StudioID'];
        $LanguageID = $data['LanguageID'];
        $story = $data['story'];
        $age = $data['age'];
        $MovieID = $data['MovieID'];
       $movie  = new Movie($MovieName, $Year, $Director, $Premiere, $URLTrailer, $Time, $StudioID, $LanguageID,$story,$age,$MovieID);
     
       return(new MovieModel)->updateMovie($movie);
    }
    public function deleteActorOfMovie($actorID){
        $ActorModel = new ActorModel();
      
      return  $ActorModel->deleteActorOfMovie($actorID);
    }
    public function addActorOfMovie($data){
        $MovieID = $data['MovieID'];
        $NameActor = $data['NameActor'];
        return (new ActorModel())->addActorOfMovie(new ActorOfMovie($NameActor, $MovieID));
    }
    public function updateActorOfMovie($data){
        $MovieID = $data['MovieID'];
        $ActorID = $data['ActorID'];
        $name = $data['Name'];
        return (new ActorModel())->updateActorOfMovie(new ActorOfMovie($name, $MovieID, $ActorID));
    }
    public function deleteImageOfMovie( $imageID){
        return (new MovieImageModel)->deleteImage($imageID);
    }
    public function deleteGenreOfMovie( $genreID ,$movieID){
        return (new MovieModel)->deleteGenreForMovie(new DetailMovieGenre($movieID,$genreID));
    }
    public function addGenreOfMovie( $data){
        $MovieID = $data['MovieID'];
        $GenreID = $data['GenreID'];
        return array("success"=>(new MovieModel())->addGenreForMovie(new DetailMovieGenre($MovieID,$GenreID)));
    }
    public function addImageOfMovie($data){
         $MovieID = $data['MovieID'];
         $ImagePath = $data['file'];

         $type = $data['type'];
         $base64 = str_replace('data:application/octet-stream;base64,', '', $ImagePath);
         $file = base64_decode($base64);
        
         $filename = 'images/imagesfilms/'. uniqid() . '.jpg'; // generate a unique filename
         if(file_put_contents("../../".$filename, $file)) {
             $responses[] = ['status' => 'success', 'message' => 'File saved successfully.'];
         } else {
             return  ['status' => 'error', 'message' => 'Error saving file.'];
         }
         $image = new MovieImage($filename,$MovieID,$type);
         
         if(!(new MovieImageModel())->addMoiveImage($image)){
             return array('success' => false,'message' => "Thêm image thất bại");
         }
         return array('success' => true,'message' => "Thêm image thành công");

    }
    
    public function addMovie($data){
        
        $MovieName = $data['MovieName'];
        $Director = $data['Director'];
        $Year = $data['Year'];
        $Premiere = $data['Premiere'];
        $URLTrailer = $data['URLTrailer'];
        $Time = $data['Time'];
        $StudioID = $data['StudioID'];
        $LanguageID = $data['LanguageID'];
        $story = $data['story'];
        $age = $data['age'];
        $listActor = $data['ListActor'];
        $listGenre = $data['ListGenre'];
        $listImage = $data['ListImage'];
        $movie  = new Movie($MovieName, $Year, $Director, $Premiere, $URLTrailer, $Time, $StudioID, $LanguageID,$story,$age);
        $result = (new MovieModel)->addMoive($movie);
        if($result['success']){
            $id = $result['id'];
            
            foreach($listActor as $actor){
                $actor = new ActorOfMovie($actor,$id);
                (new ActorModel)->addActorOfMovie($actor);
                
            }
            foreach($listGenre as $idgenre){
             if(!(new MovieModel)->addGenreForMovie(new DetailMovieGenre($id,$idgenre))){
                return array('success' => false, 'message' => "Thêm genre thất bại");
             }

            }
            $responses  = array();
            foreach($listImage as $image){
          
                $base64 = $image["file"];
                $base64 = str_replace('data:application/octet-stream;base64,', '', $base64);
                $file = base64_decode($base64);
               
                $filename = 'images/imagesfilms/'. uniqid() . '.jpg'; // generate a unique filename
                if(file_put_contents("../../".$filename, $file)) {
                    $responses[] = ['status' => 'success', 'message' => 'File saved successfully.'];
                } else {
                    return  ['status' => 'error', 'message' => 'Error saving file.'];
                }
                $image = new MovieImage($filename,$id,$image["type"]);
                
                if(!(new MovieImageModel())->addMoiveImage($image)){
                    return array('success' => false,'message' => "Thêm image thất bại");
                }
        }
        return array('success'=>true, 'message'=>"Thêm thành công 1221");
        }
        return array('success'=>false, 'message'=>"Thêm thất bại");

    }   
    
    public function getMovieByGenreID($id,$page){
        $moives = (new MovieModel)->getMoviesByGenre($id,$page);
        foreach($moives as $Movie ){
            $movieID = $Movie->get_MovieID();
            // return $moives;
            $Movie->set_rating((new RatingModel())->getAverageRating($movieID));
            $images = (new MovieImageModel())->getMoiveImageID($movieID);
            $obj = json_decode($images);
            $imagePaths = array(); 
            foreach ($obj->listImages as $movieImage) {
                $imagePaths[] = $movieImage;
            }
            $Movie->add_ListImage($imagePaths);
            $actors = (new ActorModel())->getActorOfMovie($movieID);
            $Movie->add_ListActor($actors);
            $genres = (new MovieGenreModel())->getGenreAllByMoiveID($movieID);
            $Movie->add_ListGenre($genres);
        }   return $moives;
    }
    public function getHotMovies(){
        $hotMovies = ((new MovieModel)->getHotMovies());
        
        foreach($hotMovies as $hotMovie ){
            $movieID = $hotMovie->get_MovieID();
            // return $hotMovies;
            $hotMovie->set_rating((new RatingModel())->getAverageRating($movieID));
            $images = (new MovieImageModel())->getMoiveImageID($movieID);
            $obj = json_decode($images);
            $imagePaths = array();
           
            foreach ($obj->listImages as $movieImage) {
                $imagePaths[] = $movieImage;
            }
            $hotMovie->add_ListImage($imagePaths);
            $actors = (new ActorModel())->getActorOfMovie($movieID);
            $hotMovie->add_ListActor($actors);
            $genres = (new MovieGenreModel())->getGenreAllByMoiveID($movieID);
            $hotMovie->add_ListGenre($genres);
        }
        return $hotMovies;
    }
    public function getMovieByMovieID($movieID){
        $result = (new MovieModel())->getMovieById($movieID);
        if($result['success']){
            $movie = $result['movie'];
            $movie->set_rating((new RatingModel())->getAverageRating($movieID));
            $movieID = $movie->get_MovieID();
            $images = (new MovieImageModel())->getMoiveImageID($movieID);
            $obj = json_decode($images);
            $imagePaths = array();
           
            foreach ($obj->listImages as $movieImage) {
                $imagePaths[] = $movieImage;
            }
            $movie->add_ListImage($imagePaths);
            $actors = (new ActorModel())->getActorOfMovie($movieID);
            $movie->add_ListActor($actors);
            $genres = (new MovieGenreModel())->getGenreAllByMoiveID($movieID);
            $movie->add_ListGenre($genres);
            return array("success" => true, "movie" => $movie);
        }else{
            return array("success" => false, "message" =>"Movie không tồn tại");
        }
    }
    public function deleteMovie($movieid){
        return (new MovieModel)->deleteMovie($movieid);

    }
   
}

?>