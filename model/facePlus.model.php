<?php
require_once '../controller/class.controller.php';


if($_SERVER['REQUEST_METHOD']==='POST'){

    //if passed json data is not empty
    if(isset($_POST['imgjson'])){
        $getarray=$_POST['imgjson'];

        if(isset($getarray['imageabpath'])){
            //pass the image to face++ to check whether a face
           // $params=array('url'=>$getarray['imagepath']);
            //$response = $facepp->execute('/detection/detect',$params);

            $params=array('img'=>$getarray['imageabpath']);
            $params['attribute'] = 'gender,age,race,smiling,glass,pose';
            $response = $facepp->execute('/detection/detect',$params);


            if($response['http_code']==200){
                #json decode
                $data = json_decode($response['body'],1);
                #get face landmark
                if(empty($data['face'])){
                    //delete the img from the disk
                    $image -> delete($getarray['imageabpath']);
                    //echo josn result because delete file is unsuccessed
                     echo json_encode(array('success'=>0,'error'=>$image->getErrorMessage()));

                }
                else{
                    //if has face infomation then goes to next step

                    //insert record into the database
                    echo json_encode(array('success'=>1,'data'=>$data));

                    /**
                    if($dbop->addImageToDb()){

                    }
                    else{
                        echo json_encode(array('success'=>0,'error'=>'Insert record error'));

                    }
        **/




                }
                //foreach ($data['face'] as $face) {


                    //$response = $facepp->execute('/detection/landmark',array('face_id'=>$face['face_id']));
                    //print_r($response);
                //}


            }
        }



    }

/**
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

**/
}



?>