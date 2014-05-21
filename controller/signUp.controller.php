<?php

require_once '../model/class.model.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $getSingUpEmail= $_POST['regEmail'];
    $getSingUpPassword1=$_POST['regPassword1'];
    $getSingUpPassword2 =  $_POST['regPassword2'];

    if(isset($getSingUpEmail) && isset($getSingUpPassword1) && isset($getSingUpPassword2)){

        if($getSingUpPassword1===$getSingUpPassword2){

        }

    }
    else{
        echo json_encode(array("success"=>0,"message"=>"please filled all fields"));
    }

}


?>