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
    //resize image and save again
    $image -> resize('../faceImages/'.$image-> getfilename(),400,300);


    if($image -> getError()){
        //get img id
       $getimgid = $general -> getgenerateID('img'); //imgid
       $getnew_width = $image -> getNewWidth(); //img latest width
       $getnew_height = $image -> getNewheight();//img latest height
       $getimgtime = $image -> getCreatedTime();
        //add current image to db


        echo json_encode(array('success'=>1, 'data'=>$getimgtime,'imgtype'=>$image ->getType(), 'imgsize'=>$image->getfilesize(), 'imagepath'=>Actual_Link.'/faceImages/'.$image-> getfilename()));
    }
    else{
        $image -> delete('../faceImages/'.$image->getfilename());
        echo json_encode(array('success'=>0));
    }

/**
 * end
 */
}

?>