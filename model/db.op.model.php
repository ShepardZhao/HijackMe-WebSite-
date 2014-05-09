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
     *  Normal portal (this will be used when geolocation showing empty)
     */

    public function InterfaceInsert_witoutGeolocation($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate,$faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark,$eventID){// prepare to insert the data into ImageDataSet and FaceDataSet

        if($this->addAImageToDb($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate) && $this->addAFaceToDb($faceid, $facePlusid,$faceAge, $face_range, $gender, $glass, $race, $smiling, $pitch_angle,$roll_angle,$yaw_angle,$landmark) && $this->preInsertToEventDataSet($eventID,$faceid,$imageid)){
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
    public function addAImageToDb($imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate){
        try{
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO ImageDataSet (ImgID,ImgPathWithPrimalUrl,ImgPathWithResizeUrl,ImgPathWithIconUrl,ImgDate) VALUE (?,?,?,?,?)")){
               $stmt->bind_param('sssss',$imageid,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imgdate);
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
                    $array =array('ImgID'=>$ImgID, 'ImgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'ImgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'ImgPathWithIconUrl'=>$ImgPathWithIconUrl, 'ImgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude, 'faceID'=>$FaceID, 'FacePlusID'=>$FacePlusID,'Age'=>$Age, 'Age_range'=>$Age_range, 'Gender'=>$Gender, 'Glass'=>$Glass, 'Race'=>$Race, 'Smiling'=>$Smiling, 'Pitch_angle'=>$Pitch_angle, 'Roll_angle'=>$Roll_angle, 'Yaw_angle' => $Yaw_angle);
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
     *  query face landmarks via photoDataSet
     *  The return value contains {ImageID, $ImgPathWithPrimalUrl, $ImgPathWithResizeUrl, $ImgPathWithIconUrl, faceID, Age, Age_range, Gender, Glass, Race, Smiling, Pitch_angle, roll_angle, yaw_angle, facelandmark}
     */
    public function queryAllLFaces(){
        try{
            $object=array();

            if($stmt=$this->DataBaseCon->prepare("SELECT ImageDataSet.ImgID,ImageDataSet.ImgPathWithPrimalUrl,ImageDataSet.ImgPathWithResizeUrl,ImageDataSet.ImgPathWithIconUrl, ImageDataSet.ImgDate, EventDataSet.Longitude, EventDataSet.Latitude, FaceDataSet.FaceID, FaceDataSet.FacePlusID,FaceDataSet.Age, FaceDataSet.Age_range, FaceDataSet.Gender, FaceDataSet.Glass, FaceDataSet.Race, FaceDataSet.Smiling, FaceDataSet.Pitch_angle, FaceDataSet.Roll_angle, FaceDataSet.Yaw_angle FROM EventDataSet, FaceDataSet, ImageDataSet WHERE EventDataSet.FaceID = FaceDataSet.FaceID AND EventDataSet.ImgID = ImageDataSet.ImgID")){
                $stmt->execute();
                $stmt->bind_result($ImgID,$ImgPathWithPrimalUrl,$ImgPathWithResizeUrl,$ImgPathWithIconUrl,$ImgDate,$Longitude,$Latitude,$FaceID,$FacePlusID,$Age,$Age_range,$Gender,$Glass,$Race,$Smiling,$Pitch_angle,$Roll_angle,$Yaw_angle);
                while ($stmt->fetch())
                {
                    $array =array('ImgID'=>$ImgID, 'ImgPathWithPrimalUrl'=>$ImgPathWithPrimalUrl,'ImgPathWithResizeUrl'=>$ImgPathWithResizeUrl,'ImgPathWithIconUrl'=>$ImgPathWithIconUrl, 'ImgDate'=>$ImgDate, 'Longitude'=>$Longitude, 'Latitude'=>$Latitude, 'faceID'=>$FaceID, 'FacePlusID'=>$FacePlusID,'Age'=>$Age, 'Age_range'=>$Age_range, 'Gender'=>$Gender, 'Glass'=>$Glass, 'Race'=>$Race, 'Smiling'=>$Smiling, 'Pitch_angle'=>$Pitch_angle, 'Roll_angle'=>$Roll_angle, 'Yaw_angle' => $Yaw_angle);
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









}



?>