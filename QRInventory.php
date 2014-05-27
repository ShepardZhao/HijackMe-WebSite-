<?php require_once('model/class.model.php');?>
<div class="row">
    <a class="close-reveal-modal">&#215;</a>
      <!-- tags zone-->
      <div class="large-12 columns" id="QRTagezone">
            <?php
            $userSession = $_SESSION['userSession']['userID'];
                echo '<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">';
            $queryAllQRByCurrentUser = $dbop ->queryQRinformation($userSession);
            foreach ($queryAllQRByCurrentUser as $key=>$value_top){
                 echo '<li><a class="fancybox" rel="group1" href='.$value_top['qrPath'].'></a><img src='.$value_top['qrPath'].'><h3 class="text-center"><small>'.$value_top['qrName'].'</small></h3></li>';

                }
                echo '</ul>';


            ?>

      </div>

</div>