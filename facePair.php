<div class="off-canvas-wrap" data-offcanvas>
    <div class="inner-wrap">
        <nav class="tab-bar">
            <section class="left-small">
                <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
            </section>
            <a class="close-reveal-modal" style="top: 0;color: white;">×</a>
        </nav>

        <aside class="left-off-canvas-menu">
            <ul class="off-canvas-list">
                <li><label>Menu</label></li>
                <li ><a id="click_toParied">pair</a></li>
                <li ><a id="click_photoStore">PhotoStore</a></li>
                <li ><a id="clcik_Found_On_Map">Found On Map</a></li>
                <li ><a id="click_Generate_QR">Generate QR Code</a></li>
            </ul>
        </aside>
        <section class="main-section" id="mainsection">
            <!----- to paried section-->
            <div class="row" id="toParied" >
                <div class="row">
                    <div class="large-5 text-center columns" style=" left: 15px; ">
                        <img class="panel image_zone pair">
                        <div class="row">
                        <div class="large-12 columns text-center">
                            <div class="pair text-center" id="faceAnalysisResult"></div>
                        </div>
                            </div>
                    </div>
                    <div class="large-7 columns text-center"  id="MatchedZone">

                        <!--if found the matched the photo then this place will be placed a lot photos-->

                    </div>

                </div>





            </div>
            <!-- end -->



            <!----- to PhotoStore section-->
            <div class="row" id="toPhotoStore" style="display:none">

            </div>
            <!-- end -->


            <!----- to Event section-->
            <div class="row" id="toEvent" style="display:none">

            </div>
            <!-- end -->



            <!----- to Found_On_Map section-->
            <div class="row" id="toFound_On_Map" style="display:none">
                <div id="map">
                </div>
            </div>
            <!-- end -->


            <!----- to Found_On_Map section-->
            <div class="row" id="toGenerate_QR" style="display:none">

            </div>
            <!-- end -->

        </section>

        <a class="exit-off-canvas"></a>

    </div>
    <div style="display:none" id="map2"></div>

</div>

