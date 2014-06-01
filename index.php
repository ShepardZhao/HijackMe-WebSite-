<?php include_once 'header.php'?>
<?php
if(empty($_SESSION['userSession'])){
    header( 'Location: portal.php');
}
else{

?>
        <!-- containter begins--->
       <!-- avatar begins-->
    <div class="row"><div class="large-12 large-12 medium-12 columns divgap"></div></div>

    <div class="row text-center">

          <div class="large-12 columns small-12 text-center" id="avatar">
              <?php if(empty($_SESSION['userSession']['userPhoto'])) {?>
              <img id="logo" style="display:none"  data-dropdown="userFnlist" src="/assets/img/no_avatar.png" >
              <?php }else{?>
              <img id="logo" style="display:none"  class="icon" data-dropdown="userFnlist" src="<?php echo $_SESSION['userSession']['userPhoto'] ?>" >
              <?php } ?>

              <ul id="userFnlist" class="f-dropdown" data-dropdown-content>
                  <li><a href="logout.php">Logo Out</a></li>

              </ul>
          </div>
      </div>
        <!-- avatar ends -->

        <!-- div gap begins -->
      <div class="row"><div class="large-12 large-12 medium-12 columns divgap"></div></div>
        <!-- div gap ends-->

      <!-- Three-up Content Blocks begins-->
      <div class="row text-center" style="display:none" id="beginsShow">
          <!----- for desktop and table only ----->
              <div class="large-4  medium-4 columns">
                  <a class="button Customerbutton" href="faceDectection_photoupload.php" data-reveal-id="Common_modal"   data-reveal-ajax="true" ><h2 class="whitecolor"><i class="fa fa-crosshairs fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">Photo Uploading</h4>
              </div>



              <div class=" large-4 medium-4 columns" >
                  <a href="PhotoInventroy.php" data-reveal-id="Common_modal"  id="click_toPhotoStore" data-reveal-ajax="true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-picture-o fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">Photo Store</h4>

              </div>

              <div class="large-4 medium-4 columns">
                  <a href="QRInventory.php"  data-reveal-id="Common_modal" data-reveal-ajax="true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-qrcode fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">QR Inventory</h4>
              </div>
          <!--- desktop end--->



    </div>



     <!-- Three-up Content Blocks ends-->

   <footer>
        <div class="row">
            <div class="large-12 small-12 medium-12 columns text-center divgap">
                <p><i data-tooltip  title="This is demo program!" style="display:none" class="has-tip tip-top fa fa-exclamation-circle fa-2x whitecolor"></i></p>
            </div>
        </div>
   </footer>







        <!--- containter end --->
<?php }?>
<?php include_once 'footer.php'?>

