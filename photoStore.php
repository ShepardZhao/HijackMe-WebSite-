
<?php
require_once('model/class.model.php');
?>


<div class="row">
    <div class="large-12 columns">
    <dl class="sub-nav">
        <dd class="nav-click active"><a id="showsALL_noFilter" > All</a></dd>
        <dd class="nav-click"><a  id="click-filterAllface">Face</a></dd>
        <dd class="nav-click"><a  id="click-filterAllView">Landscape</a></dd>
        <dd class="nav-click"><a  data-dropdown="filterName" data-options="is_hover:true" class="dropdown" id="click-filterName">Name</a></dd>
        <dd class="nav-click"><a data-dropdown="filterGender" data-options="is_hover:true" class="dropdown" id="click-filterGender">Gender</a></dd>
        <dd class="nav-click"><a  data-dropdown="filterEvent" data-options="is_hover:true" class="dropdown " id="click-filterEvent">Event</a></dd>
        <dd class="nav-click" ><a data-dropdown="filterDate" data-options="is_hover:true" class="dropdown" id="click-filterDate">Date</a></dd>


    </dl>


        <ul id="filterName" data-dropdown-content class="tiny f-dropdown">
            <?php
            $getNameGroup = $dbop -> getNameClassifcation();
            foreach($getNameGroup as $value){
                echo '<li class="navListname"><a>'.$value.'</a></li>';
            }

            ?>
        </ul>
        <ul id="filterGender" data-dropdown-content class="tiny f-dropdown">

            <?php
            $getGenderGroup = $dbop -> getGenderClassifcation();
            foreach($getGenderGroup as $value){
                echo '<li class="navListGender"><a>'.$value.'</a></li>';
            }

            ?>
        </ul>
        <ul id="filterEvent" data-dropdown-content class="tiny f-dropdown">
            <?php
            $getEventGroup = $dbop -> getEventClassifcation();
            foreach($getEventGroup as $value){
                echo '<li class="navListEvent"><a>'.$value.'</a></li>';
            }

            ?>

        </ul>

        <ul id="filterDate" data-dropdown-content class="tiny f-dropdown ">
            <?php
            $getYearGroup = $dbop -> getYearClassifcation();
            foreach($getYearGroup as $value){
                echo '<li class="NavListDate"><a>'.$value.'</a></li>';
            }

            ?>


        </ul>

        <div class="row">
            <div class="large-12 columns" id="filterImageZone">



            </div>


        </div>



        </div>
</div>
