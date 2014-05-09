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






  }




?>