<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_perfil.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
//$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Modificar_Usuario_Perfil($id,$nom,$mail,$tel){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
	//--
	$nom = trim($nom);
	//--
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--
   if($id != ""){
		if($nom != "" && $mail != "" && $tel != ""){
			$mc = comprobar_email($mail);
			if($mc > 0){
				//$respuesta->alert("$id,$nom2,$mail,$tel");
				$sql = $ClsUsu->modifica_perfil($id,$nom,$mail,$tel);
				$rs = $ClsUsu->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Perfil actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
					$respuesta->script("document.getElementById('mod').disabled = false;");
				}	
			}else{
				$msj = '<h5>Formato de e-mail incorrecto...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
            
				$respuesta->script("document.getElementById('mod').removeAttribute('disabled');");
			}
		}
   }else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		$respuesta->script("cerrar();");
	}
	
   return $respuesta;
}


function Modificar_Usuario_Pass($id,$usu,$pass){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   //--------
    if($id != ""){
	     if($usu != "" && $pass != ""){
			  $sql = $ClsUsu->modifica_pass($id,$usu,$pass);
			  $rs = $ClsUsu->exec_sql($sql);
			  //$respuesta->alert("$sql");
			  if($rs == 1){
				   $respuesta->script('swal("Excelente!", "Perfil actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			  }else{
				   $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
				   $respuesta->script("document.getElementById('mod').disabled = false;");
			  }	
	     }
   	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		$respuesta->script("cerrar();");
	}
	
   return $respuesta;
}


function Modificar_Usuario_Pregunta($id,$usu,$preg,$resp){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   //--------
	    $preg = trim($preg);
	//--
		$preg = utf8_encode($preg);
		//--
		$preg = utf8_decode($preg);
	//--
   if($id != ""){
		if($usu != "" && $preg != "" && $resp != ""){
			$sql = $ClsUsu->cambia_pregunta($id,$usu,$preg,$resp);
			$rs = $ClsUsu->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Perfil actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('mod').disabled = false;");
			}	
		}
   }else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		$respuesta->script("cerrar();");
	}
	
   return $respuesta;
}

//////////////////---- PERFIL -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Modificar_Usuario_Perfil");
$xajax->register(XAJAX_FUNCTION, "Modificar_Usuario_Pass");
$xajax->register(XAJAX_FUNCTION, "Modificar_Usuario_Pregunta");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  