<?php
   if($_SERVER['REQUEST_METHOD']==='POST'){

/**
 *
 * img model
 *
 */
    require_once '../controller/class.controller.php';

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

    //resize image and save again
    //

    if($image -> Error()){
        //add current to database
        echo json_encode(array('success'=>1, 'id'=> $general -> getgenerateID('img'),'name'=>$image-> getfilename(),'GPSLatitudeRef'=>$image->readGPSinfoEXIF(),'width'=>$image->getNewWidth(),'height'=>$image->getNewheight(),'createdDate'=>$image->getCreatedTime(),'imgtype'=>$image ->getType(), 'imgsize'=>$image->getfilesize(), 'imageabpath'=>'../faceImages/'.$image-> getfilename(),'imagepath'=>Actual_Link.'/faceImages/'.$image-> getfilename()));
        $image -> resize('../faceImages/'.$image-> getfilename(),400,300);

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