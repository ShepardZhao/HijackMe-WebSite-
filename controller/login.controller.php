<?php
require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $getLogin = $_POST['loginEmail'];
    $getLoginPassword= $_POST['LoginPassword'];

    if(!empty($getLogin) && !empty($getLoginPassword)){

        //pass the login Email and password to check
        $loginArray =$dbop -> loginCheck($getLogin,$getLoginPassword);
        if($loginArray){
            //after success login then given the session for it
            $_SESSION['userSession'] = $loginArray[0];
            echo json_encode(array("success"=>1));
        }
        else{
            echo json_encode(array("success"=>0,"message"=>"username or password does not match"));
        }
    }
    else{
        echo json_encode(array("success"=>0,"message"=>"The field is empty"));

    }


}
?>