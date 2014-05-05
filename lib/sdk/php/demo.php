<?PHP
require_once 'facepp_sdk.php';
########################
###     example      ###
########################
$facepp = new Facepp();



#detect image by url
$params=array('url'=>'http://www.faceplusplus.com.cn/wp-content/themes/faceplusplus/assets/img/demo/1.jpg');
$response = $facepp->execute('/detection/detect',$params);
print_r($response);

if($response['http_code']==200){
    #json decode 
    $data = json_decode($response['body'],1);
    #get face landmark
    foreach ($data['face'] as $face) {
        $response = $facepp->execute('/detection/landmark',array('face_id'=>$face['face_id']));
        print_r($response);
    }
    #create person 
    $response = $facepp->execute('/person/create',array('person_name'=>'unique_person_name'));
    print_r($response);

    #delete person
    $response = $facepp->execute('/person/delete',array('person_name'=>'unique_person_name'));
    print_r($response);

}

