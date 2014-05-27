<?php
require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='GET'){
    $getQuerySelectedImageIDArray= explode(",", $_GET['imgIDArray']);
    if($getQuerySelectedImageIDArray){
        $imageList=[];
        foreach($getQuerySelectedImageIDArray as $value){
                array_push($imageList,$dbop->getImageByItsID($value));
        }

        if($imageList){
           echo  json_encode(array('success'=>1,'message'=>$imageList));

        }
        else{
            echo json_encode(array('success'=>0,'message'=>'fatal error'));

        }


    }
    else{
        echo json_encode(array('success'=>0,'message'=>'not image id'));
    }

}

//ready to generate the QR code
else if ($_SERVER['REQUEST_METHOD']==='POST'){
    $getImageIDArray= $_POST['imgIDArray'];
    $getQRName=$_POST['QrName'];
    if(!empty($getImageIDArray) && !empty($getQRName)){

        //get userID
        $userSession = $_SESSION['userSession']['userID'];


        //generate qr id
        $getQrid = $general -> getgenerateMd5ID($general->getTime());

        //generate the qr link
        $requestUrl = QRPATCH.'?qrId='.$getQrid;
        $getQrCodeUrl = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=".$requestUrl;

        //insert into database
        $insertResult = $dbop->insertQrReocrd($getQrid,$getQrCodeUrl,$getQRName,serialize($getImageIDArray),$userSession);
        if($insertResult){
            echo json_encode(array('success'=>1,'message'=>$getQrCodeUrl,'qrName'=>$getQRName));
        }
        else{
            echo json_encode(array('success'=>0,'message'=>'add record failed'));

        }



    }
    else{
        echo json_encode(array('success'=>0,'message'=>'not image id'));

    }








}

?>