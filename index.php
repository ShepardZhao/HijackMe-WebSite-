<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/foundation.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/hijackme.css">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/foundation.min.js"></script>
    <script src="assets/js/modernizr.js"></script>
    <script src="assets/js/parallax.js"></script>
    <script src="lib/sdk/js/ajaxfileupload.js"></script>
    <script src="assets/js/hijackme.js"></script>




</head>


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


</html>


