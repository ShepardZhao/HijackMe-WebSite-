<?php
session_start();
if(empty($_SESSION['userSession'])){
    header( 'Location: portal.php');
}
else{
?>
    <a class="close-reveal-modal close-reveal-modal-upload">&#215;</a>
    <div class="row" >
        <div class="large-12 columns text-center"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i>
        </div>
    </div>


<div class="row" id="" style="display:none">
    <div class="large-12 columns" >
        <table>
            <tbody>
            <tr>

            </tr>
            </tbody>
        </table>
    </div>

</div>


<?php
}
?>