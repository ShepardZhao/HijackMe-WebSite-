<?php include_once 'header.php'?>
<?php

if(!empty($_SESSION['userSession'])){
    header( 'Location: index.php');
}
else{
?>
    <div class="row text-center verticalAndHorCenter">
        <div class="large-4 columns small-12 medium-6 text-center" id="portal1">
            <a href="signUp.php" id="SignIn" data-reveal-id="form"  data-reveal-ajax="true"><img   src="assets/img/register.png"><br><h5 class="color_white">Register</h5></a>
        </div>
        <div class="large-4 columns small-12 medium-6 text-center" id="portal3">
            <a href="signIn.php" id="SignIn" data-reveal-id="form"  data-reveal-ajax="true"><img   src="assets/img/login.png"><br><h5 class="color_white">Login by Passowrd</h5></a>
        </div>
        <div class="large-4 columns small-12 text-center" id="portal2">
            <a class="hide-for-small hide-for-medium" href="faceDectection_camera.php" data-reveal-id="video_modal" data-reveal-ajax="true" ><img  src="assets/img/faceLogin.png"><br><h5 class="color_white">Login by FaceDectection</h5></a>
        </div>
    </div>


<?php }?>
<?php include_once 'footer.php'?>