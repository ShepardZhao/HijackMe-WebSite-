<?php
class LoginFaceMatch extends Facepp{



    public function SetLoginMatch($currentImage,$userArrays){
        //get facePlus for currentImage
        $getCurrentFacePlusId = $this->getResponse($currentImage);
        if(!$getCurrentFacePlusId){
            return false;
        }

       $arraylist= $this->loopUsersAndMatch($getCurrentFacePlusId,$userArrays);


        //now the $object should have the values

        //find the max value in array



        return $this->maxValue($arraylist);
    }


    private function loopUsersAndMatch($getCurrentFacePlusId,$userArrays){
        $object =array();

        foreach ($userArrays as $singleUser){
            if(!empty($singleUser['userPhoto'])){
           $getID= $this->getResponse($singleUser['userPhoto']);
            if($getID){
                $getResult = $this -> execute('/recognition/compare',array('face_id2'=>$getID,'face_id1'=>$getCurrentFacePlusId));
                $result = $this->returnIsSimilarity($getResult);
                if($result){
                    array_push($object,array('singleUser'=>$singleUser,'silimarity'=>$result));
                }
            }
            }
        }
        return $object;
    }


    private function getResponse($image){
        $params=array('img'=>$image);
        $params['attribute'] = 'gender,age,race,smiling,glass,pose';
        $response = $this->execute('/detection/detect',$params);
        if($response['http_code']==200){
            #json decode
            $data = json_decode($response['body'],1);
            #get face landmark
            if(!empty($data['face'])){
                $tempFaceID = $data['face'][0]['face_id']; //this is the temp image from the screen
                return $tempFaceID;
            }
            else{
                return false;
            }

        }
        else{
            return false;
        }

    }
    //return similarity
    private function returnIsSimilarity($result){
        $getSimilarity = json_decode($result['body'],1);
        if($getSimilarity['similarity']>60){ // if comparable result is more then 60%
          return $getSimilarity['similarity'];
        }
        else{
            return false;
        }

    }

    //find the max value
    private function maxValue($arraylist){
        if(count($arraylist)>0){
            sort($arraylist);
        }
        $returnUserInfo = $arraylist[0];
        return $returnUserInfo['singleUser'];
    }


}



?>