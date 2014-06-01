<?php
class Match extends Facepp{
    private $silmarity;
    public function getRestultOfMatch($currentfacePlusID,$getfaceArray){
        $matchArray=array();
        foreach($getfaceArray as $singleRecord){
            if($this ->matching($currentfacePlusID,$singleRecord)){
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
        if($getSimilarity['similarity']>65){ // if comparable result is more then 65%
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


   //split the record for the single record then get query for the name
    public function updateNameForExistedPhoto($currentfacePlusID,$matchedArray,$dbop){
        $getMaxSimilaryArray = $this->findMaxSimilarty($matchedArray);
        //this record contains max records
        $getNameArray = $dbop->queryNameByFacePlusId($getMaxSimilaryArray['FacePlusID']);
        //get exact name
        $name = $getNameArray['name'];


        //according to facePlusID to get faceID

        $currentFaceID = $dbop -> queryFaceIDByFacePlusID($currentfacePlusID);


        //final insert the name for current photo
        $dbop->insertNameForNewPhoto($currentFaceID['FaceID'],$currentfacePlusID,$name);

    }



    private function findMaxSimilarty($matchedArray){
        $sotresimilarity = array();
        $MaxSimilarity=null;
        foreach($matchedArray as $matchedSingledResult){
            array_push($sotresimilarity,$matchedSingledResult['silmarilty']);
        }
        $maxSimilarity = max($sotresimilarity);

        foreach($matchedArray as $matchedSingledResult){
            if($matchedSingledResult['silmarilty']===$maxSimilarity){
                $MaxSimilarity=$matchedSingledResult;
            }
        }

       return $MaxSimilarity;
    }




}



?>