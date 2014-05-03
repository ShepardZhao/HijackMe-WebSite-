<?php
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
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
    $Image -> setDestination('../faceImages/');
    //set file name
    $Image -> setFileName($_FILES['uploadfile']["name"]);
    //set print error
    $Image -> setPrintError($_FILES['uploadfile']["error"]);
    //set max size
    $Image -> setMaxSize($_FILES['uploadfile']["size"]);
    //set type
    $Image -> setType($_FILES['uploadfile']["type"]);
    //upload un-resize image
    $Image -> upload($_FILES['uploadfile']);
    //resize image and save again
    $Image -> resize('../faceImages/'.$Image-> getfilename(),400,300);


    if($Image -> getError()){
        echo json_encode(array('success'=>1,'imgtype'=>$Image ->getType(), 'imgsize'=>$Image->getfilesize(), 'imagepath'=>Actual_Link.'/faceImages/'.$Image-> getfilename()));
    }
    else{
        $Image -> delete($_FILES['uploadfile']);
        echo json_encode(array('success'=>0));
    }


/**
 * end
 */
}

?>