<?php include_once "m_header.php"?>
<!-- photo uploading local server-->

<div class="off-canvas-wrap" data-offcanvas >
    <div class="inner-wrap">
        <nav class="tab-bar">
            <section class="left-small">
                <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
            </section>
        </nav>

        <aside class="left-off-canvas-menu">
            <ul class="off-canvas-list">
                <li><label>Menu</label></li>
                <li id="click_Paried"><a href="#">Pair</a></li>
                <li id="click_photoStore"><a href="#">PhotoStore</a></li>
                <li id="click_Event"><a href="#">Event</a></li>
                <li id="clcik_Found_On_Map"><a href="#">Found On Map</a></li>
                <li id="click_Generate_QR"><a href="#">Generate QR Code</a></li>
            </ul>
        </aside>
        <section class="main-section"  id="mainsection" >
                <div class="row text-center centerPosition">
                    <div class="large-12 small-12 columns">
                        <img id="image_zone" class="panel" exif="true" src="http://placehold.it/400x300&text=[photo]">
                    </div>

                    <div class="large-12 small-12 columns">
                        <a id="fileuploadfield" class="button round">Choose a photo<input type="file" name="uploadfile" id="photouploadinput"/></a>
                        <div data-alert="" class="alert-box imagepath" style="display:none">
                        </div>
                    </div>

                    <div class="large-12 small-12 columns">
                        <a id="buttonsubmit" style="display:none" class="button alert disabled round"></a>
                    </div>

            </div>
            <!-- end -->



            <!----- to PhotoStore section-->
            <div class="row" id="toPhotoStore">
                <div class="">
                </div>
            </div>
            <!-- end -->


            <!----- to Event section-->
            <div class="row" id="toEvent">
                <div class="">
                </div>
            </div>
            <!-- end -->



            <!----- to Found_On_Map section-->
            <div class="row" id="toFound_On_Map">
                <div class="">
                </div>
            </div>
            <!-- end -->


            <!----- to Found_On_Map section-->
            <div class="row" id="toGenerate_QR">
                <div class="">
                </div>
            </div>
            <!-- end -->

        </section>

        <a class="exit-off-canvas"></a>

    </div>
</div>

<?php include_once "m_footer.php"?>
