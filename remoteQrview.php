
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Hijack(an online image management system)</title>

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/foundation.min.css">
    <link rel="stylesheet" href="assets/css/jquery.fancybox.css?v=2.1.5"/>
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="lib/sdk/js/jquery.fancybox.pack.js?v=2.1.5"></script>



</head>
<body style="background:rgb(250,250,250)">
<?php
require_once('model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='GET'){

$getviewerID = $_GET['qrId'];
if(!empty($getviewerID)){

    echo '<div class="row">';
    echo '<div class="small-12 columns" style="margin-top:29px">';
    echo '<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">';

    $getImageResult = $dbop->queryQRbyItsID($getviewerID);

  foreach ($getImageResult as $value){
      echo '<li><a class="fancybox" rel="group" href='.$value['imgPathWithPrimalUrl'].'><img src='.$value['imgPathWithResizeUrl'].'></a></li>';
  }
    echo '</ul>';
    echo '<div>';
    echo '</div>';

    }
}


?>
</body>
</html>
