<?php
require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $getSession = $_SESSION['userSession'];
    $getUserID = $getSession['userID'];
    $getAllImageThatContaintedGeoLoacitonByUserID = $dbop ->getAllImageThatContaintedGeoLoacitonByUserID($getUserID);
    if($getAllImageThatContaintedGeoLoacitonByUserID){
        echo json_encode(array('success'=>1, 'message'=>$getAllImageThatContaintedGeoLoacitonByUserID));
    }else{
        echo json_encode(array('success'=>0,'message'=>'It seems you do not photos that contain geolocations'));
    }


}








?>