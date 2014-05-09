<?PHP
require_once 'facepp_sdk.php';
########################
###     example      ###
########################
$facepp = new Facepp();
$faceID_1= 'a92bd4a953e9ac653524d3495c1ee949';
$faceID_2= 'd2809ed5eddd27f89518088c617f0e09';

#detect image by url
$params=array('url'=>'http://hijackme.tk/faceImages/480556_372834519436741_82175681_n.jpg');
$params['attribute'] = 'gender,age,race,smiling,glass,pose';

$response = $facepp->execute('/detection/detect',$params);

if($response['http_code']==200){
    #json decode
    $data = json_decode($response['body'],1);
    #get face landmark



    $landresponse = $facepp->execute('/detection/landmark',array('face_id'=>$data['face'][0]['face_id'],'type'=>'25p'));

    $landmarkArray = json_decode($landresponse['body'],1);
    $landmark = $landmarkArray['result'][0]['landmark'];

   $faceDataAttribute = $data['face'][0]['attribute'];
   $ageRange = $faceDataAttribute['age']['range'];
   $ageValue= $faceDataAttribute['age']['value'];
   $gender = $faceDataAttribute['gender']['value'];
   $race = $faceDataAttribute['race']['value'];
   $smiling =$faceDataAttribute['smiling']['value'];
   $glass = $faceDataAttribute['glass']['value'];
   $pose_pitch_angle  = $faceDataAttribute['pose']['pitch_angle']['value'];
   $pose_roll_angle  = $faceDataAttribute['pose']['roll_angle']['value'];
   $pose_yaw_angle  = $faceDataAttribute['pose']['yaw_angle']['value'];
   $encode_josn_landmark = serialize($landmark);




    print_r(array('age'=>$ageValue.'+_'.$ageRange,'gender'=>$gender,'glass'=>$glass,'race'=>$race,'smiling'=>$smiling,'pose_pitch_angle'=>$pose_pitch_angle,'pose_roll_angle'=>$pose_roll_angle,'pose_yaw_angle'=>$pose_yaw_angle,'encode_josn_landmark'=>$encode_josn_landmark));
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';


    $compareresponse = $facepp->execute('/recognition/compare',array('face_id2'=>$faceID_2,'face_id1'=>$faceID_1));

    //print_r($data);




    //$left_eye_bottom_x =$landmark['left_eye_bottom']['x'];
    //$left_eye_bottom_y =$landmark['left_eye_bottom']['y'];
    //$left_eye_center_x =


    var_export($faceDataAttribute);

  // var_export($data['face']);


}

/**
 *  foreach ($data['face'] as $face) {
$response = $facepp->execute('/detection/landmark',array('face_id'=>$face['face_id']));
print_r($response);
}
#create person
$response = $facepp->execute('/person/create',array('person_name'=>'unique_person_name'));
print_r($response);

#delete person
$response = $facepp->execute('/person/delete',array('person_name'=>'unique_person_name'));
print_r($response);

 */