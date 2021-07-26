<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_perfil.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Departamento - Municipios //////////////////////////////////
function depmun($dep,$idmun,$idsmun){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = municipio_html($dep,$idmun); 
	$respuesta->assign($idsmun,"innerHTML",$contenido); 
	return $respuesta;
}


function Calcular_Edad($fecnac,$fila){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$fecnac = Corrige_Calendario($fecnac);
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("edad$fila","value","$edad años");
	}	

   return $respuesta;
}

//--

function Modificar_Perfil($cui,$tipocui,$codigo,$nombre,$apellido,$genero,$fecnac,$nacionalidad,$religion,$idioma,$mail,$sangre,
                         $alergia,$emergencia,$emetel,$recoge,$redesociales,$seguro,$nit,$clinombre,$clidireccion,$poliza,$asegura,
                         $plan,$asegurado,$instuc,$comment,$usuid,$nompant,$usu,$pass,$preg,$resp){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	$ClsUsu = new ClsUsuario();
   $ClsAlu = new ClsAlumno();
	$ClsSeg = new ClsSeguro();
   
   $preg = trim($preg);
   $resp = trim($resp);
   //decodificaciones de tildes y Ñ's
   $nombre = utf8_encode($nombre);
   $apellido = utf8_encode($apellido);
   $alergico = utf8_encode($alergico);
   $poliza = utf8_encode($poliza);
   $aseguradora = utf8_encode($aseguradora);
   $plan = utf8_encode($plan);
   $asegurado = utf8_encode($asegurado);
   $instrucciones = utf8_encode($instrucciones);
   $comentarios = utf8_encode($comentarios);
   //--//
   $nacionalidad = utf8_encode($nacionalidad);
   $religion = utf8_encode($religion);
   $idioma = utf8_encode($idioma);
   $mail = utf8_encode($mail);
   //--//
   $nit = utf8_encode($nit);
   $clinombre = utf8_encode($clinombre);
   $clidireccion = utf8_encode($clidireccion);
   $preg = utf8_encode($preg);
   $resp = utf8_encode($resp);
   //--
   $nombre = utf8_decode($nombre);
   $apellido = utf8_decode($apellido);
   $alergico = utf8_decode($alergico);
   $poliza = utf8_decode($poliza);
   $aseguradora = utf8_decode($aseguradora);
   $plan = utf8_decode($plan);
   $asegurado = utf8_decode($asegurado);
   $instrucciones = utf8_decode($instrucciones);
   $comentarios = utf8_decode($comentarios);
   //--//
   $nacionalidad = utf8_decode($nacionalidad);
   $religion = utf8_decode($religion);
   $idioma = utf8_decode($idioma);
   $mail = utf8_decode($mail);
   //--//
   $nit = utf8_decode($nit);
   $clinombre = utf8_decode($clinombre);
   $clidireccion = utf8_decode($clidireccion);
   $preg = utf8_decode($preg);
   $resp = utf8_decode($resp);
   //--------
   
   //pasa a minusculas
   $mail = strtolower($mail);
   //--------
	if($usuid != "" && $usu != "" && $cui != "" && $nombre != "" && $apellido != ""){
		
		$sql = $ClsUsu->modifica_usuario($usuid,"$nombre $apellido",10,$mail,$celular,$usu,$pass,1,0,0);
		$sql.= $ClsUsu->modifica_perfil($usuid,$nompant,$mail,$celular);
		if($preg != "" && $resp != ""){
			$sql.= $ClsUsu->cambia_pregunta($usuid,$usu,$preg,$resp);
		}
		//--
		$sql.= $ClsAlu->modifica_alumno($cui,$tipocui,$codigo,$nombre,$apellido,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emetel,$mail,$recoge,$redesociales);  /// modificar;
      $sql.= $ClsAlu->modificar_cliente($cui,$nit,$clinombre,$clidireccion);
      $sql.= $ClsSeg->update_seguro($cui,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios);
		$rs = $ClsUsu->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Datos Actualizados Satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}


/////////////////////////////////////////////////////////// FAMILIA ///////////////////////////////////////////////////////////
	
function Copiar_Datos_Familia($dpi){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();
   //$respuesta->alert("$dpi");
   $result = $ClsPad->get_padre($dpi);
   if(is_array($result)){
      foreach($result as $row){
         $ecivil = trim($row["pad_estado_civil"]);
         $respuesta->assign("ecivil","value",$ecivil);
         $nacionalidad = trim($row["pad_nacionalidad"]);
         $respuesta->assign("nacionalidad","value",$nacionalidad);
         $tel = trim($row["pad_telefono"]);
         $respuesta->assign("telcasa","value",$tel);
         $direccion = utf8_decode($row["pad_direccion"]);
         $respuesta->assign("direccion","value",$direccion);
         $departamento = utf8_decode($row["pad_departamento"]);
         $respuesta->assign("departamento","value",$departamento);
         $municipio = utf8_decode($row["pad_municipio"]);
      }
      ///mundep
      $contenido = municipio_html($departamento,"municipio"); 
      $respuesta->assign("divmun","innerHTML",$contenido);
      $respuesta->assign("municipio","value",$municipio);
   }	
   $respuesta->script("cerrar();");
   return $respuesta;
}


function Modificar_Familiar($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	$ClsPad = new ClsPadre();
	//pasa a mayusculas
		$nombre = trim($nombre);
		$apellido = trim($apellido);
		$nacionalidad = trim($nacionalidad);
		//--
		$direccion = trim($direccion);
		$trabajo = trim($trabajo);
		$profesion = trim($profesion);
		//--
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
		$apellido = utf8_encode($apellido);
		$direccion = utf8_encode($direccion);
		$trabajo = utf8_encode($trabajo);
		$nacionalidad = utf8_encode($nacionalidad);
		$profesion = utf8_encode($profesion);
		//--
		$nombre = utf8_decode($nombre);
		$apellido = utf8_decode($apellido);
		$direccion = utf8_decode($direccion);
		$trabajo = utf8_decode($trabajo);
		$nacionalidad = utf8_decode($nacionalidad);
		$profesion = utf8_decode($profesion);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($dpi != "" && $nombre != "" && $apellido != ""){
		$sql.= $ClsPad->modifica_padre_perfil($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion);
		$rs = $ClsPad->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Datos Actualizados Satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}

function Situacion_Dispositivo($user_id,$device_id,$sit){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPush = new ClsPushup();
	//$respuesta->alert("$padre,$dpi,$nom,$ape,$tel,$mail");
   if($user_id != "" && $device_id != ""){
      $sql.= $ClsPush->situacion_push_user($user_id,$device_id,$sit);
      $rs = $ClsPush->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         if($sit == 0){
            $respuesta->script('swal("OK", "Dispositivo bloqueado satisfactoriamente... ", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("OK", "Dispositivo Re-activado satisfactoriamente... ", "success").then((value)=>{ window.location.reload(); });');
         }
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
   }
	
   return $respuesta;
}


//////////////////---- UTILITARIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
//////////////////---- PERFIL -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Copiar_Datos_Familia");
$xajax->register(XAJAX_FUNCTION, "Modificar_Perfil");
$xajax->register(XAJAX_FUNCTION, "Modificar_Familiar");
$xajax->register(XAJAX_FUNCTION, "Situacion_Dispositivo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  