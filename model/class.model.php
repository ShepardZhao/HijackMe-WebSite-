<?php
/**
 * class controller
 */
//import all class controller
require_once('conf.php');
require_once(DOCUMENT_ROOT.'/lib/sdk/php/facepp_sdk.php');
require_once('db.model.php');
require_once('Image.model.php');
require_once('db.op.model.php');
require_once('match.model.php');
require_once('general.model.php');
require_once('loginFaceMatch.model.php');
session_start();


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
$dbop = new DbOperateor($db);

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
 * $facepp api
 */
$facepp = new Facepp();
/**
 * end
 */


/**
 * $match class : compare two faces's land mark then found it similarity
 */


$match = new Match();

/**
 * end
 */


/**
 * $LoginFaceMatch class : compare the camera image to user images to found the best match to login
 */

$LoginFaceMatch = new LoginFaceMatch();


/**
 * end
 */




/**
 * end
 */
?>