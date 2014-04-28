<div class="row">
    <a class="close-reveal-modal">&#215;</a>
<div class="large-12 columns">
    <div class="row">
        <div class="large-12 columns" id="videocaputer_zone">
            <video id="vid" class="videostream videostream_sope" autoplay loop></video>
            <canvas id="canvas" class="videostream_sope" style="display:none;"></canvas>
            <canvas id="compare" class="videostream_sope" style="display:none"></canvas>
            <canvas id="overlay" class="videostream_sope" style="position: absolute; top: 0px; z-index: 100001; display: block;"></canvas>
            <canvas id="debug" class="videostream_sope" style="position: absolute; top: 0px; z-index: 100002; display: none;"></canvas>
        </div>

    </div>
    <br>
    <div class="row">
        <div class="large-12 columns">
            <div id="headtrackerMessage" data-alert="" class="alert-box success">

            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="large-12 columns">
            <a id="Apply-button" class="button alert round disabled">Apply</a>
        </div>
    </div>


</div>


</div>

<script src="lib/sdk/js/headtrackr.min.js"></script>
<script src="assets/js/camera_capture.js"></script>
