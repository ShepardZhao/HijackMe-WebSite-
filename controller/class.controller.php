<?php
/**
 * class controller
 */
//import all class controller
require_once '../conf.php';
require_once 'db.controller.php';
require_once 'Image.controller.php';
require_once 'db.op.controller.php';
require_once 'general.controller.php';
require_once '../lib/sdk/php/facepp_sdk.php';


//inital class

/**
 * $General class : generate the time id for item
 */
$general = new General(time());

/**
 * end
 */

/**
 * $db class : database connection
 */

$db = new DataBase(HostName,UserName,Password,Database);
/**
 * end
 */


/**
 * Db operator class : database operation
 */
$dbop = new DbOperateor($Db);

/**
 * end
 */


/**
 * $Image class : upload the file to local, and simple image operation such as crop and resize
 */
$image = new Image();

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