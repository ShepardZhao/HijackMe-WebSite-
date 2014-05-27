<?php
require_once('../model/class.model.php');

if($_SERVER['REQUEST_METHOD']==='POST'){

    $userSession = $_SESSION['userSession']['userID'];

    //if passed json data is not empty
    if(isset($_POST['imgjson'])){
        $getarray=$_POST['imgjson'];

        if(isset($getarray['imageAbsolutePathWithPrimal'])){

            $params=array('img'=>$getarray['imageAbsolutePathWithPrimal']);
            $params['attribute'] = 'gender,age,race,smiling,glass,pose';
            $response = $facepp->execute('/detection/detect',$params);


            if($response['http_code']==200){
                #json decode
                $data = json_decode($response['body'],1);
                #get face landmark
                if(empty($data['face'])){



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
                        $result  = $dbop -> InterNonFace_witoutGeolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession,$eventID);


                    }
                    else{
                        $image_Longitude = $getarray['GPSLatitudeRef'][1];
                        $image_Latitude = $getarray['GPSLatitudeRef'][0];
                        //here to preate to get address name
                        $geolocationComponent = $general->geolocationToAddress($image_Longitude,$image_Latitude)[0];
                        $locationID = $general->getgenerateMd5ID('location'.$getarray['imageAbsolutePathWithPrimal']);
                        $result  = $dbop -> InterNonFaceWhithGeolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession,$eventID,$image_Longitude,$image_Latitude,$locationID,$geolocationComponent);


                    }

                    /**
                     * end
                     */


                    //if the current the photo is not a face then we simply assume that could be a landspace or a view
                    if($result){

                        echo json_encode(array('success'=>1,'nonface'=>1,'message'=>$getarray));
                    }
                    else{
                        echo json_encode(array('success'=>0,'error'=>'fatal issue'));
                    }

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
                        $result  = $dbop -> InterfaceInsert_witoutGeolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession,$faceID,$facePlusID,$ageValue, $ageRange, $gender, $glass, $race, $smiling, $pose_pitch_angle,$pose_roll_angle,$pose_yaw_angle,$encode_josn_landmark,$eventID);


                    }
                    else{
                        $image_Longitude = $getarray['GPSLatitudeRef'][1];
                        $image_Latitude = $getarray['GPSLatitudeRef'][0];
                        $locationID = $general->getgenerateMd5ID('location'.$getarray['imageAbsolutePathWithPrimal']);

                        //here to preate to get address name
                        $geolocationComponent = $general->geolocationToAddress($image_Longitude,$image_Latitude)[0];
                        $result  = $dbop -> InterfaceInsert_Geolocation($imageID,$imagePathWithPrimalUrl,$imagePathWithResizeUrl,$imagePathWithIconUrl,$imagedate,$userSession,$faceID,$facePlusID,$ageValue, $ageRange, $gender, $glass, $race, $smiling, $pose_pitch_angle,$pose_roll_angle,$pose_yaw_angle,$encode_josn_landmark,$eventID,$image_Longitude,$image_Latitude,$locationID,$geolocationComponent);


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

                            echo json_encode(array('success'=>1, 'nonface'=>0,'message'=>$getcurrentFace));

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
                echo json_encode(array('success'=>0,'error'=>'network error'));

            }



        }



    }

}



?>