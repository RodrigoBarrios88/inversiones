<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_valida.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Activa_Usuario($codigo,$nombre_pantalla,$mail,$tel,$usu,$pass,$preg,$resp){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
		//$respuesta->alert("$id,$tipo,$nom,$mail,$tel,$niv,$sit,$usu,$pass,$avi,$seg");
	    //--------
	if($codigo != ""){
		$sql = "";
      $sql.= $ClsUsu->modifica_pass($codigo,$usu,$pass);
      $sql.= $ClsUsu->modifica_perfil($codigo,$nombre_pantalla,$mail,$tel);
      $sql.= $ClsUsu->cambia_usu_avilita($codigo,1);
      //echo $sql;
      if($preg != "" && $resp != ""){
         $sql.=$ClsUsu->cambia_pregunta($codigo,$usu,$preg,$resp);	//modifica solo si el usuario prefiere cambiar su pregunta clave
      }
      $rs = $ClsUsu->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Usuario activo satisfactoriamente!", "success").then((value)=>{ window.location.href="../logout.php"; });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
	}else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////----  -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Activa_Usuario");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  