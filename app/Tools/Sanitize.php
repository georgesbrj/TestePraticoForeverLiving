<?php

namespace App\Tools;

class Sanitize
{
    public function onlyNumbers($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

    function validCep($string){
      $clear_cep = $this->onlyNumbers($string);
      if(is_numeric($clear_cep)){
        //tratar cep 
        return $clear_cep;
      }
      return null;
    }  
}
