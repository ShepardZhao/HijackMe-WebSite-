<?php
require_once('../model/class.model.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $requestType = $_POST['requestType'];
    $requestValue = $_POST['value'];
    $userSession = $_SESSION['userSession']['userID'];
    if(!empty($requestType)){

        //name fields
        if($requestType==='name'){
            if(!empty($requestValue)){
                $getName = $dbop -> getExactlyNameClassifcation($requestValue,$userSession);
                if($getName){
                    echo json_encode(array('success'=>1,'message'=>$getName));
                }
                else{
                    echo json_encode(array('success'=>0,'message'=>'fatal error'));

                }

            }


        }
        elseif($requestType === 'allFace'){
            if(!empty($requestValue)){
                $getAllFace = $dbop -> getAllface($userSession);
                if($getAllFace){
                    echo json_encode(array('success'=>1,'message'=>$getAllFace));
                }
                else{
                    echo json_encode(array('success'=>0,'message'=>'fatal error'));

                }

            }

        }
        elseif($requestType === 'landScape'){
            if(!empty($requestValue)){
                $queryAllNonfaces = $dbop -> queryAllNonface($userSession);
                if($queryAllNonfaces){
                    echo json_encode(array('success'=>1,'message'=>$queryAllNonfaces));
                }
                else{
                    echo json_encode(array('success'=>0,'message'=>'fatal error'));

                }

            }
        }

        elseif($requestType === 'gender'){
            if(!empty($requestValue)){
                $querygender = $dbop -> queryGenderByUserID($requestValue,$userSession);
                if($querygender){
                    echo json_encode(array('success'=>1,'message'=>$querygender));
                }
                else{
                    echo json_encode(array('success'=>0,'message'=>'fatal error'));

                }

            }
        }
        elseif($requestType === 'event'){
            if(!empty($requestValue)){
                $queryEvent = $dbop -> queryEvent($requestValue,$userSession);
                if($queryEvent){
                    echo json_encode(array('success'=>1,'message'=>$queryEvent));
                }
                else{
                    echo json_encode(array('success'=>0,'message'=>'fatal error'));

                }

            }
        }

        elseif($requestType === 'year'){
            if(!empty($requestValue)){
                $queryYear = $dbop -> queryYear($requestValue,$userSession);
                if($queryYear){
                    echo json_encode(array('success'=>1,'message'=>$queryYear));
                }
                else{
                    echo json_encode(array('success'=>0,'message'=>'fatal error'));

                }

            }
        }


        elseif($requestType === 'state'){
            //this line should return the state stuff
        }

        elseif($requestType === 'city'){
            //this line should return the city stuff
        }
        elseif($requestType==='date'){
            //this line should return the date stuff
        }

    }

}






?>