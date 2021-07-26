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

function Modificar_Perfil($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion,$usuid,$nompant,$usu,$pass,$preg,$resp){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	$ClsUsu = new ClsUsuario();
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
		$preg = trim($preg);
		$resp = trim($resp);
		//--
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
		$apellido = utf8_encode($apellido);
		$direccion = utf8_encode($direccion);
		$trabajo = utf8_encode($trabajo);
		$nacionalidad = utf8_encode($nacionalidad);
		$profesion = utf8_encode($profesion);
		$preg = utf8_encode($preg);
		$resp = utf8_encode($resp);
		//--
		$nombre = utf8_decode($nombre);
		$apellido = utf8_decode($apellido);
		$direccion = utf8_decode($direccion);
		$trabajo = utf8_decode($trabajo);
		$nacionalidad = utf8_decode($nacionalidad);
		$profesion = utf8_decode($profesion);
		$preg = utf8_decode($preg);
		$resp = utf8_decode($resp);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($usuid != "" && $usu != "" && $dpi != "" && $nombre != "" && $apellido != ""){
		
		$sql = $ClsUsu->modifica_usuario($usuid,"$nombre $apellido",3,$mail,$celular,$usu,$pass,1,0,0);
		$sql.= $ClsUsu->modifica_perfil($usuid,$nompant,$mail,$celular);
		if($preg != "" && $resp != ""){
			$sql.= $ClsUsu->cambia_pregunta($usuid,$usu,$preg,$resp);
		}
		//--
		$sql.= $ClsPad->modifica_padre_perfil($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion);
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


function Nuevo_Usuario($padre,$dpi,$nom,$ape,$parentesco,$tel,$mail,$arrhijos,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	//$respuesta->alert("$padre,$dpi,$nom,$ape,$parentesco,$tel,$mail,$arrhijos,$filas");
   $ClsUsu = new ClsUsuario();
	$ClsPad = new ClsPadre();
	$ClsAsi = new ClsAsignacion();
	//pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
		//--
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
   if($padre != ""){
		if($dpi != "" && $nom != "" && $ape != "" && $mail != "" && $tel != ""){
			//////// CREA PADRE Y ENLAZA A HIJO O HIJOS
			$sql = $ClsPad->insert_padre($dpi,$nom,$ape,$parentesco,$tel,$mail,'',''); /// Inserta
			/// enlaza a hijos //
			for($i = 1; $i <= $filas; $i++){
				$cui_hijo = $arrhijos[$i];
				$sql.= $ClsAsi->asignacion_alumno_padre($dpi,$cui_hijo); /// CUI padre y CUI Hijo
			}
			////////// CREA USUARIO
			$pass = Generador_Contrasena();
			$pass = $ClsUsu->decrypt($pass,$mail);
			$id = $ClsUsu->max_usuario();
			$id++; /// Maximo codigo
			//$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,3,$dpi,$mail,$pass,1);
			$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,3,$dpi,$mail,$pass,1);
			$rs = $ClsUsu->exec_sql($sql);
			//$respuesta->alert($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Nuevo Usuario Creado Satisfactoriamente! ", "success").then((value)=>{ window.location.href="FRMfamilia.php"; });');
			}else{
				$respuesta->script("document.getElementById('grab').removeAttribute('disabled');");
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
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
$xajax->register(XAJAX_FUNCTION, "Modificar_Perfil");
$xajax->register(XAJAX_FUNCTION, "Nuevo_Usuario");
//////////////////---- FAMILIA -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Copiar_Datos_Familia");
$xajax->register(XAJAX_FUNCTION, "Modificar_Familiar");
$xajax->register(XAJAX_FUNCTION, "Situacion_Dispositivo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  