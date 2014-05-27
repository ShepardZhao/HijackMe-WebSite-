<?php

require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $getSingUpEmail= $_POST['regEmail'];
    $getSingUpPassword1=$_POST['regPassword1'];
    $getSingUpPassword2 = $_POST['regPassword2'];
    $getSingUpImge = $_POST['regImg'];
    if(!empty($getSingUpEmail) && !empty($getSingUpPassword1) && !empty($getSingUpPassword2)){

        if($getSingUpPassword1===$getSingUpPassword2){
            //singUp a user
           if($dbop -> registerUser($general->getgenerateMd5ID($getSingUpEmail),$getSingUpEmail,md5($getSingUpPassword1),$getSingUpImge)){
               echo json_encode(array("success"=>1,"message"=>"you have successfully registerd"));
           }
           else{
               echo json_encode(array("success"=>0,"message"=>"fatal error"));

           }


        }
        else{
            echo json_encode(array("success"=>0,"message"=>"you password does not match"));
        }
    }


    else{
        echo json_encode(array("success"=>0,"message"=>"please filled all fields"));
    }

}


?>