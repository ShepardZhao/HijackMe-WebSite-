<?php
require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $getRequest = $_POST['queryAll'];
    if($getRequest){
        $getSession = $_SESSION['userSession'];
        $getUserID = $getSession['userID'];

        //get all face by user ID
        $queryALlfaces = $dbop -> queryAllFacesByuserID($getUserID);

        //get all image that does not contain face
        $queryAllNonfaces = $dbop -> queryAllNonface($getUserID);
        $getAllresult = array_merge($queryALlfaces,$queryAllNonfaces);


        if(count($getAllresult)>0){
            echo json_encode(array('success'=>1,'message'=>$getAllresult));
        }
        else{
            echo json_encode(array('success'=>0,'message'=>'It looks like you do not have the photos currently'));
        }


    }
    else{
        echo json_encode(array('success'=>0,'message'=>'fatal error'));
    }





}




?>