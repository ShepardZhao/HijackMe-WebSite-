<?php
require_once '../controller/class.controller.php';


if(isset($_POST['anysislyurl']) || isset($_POST['imagename'])&& $_POST['acid']==0){

#detect image by local
    #detect image by url
    $params=array('url'=>$_POST['anysislyurl']);
    $response = $facepp->execute('/detection/detect',$params);
    print_r($response);

    if($response['http_code']==200){
        #json decode
        $data = json_decode($response['body'],1);
        #get face landmark
        foreach ($data['face'] as $face) {
            $response = $facepp->execute('/detection/landmark',array('face_id'=>$face['face_id']));
            print_r($response);
        }
        #create person
       $response = $facepp->execute('/person/create',array('person_name'=>'unique_person_name'));
       print_r($response);

        #delete person
       $response = $facepp->execute('/person/delete',array('person_name'=>'unique_person_name'));
       print_r($response);

    }
}



?>