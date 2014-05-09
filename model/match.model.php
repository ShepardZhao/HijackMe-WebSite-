<?php
class Match extends Facepp{
    private $silmarity;
    public function getRestultOfMatch($currentfaceID,$getfaceArray){
        $matchArray=array();
        foreach($getfaceArray as $singleRecord){
            if($this ->matching($currentfaceID,$singleRecord)){
                //if reutrn the current is matched then push it to new array
                $singleRecord['silmarilty'] = $this->silmarity;
                array_push($matchArray,$singleRecord);
            }
        }

        return $matchArray;
    }

    //extra array to get one single record
    private function matching($currentfaceID,$singleRecord){
       $getfaceidFromDb= $singleRecord['FacePlusID'];
       $isSimilarity =false;
        if($getfaceidFromDb!==$currentfaceID){
           //if current compare status return okay http equals 200
           $getResult = $this -> execute('/recognition/compare',array('face_id2'=>$getfaceidFromDb,'face_id1'=>$currentfaceID));
           if($this->isValdation($getResult)){
               //is similarity?
                if($this->returnIsSimilarity($getResult)){
                    //yes
                    $isSimilarity =true;

                }

           }
           else{
                //if current faceid cannot be compared (date expired), then upload agian

           }
        }




        return $isSimilarity;


    }

    //return status check
    private function isValdation($result){
        if($result['http_code']==200){
            return true;
        }
        else{
            return false;
        }

    }

    //return similarity
    private function returnIsSimilarity($result){
        $getSimilarity = json_decode($result['body'],1);
        if($getSimilarity['similarity']>60){ // if comparable result is more then 70%
            $this-> silmarity = $getSimilarity;
            return true;
        }
        else{
            return false;
        }

    }



   //compare existed photo

    private function reutnExistedPhotoID($currentPhotoID,$compatedPhotoID){
        if($currentPhotoID === $compatedPhotoID){
            return false;
        }
        else{
            return true;
        }
    }

    //face matched algorithm {from left_eye, mouth, nose, right_eye }








}



?>