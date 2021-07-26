<?php
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos


function ValidarMail($mail){
   $Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($Sintaxis,$mail)){
      return true;
   }else{
     return false;
   }
}


?>