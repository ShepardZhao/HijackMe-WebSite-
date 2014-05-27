<?php
require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
      $getEvent = $_POST['event'];
      $getImageId = $_POST['imgID'];
      if($getEvent && $getImageId){
          $condition = $dbop -> updateEvent($getEvent,$getImageId);
          if($condition){
             echo  json_encode(array('success'=>1,'message'=>'updated successfully'));
          }
          else{
            echo  json_encode(array('success'=>0,'message'=>'update fail'));
          }
      }
      else{
        echo  json_encode(array('success'=>0,'message'=>'update fail'));
      }


}




?>