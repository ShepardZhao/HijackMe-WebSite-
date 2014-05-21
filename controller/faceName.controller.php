<?php
require_once '../model/class.model.php';
if($_SERVER['REQUEST_METHOD']==='POST'){

    if(isset($_POST['faceID'])&& isset($_POST['facePlusID'])&&isset($_POST['name'])){
       if($dbop -> insertNameForNewPhoto($_POST['faceID'],$_POST['facePlusID'],$_POST['name'])){
           echo json_encode(array('success'=>1));
       }
        else{
           echo json_encode(array('success'=>0));

        }
    }
    else{
        echo json_encode(array('success'=>0));

    }



}


?>