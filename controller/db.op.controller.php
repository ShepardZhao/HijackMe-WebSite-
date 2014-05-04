<?php
class DbOperateor extends DataBase{
    //attributes
    private $DataBaseCon=null;
    //constructor
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    /**
     * Image operation functions
     */
    //add image to database
    public function addImageToDb($imageid,$imagepath,$imagetime,$imgwidth,$imgheight,$imgdate,$longitude,$latitude){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO ImageDataSet (ImgID,ImgPath,ImgWidth,ImgHeight,ImgDate,Longitude,Latitude) VALUE (?,?,?,?,?,?,?)")){
           $stmt->bind_param('ssiisdd',$imageid,$imagepath,$imagetime,$imgwidth,$imgheight,$imgdate,$longitude,$latitude);
           $stmt->execute();
           $stmt->close();
           return true;
        }

    }



    /**
     * end
     */





}



?>