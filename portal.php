<?php include_once 'header.php'?>
<div class="row verticalAndHorCenter" >


    <div class="row text-center">

        <div class="large-12 columns small-12 text-center" id="avatar">
            <img id="logo" style="display:none"  src="assets/img/logo.png" data-dropdown="loginAndRegister" data-options="is_hover:true">
        </div>

        <ul id="loginAndRegister" class="f-dropdown" data-dropdown-content >
            <li><a href="signIn.php" id="SignIn" data-reveal-id="form"  data-reveal-ajax="true">Sign In</a></li>
            <li><a href="signUp.php" data-reveal-id="form" data-reveal-ajax="true" >Sign Up</a></li>
            <li class="hide-for-small-only"><a href="faceDectection_camera.php" data-reveal-id="Common_modal" data-reveal-ajax="true" >Login by FaceDectection</a></li>
        </ul>
    </div>

</div>



<?php include_once 'footer.php'?>