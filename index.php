<?php include_once 'header.php'?>
<?php
if(empty($_SESSION['userSession'])){
    header( 'Location: portal.php');
}
else{

?>
        <!-- containter begins--->
    <div class="row container text-center ">
       <!-- avatar begins-->
      <div class="row text-center">

          <div class="large-12 columns small-12 text-center" id="avatar">
              <img id="logo" style="display:none"  class="icon" data-dropdown="userFnlist" src="<?php echo $_SESSION['userSession']['userPhoto']?>" >
              <ul id="userFnlist" class="f-dropdown" data-dropdown-content>
                  <li><a id="photoManagement">Photo Management</a></li>
                  <li><a href="logout.php">Logo Out</a></li>

              </ul>
          </div>
      </div>
        <!-- avatar ends -->

        <!-- div gap begins -->
      <div class="row"><div class="large-12 large-12 medium-12 columns divgap"></div></div>
        <!-- div gap ends-->

      <!-- Three-up Content Blocks begins-->
      <div class="row" style="display:none" id="beginsShow">
          <!----- for desktop and table only ----->
              <div class="hide-for-small-only large-4  medium-4 columns">
                  <a class="button Customerbutton" href="faceDectection_photoupload.php" data-reveal-id="Common_modal"   data-reveal-ajax="true" ><h2 class="whitecolor"><i class="fa fa-crosshairs fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">Face Dectection</h4>
              </div>



              <div class="hide-for-small-only large-4 medium-4 columns" >
                  <a href="PhotoInventroy.php" data-reveal-id="Common_modal"  id="click_toPhotoStore" data-reveal-ajax="true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-picture-o fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">Photo Store</h4>

              </div>

              <div class="hide-for-small-only large-4  medium-4 columns">
                  <a href="QRInventory.php"  data-reveal-id="Common_modal" data-reveal-ajax="true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-qrcode fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">QR Inventory</h4>
              </div>
          <!--- desktop end--->

          <!----- mobile only ----->
          <div class="hide-for-medium-up columns">
              <a href="mobile/m_photo_up.php"class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-crosshairs fa-3x"></i></h2></a>
              <h4 class="whitecolor track_font">Face Dectection</h4>
          </div>


          <div class="hide-for-medium-up columns">
              <a href="photoStore.php"  class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-picture-o fa-3x"></i></h2></a>
              <h4 class="whitecolor track_font">Photo Store</h4>

          </div>

          <div class="hide-for-medium-up columns">
              <a href="QRInventory.php" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-qrcode fa-3x"></i></h2></a>
              <h4 class="whitecolor track_font">QR Inventory</h4>

          </div>



          <!--- mbile end-->


    </div>



     <!-- Three-up Content Blocks ends-->

   <footer>
        <div class="row">
            <div class="large-12 small-12 medium-12 columns text-center divgap">
                <p><i data-tooltip  title="This is demo program!" style="display:none" class="has-tip tip-top fa fa-exclamation-circle fa-2x whitecolor"></i></p>
            </div>
        </div>
   </footer>





</div>


        <!--- containter end --->
<?php }?>
<?php include_once 'footer.php'?>

