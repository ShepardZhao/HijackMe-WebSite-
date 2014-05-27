<?php
require_once('../model/class.model.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $img = $_POST['loginImge'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    //take temp iamge
    file_put_contents('../faceImages/temp.png', $data);

    if(!empty($data)){
        //fetch all images from users
        $userArrays = $dbop -> queryAllUsers();
        if($userArrays){

            $userinfo=$LoginFaceMatch -> SetLoginMatch('../faceImages/temp.png',$userArrays);
            if($userinfo){
                $_SESSION['userSession']=$userinfo;
                echo json_encode(array('success'=>1,'message'=>$userinfo));

            }else{
                echo json_encode(array('success'=>0,'message'=>'did not find matched face'));
            }


        }

    }
    else{
        echo json_encode(array('success'=>0, 'message'=>'empty image linke'));
    }


}







?>