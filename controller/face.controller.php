<?php
require_once '../model/class.model.php';


if($_SERVER['REQUEST_METHOD']==='POST'){

    //if passed json data is not empty
    if(isset($_POST['imgjson'])){
        $getarray=$_POST['imgjson'];

        if(isset($getarray['imageAbsolutePathWithResize'])){
            //pass the image to face++ to check whether a face
           // $params=array('url'=>$getarray['imagepath']);
            //$response = $facepp->execute('/detection/detect',$params);


            $params=array('img'=>$getarray['imageAbsolutePathWithResize']);
            $params['attribute'] = 'gender,age,race,smiling,glass,pose';
            $response = $facepp->execute('/detection/detect',$params);


            if($response['http_code']==200){
                #json decode
                $data = json_decode($response['body'],1);
                #get face landmark
                if(empty($data['face'])){
                    //delete the img from the disk
                    $image -> delete($getarray['imageAbsolutePathWithResize']);
                    $image -> delete($getarray['imageAbsolutePathWithPrimal']);
                    $image -> delete($getarray['imageAbsolutePathWithIcon']);

                    //echo josn result because delete file is unsuccessed
                     echo json_encode(array('success'=>0,'error'=>$image->getErrorMessage()));

                }
                else{

                    /**
                     * gets face info
                     */
                    //prepare face info
                    $faceDataAttribute = $data['face'][0]['attribute'];
                    //fectchs face info with sinlge value every time
                    $facePlusID = $data['face'][0]['face_id'];
                    $faceID = $general -> getgenerateMd5ID('face'.$getarray['imageAbsolutePathWithPrimal']);
                    $ageValue= $faceDataAttribute['age']['value'];
                    $ageRange = $faceDataAttribute['age']['range'];
                    $gender = $faceDataAttribute['gender']['value'];
                    $glass = $faceDataAttribute['glass']['value'];
                    $race = $faceDataAttribute['race']['value'];
                    $smiling =$faceDataAttribute['smiling']['value'];
                    $pose_pitch_angle  = $faceDataAttribute['pose']['pitch_angle']['value'];
                    $pose_roll_angle  = $faceDataAttribute['pose']['roll_angle']['value'];
                    $pose_yaw_angle  = $faceDataAttribute['pose']['yaw_angle']['value'];


                    //gets landmark
                    $landresponse = $facepp->execute('/detection/landmark',array('face_id'=>$data['face'][0]['face_id'],'type'=>'25p'));
                    $landmarkArray = json_decode($landresponse['body'],1);
                    $landmark = $landmarkArray['result'][0]['landmark'];
                    $encode_josn_landmark = serialize($landmark);

                    /**
                     * end
                     */


                    /**
                     * gets image info
                     */
                    //prepare to insert the image
                    $imageID =$getarray['id'];
                    $imagePathWithIconUrl = $getarray['imagePathWithIconUrl'];
                    $imagePathWithPrimalUrl = $getarray['imagePathWithPrimalUrl'];
                    $imagePathWithResizeUrl = $getarray['imagePathWithResizeUrl'];

                    $imagedate = $getarray['createdDate'];

                    /**
                     * end
                     */


                    /**
                     * gets event id
                     */
                     $eventID = $general-> getgenerateMd5ID('event'.$getarray['imageAbsolutePathWithPrimal']);
                    /**
                     * end
                     */



                    /**
                     * prepare event if gelocation is not empty
                     */
                    if($getarray['GPSLatitudeRef']=='false'){

                        //prepare to insert the data that witout geolocation
                        $result  = $dbop -> InterfaceInsert_witoutGeolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$faceID,$facePlusID,$ageValue, $ageRange, $gender, $glass, $race, $smiling, $pose_pitch_angle,$pose_roll_angle,$pose_yaw_angle,$encode_josn_landmark,$eventID);


                    }
                    else{
                        $image_Longitude = $getarray['GPSLatitudeRef'][1];
                        $image_Latitude = $getarray['GPSLatitudeRef'][0];
                        //here to preate to get address name



                        //prepare to inser the data that contains geolocation


                        //

                    }

                    /**
                     * end
                     */


                    //query record from database
                    if($result){
                        // if $result return true means that inserting data is successfully
                        $getcurrentFace =$dbop -> queryCurrentSingleFaceID($faceID);


                        if($getcurrentFace){

                            echo json_encode(array('success'=>1, 'currentFaceInfo'=>$getcurrentFace));

                        }
                        else{
                            echo json_encode(array('success'=>0,'error'=>'error, there is not record couled be found'));

                        }



                    }
                    else{

                            echo json_encode(array('success'=>0,'error'=>'error to insert record'));
                        //delete the img from the disk
                        $image -> delete($getarray['imageAbsolutePathWithResize']);
                        $image -> delete($getarray['imageAbsolutePathWithPrimal']);
                        $image -> delete($getarray['imageAbsolutePathWithIcon']);

                    }

                }
            }

            else{
                //delete the img from the disk
                $image -> delete($getarray['imageAbsolutePathWithResize']);
                $image -> delete($getarray['imageAbsolutePathWithPrimal']);
                $image -> delete($getarray['imageAbsolutePathWithIcon']);
            }


        }



    }

}



?>