<?php
require_once('../model/class.model.php');
   if($_SERVER['REQUEST_METHOD']==='POST'){

/**
 *
 * img model
 *
 */

    /**
     * local photo uploading -> from image.controller.php. the object is $Image
     */

    //set destination
    $image -> setDestination('../faceImages/');
    //set file name
    $image -> setFileName($_FILES['uploadfile']["name"]);
    //set print error
    $image -> setPrintError($_FILES['uploadfile']["error"]);
    //set max size
    $image -> setMaxSize($_FILES['uploadfile']["size"]);
    //set type
    $image -> setType($_FILES['uploadfile']["type"]);
    //upload un-resize image
    $image -> upload($_FILES['uploadfile']);

    $getFileName =$image-> getfilename();

    //getGloactionfirst
    $gelocation = $image ->readGPSinfoEXIF('../faceImages/'.$getFileName);

    //getltimestamp
    $getstmap = $image -> getCreatedTime('../faceImages/'.$getFileName);

    //resize image and save again ---
    $image -> resize('../faceImages/'.$getFileName,400,300,'_resize'); //first resize is orginal photo

    $image -> resize('../faceImages/'.$getFileName,80,60,'_icon'); //for google map display (marker)

    if($image -> NonError()){
        //add current to database
        echo json_encode(array('success'=>1, 'id'=> $general -> getgenerateMd5ID('img'.$getFileName),'name'=>$getFileName,'GPSLatitudeRef'=>$gelocation,'createdDate'=>$getstmap,'imgtype'=>$image ->getType(), 'imgsize'=>$image->getfilesize(), 'imageAbsolutePathWithPrimal'=>'../faceImages/'.$getFileName,'imageAbsolutePathWithResize'=>'../faceImages/'.'_resize'.$getFileName,'imageAbsolutePathWithIcon'=>'../faceImages/'.'_icon'.$getFileName,'imagePathWithResizeUrl'=>Actual_Link.'/faceImages/_resize'.$getFileName, 'imagePathWithIconUrl'=> Actual_Link.'/faceImages/_icon'.$getFileName,'imagePathWithPrimalUrl'=> Actual_Link.'/faceImages/'.$getFileName));

    }
    else{
        $image -> delete('../faceImages/'.$getFileName);
        echo json_encode(array('success'=>0,'error'=>$getFileName));
    }

/**
 * end
 */
   }


?>