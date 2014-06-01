<?php
class DbOperateor extends DataBase{
    //attributes
    private $DataBaseCon=null;
    //constructor
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

/**
 * interface
 */
    /**
     *  face portal (this will be used when geolocation showing empty)
     */

    public function InterfaceInsert_witoutGeolocation($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$userSession,$faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark,$eventID){// prepare to insert the data into ImageDataSet and FaceDataSet

        if($this->addAImageToDb($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$userSession) && $this->addAFaceToDb($faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark) && $this->preInsertToEventDataSet($eventID,$faceid,$imageid)){
            return true;
        }
        else{
            return false;
        }


    }
    /**
     * end
     */




    /**
     *  face portal (this will be used when geolocation is not empty)
     */

    public function InterfaceInsert_Geolocation($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$userSession,$faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark,$eventID,$image_Longitude,$image_Latitude,$locationID,$geolocationComponet){// prepare to insert the data into ImageDataSet and FaceDataSet

        if($this->addAImageToDb($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$userSession) && $this->addAFaceToDb($faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark) && $this->preInsertToEventDataSetWithGeoLocation($eventID,$faceid,$imageid,$image_Longitude,$image_Latitude) && $this->insertTOlocationTable($locationID,$geolocationComponet,$eventID)){
            return true;
        }
        else{
            return false;
        }


    }
    /**
     * end
     */








/**
 * end
 */


/**
 * Insert function
 */


    /**
     * Image operation functions
     */
    //add image to database
    public function addAImageToDb($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$userSession){
        try{
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO ImageDataSet (ImgID,ImgPathWithPrimalUrl,ImgPathWithResizeUrl,ImgPathWithIconUrl,ImgDate,userID) VALUE (?,?,?,?,?,?)")){
               $stmt->bind_param('ssssss',$imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$userSession);
               $stmt->execute();
               $stmt->close();
               return true;
            }
            else{
                return false;
            }
       }
        catch(Exception $e){
            return false;
        }

    }

    /**
     * end
     */



    /**
     * insert record to photoDataSet
     */
       public function addAFaceToDb($faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark){
          try{
               if($stmt=$this->DataBaseCon->prepare("INSERT INTO FaceDataSet (FaceID,FacePlusID,Age,Age_range,Gender,Glass,Race,Smiling,pitch_angle,roll_angle,yaw_angle,landmark) VALUE (?,?,?,?,?,?,?,?,?,?,?,?)")){
                   $stmt->bind_param('ssiisssdddds',$faceid,$facePlusid,$faceAge,$face_range,$gender,$glass,$race,$smiling,$pitch_angle,$roll_angle,$yaw_angle,$landmark);
                   $stmt->execute();
                   $stmt->close();
                   return true;
               }
                else{
                   return false;
                }
           }
          catch(Exception $e){
                  return false;
           }

       }

    /**
     * Pre insert record into EventDataSet when geolocation is set
     */
    private function preInsertToEventDataSetWithGeoLocation($eventID,$faceID,$imageID,$image_Longitude,$image_Latitude){
        try{
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO EventDataSet (EventID,FaceID,ImgID,Longitude,Latitude) VALUE (?,?,?,?,?)")){
                $stmt->bind_param('sssss',$eventID,$faceID,$imageID,$image_Longitude,$image_Latitude);
                $stmt->execute();
                $stmt->close();
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            return false;
        }
    }





    /**
     * end
     */

    /**
     *  Pre insert record into EventDataSet when geolocation is empty
     */
        private  function preInsertToEventDataSet($eventID, $faceID, $ImgID){
            try{
                if($stmt=$this->DataBaseCon->prepare("INSERT INTO EventDataSet (EventID,FaceID,ImgID) VALUE (?,?,?)")){
                    $stmt->bind_param('sss',$eventID,$faceID,$ImgID);
                    $stmt->execute();
                    $stmt->close();
                    return true;
                }
                else{
                    return false;
                }
            }
            catch(Exception $e){
                return false;
            }
        }

    /**
     * end
     */





/***
 * Query function
 */

    /**
     * query single faceID and return related to result
     */

    public function queryCurrentSingleFaceID($currentfaceID){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude, FaceDataSet.FaceID, FaceDataSet.FacePlusID, FaceDataSet.Age, FaceDataSet.Age_range, FaceDataSet.Gender, FaceDataSet.Glass, FaceDataSet.Race, FaceDataSet.Smiling, FaceDataSet.Pitch_angle, FaceDataSet.Roll_angle, FaceDataSet.Yaw_angle FROM EventDataSet, FaceDataSet, ImageDataSet WHERE EventDataSet.FaceID = FaceDataSet.FaceID AND EventDataSet.ImgID = ImageDataSet.ImgID AND FaceDataSet.FaceID =?")){
                $stmt->bind_param('s',$currentfaceID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$FaceID,$FacePlusID,$Age,$Age_range,$Gender,$Glass,$Race,$Smiling,$Pitch_angle,$Roll_angle,$Yaw_angle);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl, 'imgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude, 'faceID'=>$FaceID, 'FacePlusID'=>$FacePlusID,'Age'=>$Age, 'Age_range'=>$Age_range, 'Gender'=>$Gender, 'Glass'=>$Glass, 'Race'=>$Race, 'Smiling'=>$Smiling, 'Pitch_angle'=>$Pitch_angle, 'Roll_angle'=>$Roll_angle, 'Yaw_angle' => $Yaw_angle);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }

    /**
     * end
     */


    /**
     * query and reutn the faceID
     */
    public function queryFaceIDByFacePlusID($facePlusID){
        try{
            $array=null;

            if($stmt=$this->DataBaseCon->prepare("SELECT FaceID FROM FaceDataSet WHERE FacePlusID =?")){
                $stmt->bind_param('s',$facePlusID);
                $stmt->execute();
                $stmt->bind_result($FaceID);
                while ($stmt->fetch())
                {
                    $array =array('FaceID'=>$FaceID);
                }
                $stmt -> close();
                return $array;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }


    }

    /**
     * end
     */


    /**
     * query and return the name
     */
    public function queryNameByFacePlusId($facePlusID){
        try{
            $array=null;

            if($stmt=$this->DataBaseCon->prepare("SELECT name FROM FaceDataSet WHERE FacePlusID =?")){
                $stmt->bind_param('s',$facePlusID);
                $stmt->execute();
                $stmt->bind_result($name);
                while ($stmt->fetch())
                {
                    $array =array('name'=>$name);
                }
                $stmt -> close();
                return $array;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }


    }

    /**
     * end
     */


    /**
     *  query face landmarks via photoDataSet
     *  The return value contains {ImageID, $ImgPathWithPrimalUrl, $ImgPathWithResizeUrl, $ImgPathWithIconUrl, faceID, Age, Age_range, Gender, Glass, Race, Smiling, Pitch_angle, roll_angle, yaw_angle, facelandmark}
     */
    public function queryAllFacesByuserID($userid){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude, FaceDataSet.FaceID, FaceDataSet.FacePlusID,FaceDataSet.Age, FaceDataSet.Age_range, FaceDataSet.Gender, FaceDataSet.Glass, FaceDataSet.Race, FaceDataSet.Smiling, FaceDataSet.Pitch_angle, FaceDataSet.Roll_angle, FaceDataSet.Yaw_angle, name FROM EventDataSet, FaceDataSet, ImageDataSet WHERE EventDataSet.FaceID = FaceDataSet.FaceID AND EventDataSet.ImgID = ImageDataSet.ImgID AND ImageDataSet.UserID=?")){
                $stmt->bind_param('s',$userid);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$FaceID,$FacePlusID,$Age,$Age_range,$Gender,$Glass,$Race,$Smiling,$Pitch_angle,$Roll_angle,$Yaw_angle,$name);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl, 'imgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude, 'faceID'=>$FaceID, 'FacePlusID'=>$FacePlusID,'Age'=>$Age, 'Age_range'=>$Age_range, 'Gender'=>$Gender, 'Glass'=>$Glass, 'Race'=>$Race, 'Smiling'=>$Smiling, 'Pitch_angle'=>$Pitch_angle, 'Roll_angle'=>$Roll_angle, 'Yaw_angle' => $Yaw_angle, 'name'=>$name);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }



    /**
     * end
     */




/**
 * end
 */




/**
 * insert the name for a new face photo
 */
    public function insertNameForNewPhoto($faceID, $facePlusID, $name){
        try{
            if($stmt=$this->DataBaseCon->prepare("UPDATE FaceDataSet SET name=? WHERE FaceID=? AND FacePlusID=?")){
                $stmt->bind_param('sss',$name,$faceID,$facePlusID);
                $stmt->execute();
                $stmt -> close();
                return true;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }





/**
 * end
 */





/**
 * login check
 */

public function loginCheck($userEmail,$password){
    try{
        $object=array();

        if($stmt=$this->DataBaseCon->prepare("SELECT userID,userEmail,userPhoto FROM UsersDataSet WHERE userEmail=? AND userPassword=?")){
            $stmt->bind_param('ss',$userEmail,md5($password));
            $stmt->execute();
            $stmt->bind_result($userID,$userEmail,$userPhoto);
            while ($stmt->fetch())
            {
                $array =array('userID'=>$userID,'userEmail'=>$userEmail, 'userPhoto'=>$userPhoto);
                array_push($object,$array);
            }
            $stmt -> close();
            if(count($object)>0){
                return $object;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

    }catch(Expection $e){
        return false;
    }
}




/**
 * end
 */



/**
 * op register a user
 */
  public function registerUser($userID,$userEmail,$password,$img){
      try{

          if($stmt=$this->DataBaseCon->prepare("INSERT INTO UsersDataSet (userID,userEmail,userPassword,userPhoto) VALUE (?,?,?,?)")){
              $stmt->bind_param('ssss',$userID,$userEmail,$password,$img);
              $stmt->execute();
              $stmt->close();
              return true;
          }
          else{
              return false;
          }

      }catch(Expection $e){
          return false;
      }
  }



/**
 * end
 */




/**
 * insert nonFace image
 */
public function InterNonFace_witoutGeolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession,$eventID){
    if($this->addAImageToDb($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession) && $this->preInsertToEventDataSet($eventID,"null",$imageID)){
        return true;
    }
    else{
        return false;
    }
}


/**
 * end
 */

    /**
     * @param $imageID
     * @param $imagePathWithPrimalUrl
     * @param $imagePathWithResizeUrl
     * @param $imagePathWithIconUrl
     * @param $imagedate
     * @param $userSession
     * @param $eventID
     * @param $image_Longitude
     * @param $image_Latitude
     * @return bool
     */

    public function InterNonFaceWhithGeolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession,$eventID,$image_Longitude,$image_Latitude,$LocationID,$geolocationComponent){
    if($this->addAImageToDb($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession) && $this->preInsertToEventDataSetWithGeoLocation($eventID,"null",$imageID,$image_Longitude,$image_Latitude) && $this->insertTOlocationTable($LocationID,$geolocationComponent,$eventID)){
        return true;
    }
    else{
        return false;
    }
}
    /**
     * end
     */



    /**
     * query all users
     */
    public function queryAllUsers(){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT userID,userEmail,userPhoto FROM UsersDataSet")){
                $stmt->execute();
                $stmt->bind_result($userID, $userEmail,$userPhoto);
                while ($stmt->fetch())
                {
                    $array =array('userID'=>$userID, 'userEmail'=>$userEmail,'userPhoto'=>$userPhoto);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }


    /**
     * end
     */



    /**
     * query all images
     */

     public function queryAllImageByUserId($userID){
         try{
             $object=array();

             if($stmt=$this->DataBaseCon->prepare("SELECT ImgID,ImgDate,ImgPathWithPrimalUrl,ImgPathWithResizeUrl,ImgPathWithIconUrl FROM ImageDataSet WHERE userID=?")){
                 $stmt->bind_param('s',$userID);
                 $stmt->execute();
                 $stmt->bind_result($ImgID, $ImgDate,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl);
                 while ($stmt->fetch())
                 {
                     $array =array('imgID'=>$ImgID, 'imgDate'=>$ImgDate,'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl, 'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl);
                     array_push($object,$array);
                 }
                 $stmt -> close();
                 return $object;
             }
             else{
                 return false;
             }

         }catch(Expection $e){
             return false;
         }

     }

    /**
     * end
     */



    /**
     * get All Image That Containted GeoLoaction by UserID
     */
    public function getAllImageThatContaintedGeoLoacitonByUserID($userID){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude,LocationDataSet.Address FROM EventDataSet, ImageDataSet,LocationDataSet WHERE EventDataSet.ImgID = ImageDataSet.ImgID AND EventDataSet.EventID=LocationDataSet.EventID AND EventDataSet.Longitude is NOT null AND EventDataSet.Latitude is not NUll AND ImageDataSet.userID=?")){
                $stmt->bind_param('s',$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$Address);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl, 'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl,'imgDate'=>$ImgDate,'Longitude'=>$Longitude,'Latitude'=>$Latitude,'Address'=>$Address);
                    array_push($object,$array);
                }
                $stmt -> close();
                if(count($object)>0){
                    return $object;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }



    }

    /**
     * end
     */


    /**
     * get ALL image by current UserID
     */

    public function getAllImageByUserID($userID){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude,LocationDataSet.Address FROM EventDataSet, ImageDataSet,LocationDataSet WHERE EventDataSet.ImgID = ImageDataSet.ImgID AND EventDataSet.EventID=LocationDataSet.EventID AND ImageDataSet.userID=?")){
                $stmt->bind_param('s',$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$Address);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl, 'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl,'imgDate'=>$ImgDate,'Longitude'=>$Longitude,'Latitude'=>$Latitude,'Address'=>$Address);
                    array_push($object,$array);
                }
                $stmt -> close();
                if(count($object)>0){
                    return $object;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }



    }
    /**
     * end
     */

    /**
     * insert to location table
     */

    private function insertTOlocationTable($LocationID,$geolocationComponent,$EventID){
        try{

            if($stmt=$this->DataBaseCon->prepare("INSERT INTO LocationDataSet (LocationID,Address,City,State,Country,EventID) VALUE (?,?,?,?,?,?)")){
                $stmt->bind_param('ssssss',$LocationID,$geolocationComponent['completeAddress'],$geolocationComponent['city'],$geolocationComponent['state'],$geolocationComponent['country'],$EventID);
                $stmt->execute();
                $stmt->close();
                return true;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }


    /**
     * end
     */


    /**
     * get group classfication
     */

    public function getNameClassifcation(){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT name FROM FaceDataSet GROUP BY name")){
            $stmt->execute();
            $stmt->bind_result($name);
            while ($stmt->fetch())
            {
            array_push($object,$name);
            }
            $stmt -> close();
        if(count($object)>0){
            return $object;
        }
        else{
            return false;
        }
        }
        else{
            return false;
        }

        }catch(Expection $e){
            return false;
        }
    }

    /**
     * end
     */


    /**
     * query all non face
     */
    public function queryAllNonface($userID){

        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude FROM EventDataSet, ImageDataSet WHERE EventDataSet.ImgID = ImageDataSet.ImgID AND EventDataSet.FaceID='null' AND ImageDataSet.UserID = ?")){
                $stmt->bind_param('s',$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl, 'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl,'imgDate'=>$ImgDate,'Longitude'=>$Longitude,'Latitude'=>$Latitude);

                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;


            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }


    }





    /**
     * end
     */


    /**
     * get country classfication
     */
    public function getCountryClassifcation(){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT Country FROM LocationDataSet GROUP BY Country")){
                $stmt->execute();
                $stmt->bind_result($Country);
                while ($stmt->fetch())
                {
                    array_push($object,$Country);
                }
                $stmt -> close();
                return $object;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }


    /**
     * end
     */




    /**
     * get state classfication
     */
    public function getStateClassifcation(){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT State FROM LocationDataSet GROUP BY State")){
                $stmt->execute();
                $stmt->bind_result($State);
                while ($stmt->fetch())
                {
                    array_push($object,$State);
                }
                $stmt -> close();
                return $object;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }




    /**
     * end
     */


    /**
     * get city classfication
     */
    public function getCityClassifcation(){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT City FROM LocationDataSet GROUP BY City")){
                $stmt->execute();
                $stmt->bind_result($city);
                while ($stmt->fetch())
                {
                    array_push($object,$city);
                }
                $stmt -> close();
                return $object;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }



    /**
     * end
     */


    /**
     * get date classfication
     */
    public function getYearClassifcation(){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT YEAR(STR_TO_DATE(ImgDate, '%Y')) from ImageDataSet GROUP BY YEAR(STR_TO_DATE(ImgDate, '%Y'))")){
                $stmt->execute();
                $stmt->bind_result($year);
                while ($stmt->fetch())
                {
                    array_push($object,$year);
                }
                $stmt -> close();
                if(count($object)>0){
                    return $object;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }







    /**
     * end
     */



    /**
     * get gender
     */
    public function getGenderClassifcation(){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT Gender FROM FaceDataSet GROUP BY Gender")){
                $stmt->execute();
                $stmt->bind_result($Gender);
                while ($stmt->fetch())
                {
                    array_push($object,$Gender);
                }
                $stmt -> close();
                if(count($object)>0){
                    return $object;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }

    /**
     * end
     */



    /**
     * get getExactlyNameClassifcation
     */
    public function getExactlyNameClassifcation($name,$userID){
        try{
            $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude,FaceDataSet.name FROM FaceDataSet, EventDataSet,ImageDataSet WHERE FaceDataSet.FaceID =EventDataSet.FaceID AND EventDataSet.ImgID = ImageDataSet.ImgID AND FaceDataSet.name=? AND ImageDataSet.userID=?")){
                $stmt->bind_param('ss',$name,$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$name);
                while ($stmt->fetch())
                {
                   $temp= array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl, 'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl,'imgDate'=>$ImgDate,'Longitude'=>$Longitude,'Latitude'=>$Latitude,'name'=>$name);
                    array_push($object,$temp);
                }
                $stmt -> close();
                 return $object;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }


    /**
     * end
     */


    /**
     * query all face by user id
     */
    public function getAllface($userid){

        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude, FaceDataSet.FaceID, FaceDataSet.FacePlusID,FaceDataSet.Age, FaceDataSet.Age_range, FaceDataSet.Gender, FaceDataSet.Glass, FaceDataSet.Race, FaceDataSet.Smiling, FaceDataSet.Pitch_angle, FaceDataSet.Roll_angle, FaceDataSet.Yaw_angle, name FROM EventDataSet, FaceDataSet, ImageDataSet WHERE EventDataSet.FaceID = FaceDataSet.FaceID AND EventDataSet.ImgID = ImageDataSet.ImgID AND ImageDataSet.UserID=?")){
                $stmt->bind_param('s',$userid);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$FaceID,$FacePlusID,$Age,$Age_range,$Gender,$Glass,$Race,$Smiling,$Pitch_angle,$Roll_angle,$Yaw_angle,$name);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl, 'imgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude, 'faceID'=>$FaceID, 'FacePlusID'=>$FacePlusID,'Age'=>$Age, 'Age_range'=>$Age_range, 'Gender'=>$Gender, 'Glass'=>$Glass, 'Race'=>$Race, 'Smiling'=>$Smiling, 'Pitch_angle'=>$Pitch_angle, 'Roll_angle'=>$Roll_angle, 'Yaw_angle' => $Yaw_angle, 'name'=>$name);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }

    }



    /**
     * end
     */


    /**
     * update the event for a image
     */
     public function updateEvent($eventName,$imgID){
         try{
             if($stmt=$this->DataBaseCon->prepare("UPDATE EventDataSet SET EventName=? WHERE ImgID=?")){
                 $stmt->bind_param('ss',$eventName,$imgID);
                 $stmt->execute();
                 return true;
             }
             else{
                 return false;
             }

         }catch(Expection $e){
             return false;
         }


     }

    /**
     * end
     */




    /**
     * query gender
     */

    public function queryGenderByUserID($value,$userID){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude, FaceDataSet.FaceID, FaceDataSet.FacePlusID,FaceDataSet.Age, FaceDataSet.Age_range, FaceDataSet.Gender, FaceDataSet.Glass, FaceDataSet.Race, FaceDataSet.Smiling, FaceDataSet.Pitch_angle, FaceDataSet.Roll_angle, FaceDataSet.Yaw_angle, name FROM EventDataSet, FaceDataSet, ImageDataSet WHERE EventDataSet.FaceID = FaceDataSet.FaceID AND FaceDataSet.Gender=? AND EventDataSet.ImgID = ImageDataSet.ImgID AND ImageDataSet.UserID=?")){
                $stmt->bind_param('ss',$value,$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$FaceID,$FacePlusID,$Age,$Age_range,$Gender,$Glass,$Race,$Smiling,$Pitch_angle,$Roll_angle,$Yaw_angle,$name);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl, 'imgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude, 'faceID'=>$FaceID, 'FacePlusID'=>$FacePlusID,'Age'=>$Age, 'Age_range'=>$Age_range, 'Gender'=>$Gender, 'Glass'=>$Glass, 'Race'=>$Race, 'Smiling'=>$Smiling, 'Pitch_angle'=>$Pitch_angle, 'Roll_angle'=>$Roll_angle, 'Yaw_angle' => $Yaw_angle, 'name'=>$name);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }

    /**
     * end
     */


    /**
     * get event classfication
     */

    public function getEventClassifcation(){

        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT EventName FROM hijackme.EventDataSet WHERE EventName is not null GROUP BY EventName")){
                $stmt->execute();
                $stmt->bind_result($EventName);
                while ($stmt->fetch())
                {
                    array_push($object,$EventName);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }

    }



    /**
     * end
     */




    /**
     * event query
     */
    public function queryEvent($eventName,$userID){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude FROM EventDataSet, ImageDataSet WHERE EventDataSet.ImgID = ImageDataSet.ImgID AND EventDataSet.EventName=? AND ImageDataSet.UserID=?")){
                $stmt->bind_param('ss',$eventName,$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl, 'imgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }


    /**
     * end
     */



    /**
     * query year
     */
    public function queryYear($year,$userID){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude FROM EventDataSet, ImageDataSet WHERE EventDataSet.ImgID = ImageDataSet.ImgID AND EXTRACT(YEAR FROM ImgDate)=? AND ImageDataSet.UserID=?")){
                $stmt->bind_param('ss',$year,$userID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl, 'imgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude);
                    array_push($object,$array);
                }
                $stmt -> close();
                return $object;
            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }
    }


    /**
     * end
     */




    /**
     * get image by its id
     */


    public function getImageByItsID($imgID){
        try{

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate FROM ImageDataSet WHERE ImageDataSet.ImgID=? ")){
                $stmt->bind_param('s',$imgID);
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate);
                while ($stmt->fetch())
                {
                    $array =array('imgID'=>$ImgID, 'imgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl, 'imgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'imgPathWithIconUrl'=>$ImgPathWithIconUrl,'imgDate'=>$ImgDate);
                }
                $stmt -> close();
                return $array;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }



    }

    /**
     * end
     */



    /**
     * insert the record to QRDataSet
     */

    public function insertQrReocrd($getQrid,$getQrCodeUrl,$qrName,$qrItems,$userSession){
        date_default_timezone_set('Australia/Melbourne');
        $date = date('m/d/Y h:i:s a', time());
        try{

            if($stmt=$this->DataBaseCon->prepare("INSERT QRDataSet (QRID,QRPath,QRName,QRitems,QRDate,userID) VALUE (?,?,?,?,?,?)")){
                $stmt->bind_param('ssssss',$getQrid,$getQrCodeUrl,$qrName,$qrItems,$date,$userSession);
                $stmt->execute();
                $stmt->close();
                return true;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }

    }

    /**
     * end
     */




    /**
     * query QR information
     */
    public function queryQRinformation($userID){
        try{
             $oarray=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT QRName, QRPath,QRDate FROM QRDataSet WHERE userID=? ")){
                $stmt->bind_param('s',$userID);
                $stmt->execute();
                $stmt->bind_result($QRName,$QRPath,$QRDate);
                while ($stmt->fetch())
                {
                    $array =array('qrName'=>$QRName, 'qrPath'=>$QRPath,'Date'=>$QRDate);
                    array_push($oarray,$array);
                }
                $stmt -> close();
                return $oarray;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }


    }


    /**
     * end
     */



    /**
     * query QR by its id
     */
    public function queryQRbyItsID($qrID){
        try{

            if($stmt=$this->DataBaseCon->prepare("SELECT QRitems FROM QRDataSet WHERE QRID=? ")){
                $stmt->bind_param('s',$qrID);
                $stmt->execute();
                $stmt->bind_result($QRitems);
                while ($stmt->fetch())
                {
                    $getarray = unserialize($QRitems);
                }
                $stmt -> close();
                $array=array();
                foreach($getarray as $value){
                    array_push($array,$this->getImageByItsID($value));
                }

                return $array;

            }
            else{
                return false;
            }

        }catch(Expection $e){
            return false;
        }


    }




    /**
     * end
     */



}



?>