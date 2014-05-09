<?php
require_once '../model/class.model.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $facePlusID = $_POST['FacePlusID'];
    //query all photo
    $getarray = $dbop -> queryAllLFaces();

    if($getarray){
        //put $getarray into matching function
        $Matchresult = $match -> GetRestultOfMatch($facePlusID,$getarray);

        //if the count of $result is more than 0 means current is not new
        $count = count($Matchresult);
        if($count>0){
            //found matched result, and return current photo info and matched result
            echo json_encode(array('success'=>1,'number'=>$count, 'result'=>$Matchresult));


        }
        elseif ($count==0){
            //did not found matched result
            echo json_encode(array('success'=>1,'number'=>0));

        }
        else{
            echo json_encode(array('success'=>0,'error'=>'unknow resaon'));

        }
    }
    else{
        echo json_encode(array('success'=>0,'error'=>'error, there is not record couled be found'));

    }

}
?>