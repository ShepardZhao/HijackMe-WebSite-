<?php
session_start();
if(!empty($_SESSION['userSession'])){
    session_unset();
    session_destroy();
    $_SESSION = array();
    header('Location: index.php');
}
?>