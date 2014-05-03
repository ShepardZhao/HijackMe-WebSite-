<?php
include_once 'controller/class.controller.php';
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){


    if(isset($_POST['anysislyurl']) && $_POST['acid']==0){

        print_r($_POST['anysislyurl']);
    }

    ?>

    <a class="close-reveal-modal close-reveal-modal-photostore">&#215;</a>

    <div class="off-canvas-wrap" data-offcanvas>
        <div class="inner-wrap">
            <nav class="tab-bar">
                <section class="left-small">
                    <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
                </section>
            </nav>

            <aside class="left-off-canvas-menu">
                <ul class="off-canvas-list">
                    <li><label>Menu</label></li>
                    <li id="click_Paried"><a href="#">Paried</a></li>
                    <li id="click_photoStore"><a href="#">PhotoStore</a></li>
                    <li id="click_Event"><a href="#">Event</a></li>
                    <li id="clcik_Found_On_Map"><a href="#">Found On Map</a></li>
                    <li id="click_Generate_QR"><a href="#">Generate QR Code</a></li>
                </ul>
            </aside>
            <section class="main-section">
                <!----- to paried section-->
                <div class="row" id="toParied">
                    <div class="row">
                        <div class="large-6 columns">
                            <img id="image_zone" src="http://placehold.it/400x300&text=[photo]">
                        </div>

                        <div class="large-6 columns">
                            <div class="panel">
                                <h5>This is a regular panel.</h5>
                                <p>It has an easy to override visual style, and is appropriately subdued.</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="large-12 columns " id="scroller-section">
                            <ul class="clearing-thumbs small-block-grid-6 medium-block-grid-6 large-block-grid-6" data-clearing>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>

                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                                <li> <a class="th [radius]" href="#">
                                        <img src="http://placehold.it/100x100&text=[photo]">
                                    </a>
                                </li>
                            </ul>





                        </div>
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

<?php
}
?>