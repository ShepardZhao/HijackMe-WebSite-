<?php

  class General{
      private $GenerateID;


      function __constructor($time){
          $this -> GenerateID = $time;
      }

      public function getgenerateID($prefix){
          return $prefix.$this->GenerateID;


      }



  }




?>