<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_padre.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- UTILITARIAS -----/////////////////////////////////////////////
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


function Redirige_Editar($padre){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();
   $usu = $_SESSION["codigo"];
   $hashkey = $ClsPad->encrypt($padre, $usu);
   
   //$respuesta->alert("$hashkey");
   $respuesta->redirect("FRMmodpadre.php?hashkey=$hashkey",0);
	
   return $respuesta;
}


//////////////////---- Otros Padres -----/////////////////////////////////////////////
function Grabar_Padre($cui,$nom,$ape,$parentesco,$tel,$mail,$dir,$trabajo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   $ClsPad = new ClsPadre();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
		$dir = trim($dir);
		$trabajo = trim($trabajo);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
		$dir = utf8_encode($dir);
		$trabajo = utf8_encode($trabajo);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
		$dir = utf8_decode($dir);
		$trabajo = utf8_decode($trabajo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    
   if($cui !="" && $nom !="" && $ape != "" && $tel != "" && $mail != ""){
		//$respuesta->alert("$id");
		$result = $ClsPad->get_padre($cui);
		if(!is_array($result)){
			$sql = $ClsPad->insert_padre($cui,$nom,$ape,$parentesco,$tel,$mail,$dir,$trabajo); /// Inserta
			$pass = Generador_Contrasena();
			$id = $ClsUsu->max_usuario();
			$id++; /// Maximo codigo
			$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,3,$cui,$mail,$pass,1);
			//$respuesta->alert("Contraseña $pass, DPI $cui");
			//$respuesta->alert("$sql");
			$rs = $ClsPad->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			}
		}else{
			foreach($result as $row){
				$ape = utf8_decode($row["pad_apellido"]);
				$nom = utf8_decode($row["pad_nombre"]);
			}
			$respuesta->script('swal("Alto!", "Este numero de DPI ya existe registrado como '.$nom.' '.$ape.', porfavor corrobore si ya existe o si existi\u00F3 y fue deshabilitado...", "error").then((value)=>{ cerrar(); });');
		}	
	}
   
   return $respuesta;
}


function Buscar_Padre($cui){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();
   //$respuesta->alert("$cui");
   $result = $ClsPad->get_padre($cui);
   if(is_array($result)){
      foreach($result as $row){
            $cui = $row["pad_cui"];
            $respuesta->assign("cui","value",$cui);
            $nom = utf8_decode($row["pad_nombre"]);
            $respuesta->assign("nom","value",$nom);
            $ape = utf8_decode($row["pad_apellido"]);
            $respuesta->assign("ape","value",$ape);
            $parentesco = trim($row["pad_parentesco"]);
            $respuesta->assign("parentesco","value",$parentesco);
            $tel = $row["pad_telefono"];
            $respuesta->assign("tel","value",$tel);
            $mail = $row["pad_mail"];
            $respuesta->assign("mail","value",$mail);
            $dir = utf8_decode($row["pad_direccion"]);
            $respuesta->assign("dir","value",$dir);
            $trabajo = utf8_decode($row["pad_lugar_trabajo"]);
            $respuesta->assign("trab","value",$trabajo);
      }
      $respuesta->script("document.getElementById('cui').setAttribute('readonly','readonly');");
      //abilita y desabilita botones
      $contenido = tabla_padres($cui,"","","",1);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("document.getElementById('btn-edit').removeAttribute('disabled');");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Padre($cui,$nom,$ape,$parentesco,$tel,$mail,$dir,$trabajo){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
		$dir = trim($dir);
		$trabajo = trim($trabajo);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
		$dir = utf8_encode($dir);
		$trabajo = utf8_encode($trabajo);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
		$dir = utf8_decode($dir);
		$trabajo = utf8_decode($trabajo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cui != ""){
		if($nom !="" && $ape != "" && $tel != "" && $mail != ""){
			$sql = $ClsPad->modifica_padre($cui,$nom,$ape,$parentesco,$tel,$mail,$dir,$trabajo);
			//$respuesta->alert("$sql");
			$rs = $ClsPad->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script("document.getElementById('mod').disabled = false;");
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			   $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Modificar_Completo($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion){
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
   //pasa a minusculas
	$mail = strtolower($mail);
	//--------
	if($dpi != "" && $tipodpi != "" && $fecnac != "" && $nombre != "" && $apellido != ""){
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


function Situacion_Padre($cui,$sit){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();

	//$respuesta->alert("$cui,$sit");
	if($cui != ""){
		$sql = $ClsPad->cambia_sit_padre($cui,$sit);
		//$respuesta->alert("$sql");
		$rs = $ClsPad->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Padre/madre o encargado inhabilitado(a) satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

	return $respuesta;
}

function Send_Mail($cui){
   $respuesta = new xajaxResponse();
   $ClsUsu =  new ClsUsuario();
   //$respuesta->alert("$cui");
	$result = $ClsUsu->get_usuario_tipo_codigo(3,$cui);
	if(is_array($result)){
		foreach($result as $row){
			$id = $row["usu_id"];
			$nombre = utf8_decode($row["usu_nombre"]);
			$mail = $row["usu_mail"];
		}
      //$respuesta->alert("$id,$cui,$mail");
		//abilita y desabilita botones
		$mail = mail_usuario($id,$cui,$mail);
		if($mail == 1){
         $msj = 'Un correo ha sido enviado para activar su usuario...';
      }else{
         $msj = 'para activar el usuario por favor contacte al administrador....';
      }
      $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!! \n\n '.$msj.'", "success").then((value)=>{ cerrar(); });');
	}else{
		$respuesta->script('swal("Error", "Algunos datos no concuerdan con este usuario, por favor contacte al daministrador.....", "error").then((value)=>{ cerrar(); });');
	}
   return $respuesta;
}


//////////////////---- UTILITARIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
$xajax->register(XAJAX_FUNCTION, "Redirige_Editar");
//////////////////---- PADRES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Padre");
$xajax->register(XAJAX_FUNCTION, "Buscar_Padre");
$xajax->register(XAJAX_FUNCTION, "Modificar_Padre");
$xajax->register(XAJAX_FUNCTION, "Modificar_Completo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Padre");
$xajax->register(XAJAX_FUNCTION, "Send_Mail");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  