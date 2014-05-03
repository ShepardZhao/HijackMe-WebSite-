<?php
/**
 * class controller
 */
//import all class controller
require_once '../conf.php';
require_once 'db.controller.php';
require_once 'image.controller.php';
require_once '../lib/sdk/php/facepp_sdk.php';


//inital class

/**
 * $db class : database connection
 */

$Db = new DataBase(HostName,UserName,Password,Database);
/**
 * end
 */

/**
 * $Image class : upload the file to local, and simple image operation such as crop and resize
 */
$Image = new Image();

/**
 * end
 */


/**
 * $facepp
 */
$facepp = new Facepp();
/**
 * end
 */

/**
 * end
 */
?>