<?php
require_once('../model/class.model.php');


if($_SERVER['REQUEST_METHOD']==='GET'){
    $getSession = $_SESSION['userSession'];
    $AllImagebyUser = $dbop -> queryAllImageByUserId($getSession['userID']);

    var_dump($AllImagebyUser);



}




?>