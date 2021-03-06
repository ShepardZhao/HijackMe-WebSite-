<?php
/**
 * Created by PhpStorm.
 * User: zhaoxun321
 * Date: 2/05/2014
 * Time: 8:19 PM
 */

class Image {
    //default settings
    private $destination;
    private $fileName;
    private $maxSize = '30048576'; // bytes (1048576 bytes = 1 meg)
    private $allowedExtensions = array('jpg','png','gif','JPG','PNG','GIF','jpeg','JPEG');
    private $type;
    private $nwidth;
    private $nheight;
    private $printError = TRUE;
    public $error = '';

    //START: Functions to Change Default Settings
    public function setDestination($newDestination) {
        $this->destination = $newDestination;
    }
    public function setFileName($newFileName) {
        $this->fileName = $newFileName;
    }
    public function setPrintError($newValue) {
        $this->printError = $newValue;
    }
    public function setMaxSize($newSize) {
        $this->maxSize = $newSize;
    }
    public function setAllowedExtensions($newExtensions) {
        if (is_array($newExtensions)) {
            $this->allowedExtensions = $newExtensions;
        }
        else {
            $this->allowedExtensions = array($newExtensions);
        }
    }
    //set type
    public function setType($type){
        $this -> type = $type;
    }

    //END: Functions to Change Default Settings

    //START: Process File Functions
    public function upload($file) {

        $this->validate($file);

        if ($this->error) {
            if ($this->printError) print $this->error;
        }
        else {
            move_uploaded_file($file['tmp_name'], $this-> getDestination().$this-> getfilename()) or $this->error .= 'Destination Directory Permission Problem.<br />';
            if ($this->error && $this->printError) print $this->error;
        }
    }
    public function delete($file) {

        if (file_exists($file)) {
            unlink($file) or $this->error .= 'Destination Directory Permission Problem.<br />';
        }
        else {
            $this->error .= 'File not found! Could not delete: '.$file.'<br />';
        }

        if ($this->error && $this->printError) print $this->error;
    }
    //END: Process File Functions

    //START: Helper Functions
    public function validate($file) {

        $error = '';

        //check file exist
        if (empty($file['name'])) $error .= 'No file found.<br />';
        //check allowed extensions
        if (!in_array($this->getExtension($file),$this->allowedExtensions)) $error .= 'Extension is not allowed.<br />';
        //check file size
        if ($file['size'] > $this->maxSize) $error .= 'Max File Size Exceeded. Limit: '.$this->maxSize.' bytes.<br />';

        $this->error = $error;
    }
    public function getExtension($file) {
        $filepath = $file['name'];
        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
        return $ext;
    }

    //Get attributes
    //get error info
    public function NonError(){
        if ($this -> error ==''){
            return true;
        }
        else{
            return false;
        }
    }

    //get Destination

    public function getDestination(){
        return $this -> destination;
    }

    //get filename
    public function getfilename(){
        return $this -> fileName;

    }

    //get size
    public function getfilesize(){
        return $this -> maxSize;

    }

    //get type
    public function getType(){
        return $this-> type;
    }

    //get newwidth
    public function getNewWidth(){
        return $this -> nwidth;
    }


    //get newheight
    public function getNewheight(){
        return $this -> nheight;
    }

    //get error message
    public function getErrorMessage(){
        return $this-> error;
    }
    //get createdtime
    public function getCreatedTime(){
       $getexif = read_exif_data($this->destination.$this -> fileName);
        if(isset($getexif['DateTime'])){
           return $getexif['DateTime'];
        }
        else{
           return date("Y-m-d", $getexif['FileDateTime']);
        }
    }

    //imagecopyresized to resize the image
    public function resize($tempfile,$dst_w,$dst_h,$resetName){

       // header('Content-type: image/jpeg');

// Load
       // $source = imagecreatefromjpeg($tempfile);

// Rotate
        //$rotate = imagerotate($source, 90, 0);

// Output
        //imagejpeg($rotate);

// Free the memory
        //imagedestroy($rotate);



        list($src_w,$src_h)=getimagesize($tempfile);  // get primitve image

        $dst_scale = $dst_h/$dst_w; //dst ratio
        $src_scale = $src_h/$src_w; // primitve ratio

        if ($src_scale>=$dst_scale){  // over height
            $w = intval($src_w);
            $h = intval($dst_scale*$w);

            $x = 0;
            $y = ($src_h - $h)/3;
        } else { // over wodht
            $h = intval($src_h);
            $w = intval($h/$dst_scale);

            $x = ($src_w - $w)/2;
            $y = 0;
        }

        //crop
        $source=imagecreatefromjpeg($tempfile);
        $croped=imagecreatetruecolor($w, $h);
        imagecopy($croped, $source, 0, 0, $x, $y, $src_w, $src_h);

        //resize
        $scale = $dst_w / $w;
        $target = imagecreatetruecolor($dst_w, $dst_h);
        $final_w = intval($w * $scale);
        $final_h = intval($h * $scale);
        $this -> nwidth = $final_w;
        $this -> nheight = $final_h;
        imagecopyresampled($target, $croped, 0, 0, 0, 0, $final_w,$final_h, $w, $h);


        //save
        imagejpeg($target, $this->getDestination().$resetName.$this -> getfilename());

        imagedestroy($target);

        //roate

        $this -> error ='';

    }



    //geolocation extra from image
    public function readGPSinfoEXIF()
    {
        $exif=read_exif_data($this->destination.$this->fileName);
        if(!$exif || $exif['GPSLatitude']== '') {
            return false;
        } else {

            //get the Hemisphere multiplier
            $LatM = 1; $LongM = 1;
            if($exif["GPSLatitudeRef"] == 'S')
            {
                $LatM = -1;
            }
            if($exif["GPSLongitudeRef"] == 'W')
            {
                $LongM = -1;
            }

            //get the GPS data
            $gps['LatDegree']=$exif["GPSLatitude"][0];
            $gps['LatMinute']=$exif["GPSLatitude"][1];
            $gps['LatgSeconds']=$exif["GPSLatitude"][2];
            $gps['LongDegree']=$exif["GPSLongitude"][0];
            $gps['LongMinute']=$exif["GPSLongitude"][1];
            $gps['LongSeconds']=$exif["GPSLongitude"][2];

            //convert strings to numbers
            foreach($gps as $key => $value)
            {
                $pos = strpos($value, '/');
                if($pos !== false)
                {
                    $temp = explode('/',$value);
                    $gps[$key] = $temp[0] / $temp[1];
                }
            }

            //calculate the decimal degree
            $result['latitude'] = $LatM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
            $result['longitude'] = $LongM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));




            $gps_int = array($result['latitude'], $result['longitude']);
            return $gps_int;
        }
    }

}
/**
 * End
 */

?>