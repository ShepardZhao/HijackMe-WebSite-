<?php

  class General{
      private $GenerateID;

      //constructor
      function __construct($time){
          $this -> GenerateID = $time;
      }

      //generateMd5ID
      public function getgenerateMd5ID($paramters){
          return md5($paramters);
      }

      public function getTime(){
          return $this->GenerateID;
      }
      /**
       * convert geolocation to address
       */

       public function geolocationToAddress($lan,$lat){
           $array= array();
           $api_key = "AIzaSyAdDu6W_NBjzSLP4rWagypCtqjrCW5kups";
// format this string with the appropriate latitude longitude
           $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lan.'&sensor=true&key=' . $api_key;
// make the HTTP request
           $data = @file_get_contents($url);
// parse the json response
           $jsondata = json_decode($data,true);
// if we get a placemark array and the status was good, get the addres
           if(is_array($jsondata )&& $jsondata ['status']==='OK')
           {
               $getresults= $jsondata ['results'];
               $getExactlyResult =$getresults[0];
               //exactly address
               $getAddress_components =$getExactlyResult['address_components'];

               //get country
               $getCountry =$getAddress_components[4]['short_name'];
               //get state
               $getState =$getAddress_components[3]['short_name'];
               //get city
                $getCity = $getAddress_components[2]['short_name'];

               //complete address
               $completeAddress = $getExactlyResult['formatted_address'];

               array_push($array,array('completeAddress'=>$completeAddress,'city'=>$getCity,'state'=>$getState,'country'=>$getCountry));
           }

           return $array;
       }


      /**
       * end
       */




  }




?>