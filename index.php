<?php include "header.php"?>
<body>
    <!-- containter begins--->
    <div class="row containter text-center">
        <div class="large-12 small-12  medium-12 columns">
       <!-- avatar begins-->
      <div class="row">
        <div class="large-12 columns small-12 text-center" id="avatar">

            <a href="#" class="circular"><i class=" fa fa-user fa-5x"></i></a>

        </div>
      </div>
        <!-- avatar ends -->

        <!-- div gap begins -->
      <div class="row"><div class="large-12 large-12 medium-12 columns divgap"></div></div>
        <!-- div gap ends-->

      <!-- Three-up Content Blocks begins-->
      <div class="row">
              <div class="large-4 small-12  medium-4 columns">
                  <a data-dropdown="FaceDectectionDownload" data-options="is_hover:true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-crosshairs fa-3x"></i></h2></a>
                  <ul id="FaceDectectionDownload" class="f-dropdown " data-dropdown-content>
                      <li class="hide-for-small-only"><a href="faceDectection_camera.php" data-reveal-id="Common_modal"   data-reveal-ajax="true" >Camera Capture</a></li>
                      <li><a href="faceDectection_photoupload.php" data-reveal-id="Common_modal"   data-reveal-ajax="true" >Photo Upload</a></li>
                  </ul>
                  <h4 class="whitecolor track_font">Face Dectection</h4>


              </div>

              <div class="large-4 small-12  medium-4 columns">
                  <a href="photoStore.php" data-reveal-id="Common_modal"  data-reveal-ajax="true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-picture-o fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">Photo Store</h4>

              </div>

              <div class="large-4 small-12  medium-4 columns">
                  <a href="QRInventory.php"  data-reveal-id="Common_modal" data-reveal-ajax="true" class="button Customerbutton"><h2 class="whitecolor"><i class="fa fa-qrcode fa-3x"></i></h2></a>
                  <h4 class="whitecolor track_font">QR Inventory</h4>

              </div>
          </ul>
    </div>
     <!-- Three-up Content Blocks ends-->

   <footer>
        <div class="row">
            <div class="large-12 small-12 medium-12 columns text-center divgap">
                <p><i data-tooltip  title="This is demo program!"  class="has-tip tip-top fa fa-exclamation-circle fa-2x whitecolor"></i></p>
            </div>
        </div>
   </footer>


    <!--- Modal calls --------->

        <div id="Common_modal" class="reveal-modal large" data-reveal></div>
    </div>
  </div>



        <!--- containter end --->
</body>
<?php include "footer.php"?>

