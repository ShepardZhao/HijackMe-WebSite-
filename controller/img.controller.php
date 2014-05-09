<?php
   if($_SERVER['REQUEST_METHOD']==='POST'){

/**
 *
 * img model
 *
 */
    require_once '../model/class.model.php';

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

    //getGloactionfirst
    $gelocation = $image ->readGPSinfoEXIF('../faceImages/'.$image-> getfilename());

    //getltimestamp
    $getstmap = $image -> getCreatedTime('../faceImages/'.$image-> getfilename());

    //resize image and save again ---
    $image -> resize('../faceImages/'.$image-> getfilename(),400,300,'_resize'); //first resize is orginal photo

    $image -> resize('../faceImages/'.$image-> getfilename(),80,60,'_icon'); //for google map display (marker)

    if($image -> NonError()){
        //add current to database
        echo json_encode(array('success'=>1, 'id'=> $general -> getgenerateMd5ID('img'.$image-> getfilename()),'name'=>$image-> getfilename(),'GPSLatitudeRef'=>$image->readGPSinfoEXIF(),'createdDate'=>$image->getCreatedTime(),'imgtype'=>$image ->getType(), 'imgsize'=>$image->getfilesize(), 'imageAbsolutePathWithPrimal'=>'../faceImages/'.$image-> getfilename(),'imageAbsolutePathWithResize'=>'../faceImages/'.'_resize'.$image-> getfilename(),'imageAbsolutePathWithIcon'=>'../faceImages/'.'_icon'.$image-> getfilename(),'imagePathWithResizeUrl'=>Actual_Link.'/faceImages/_resize'.$image-> getfilename(), 'imagePathWithIconUrl'=> Actual_Link.'/faceImages/_icon'.$image-> getfilename(),'imagePathWithPrimalUrl'=> Actual_Link.'/faceImages/_prim'.$image-> getfilename()));

    }
    else{
        $image -> delete('../faceImages/'.$image->getfilename());
        echo json_encode(array('success'=>0,'error'=>$image->getErrorMessage()));
    }

/**
 * end
 */
   }


?>