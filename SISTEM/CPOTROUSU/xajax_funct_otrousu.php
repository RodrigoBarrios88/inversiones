<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_otrousu.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


///////////// Grupos //////////////////////
function Grupos_OtroUsu($otrousu,$area){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$otrousu,$area");
   if($otrousu != ""){
      $result = $ClsAsi->get_usuario_grupo("",$otrousu,1);
      if(is_array($result)){
		 $grupos = "";
		 foreach($result as $row){
			$grupos.= $row["gru_codigo"].",";
		 }
		 $grupos = substr($grupos, 0, strlen($grupos) - 1);
      }
      //$respuesta->alert("$grupos");
      /// Setea listas de puntos
      $contenido = grupos_no_usuario_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      
      $contenido = grupos_usuario_lista_multiple("asignados",$otrousu);
      $respuesta->assign("divasignados","innerHTML",$contenido);
      
      $respuesta->script("cerrar();");
   }else{
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}


function Lista_Grados_OtroUsu($otrousu,$pensum,$nivel){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   //$respuesta->alert("$otrousu,$pensum,$nivel");
   if($otrousu != ""){
      $result = $ClsAcadem->get_grado_otros_usuarios($pensum,$nivel,'',$otrousu);
		if(is_array($result)){
			$grados = "";
			foreach($result as $row){
				$grados.= $row["gra_codigo"].",";
			}
		   $grados = substr($grados, 0, strlen($grados) - 1);
		}
      //$respuesta->alert("$secciones");
      /// Setea listas de puntos
      $contenido = grados_no_otros_usuarios_lista_multiple("xasignar",$pensum,$nivel,$grados);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      
      $contenido = grados_otros_usuarios_lista_multiple("asignados",$pensum,$nivel,$otrousu);
      $respuesta->assign("divasignados","innerHTML",$contenido);
      
      $respuesta->script("cerrar();");
   }else{
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}


function Calcular_Edad($fecnac){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("edad","value",$edad);
		$respuesta->assign("sedad","innerHTML","$edad  a&ntilde;os");
	}	

   return $respuesta;
}

//////////////////---- Otros OtroUsus -----/////////////////////////////////////////////
function Grabar_OtroUsu($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   $ClsOtro =  new ClsOtrosUsu();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$fecnac = trim($fecnac);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
      $titulo = utf8_encode($titulo);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
      $titulo = utf8_decode($titulo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    
    if($cui !="" && $nom !="" && $ape != "" && $tel != "" && $mail != ""){
		//$respuesta->alert("$id");
		$sql = $ClsOtro->insert_otros_usuarios($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail); /// Inserta
		$pass = Generador_Contrasena();
		$id = $ClsUsu->max_usuario();
		$id++; /// Maximo codigo
		$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,1,$cui,$mail,$pass,1);
		//$respuesta->alert("$sql");
		$rs = $ClsOtro->exec_sql($sql);
		if($rs == 1){
			$mail = mail_usuario($id,"$nom $ape",$mail);
			if($mail == 1){
				$msj = 'Un correo ha sido enviado para activar su usuario...';
			}else{
				$msj = 'para activar el usuario por favor contacte al administrador....';
			}
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!! \n\n '.$msj.'", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_OtroUsu($cui){
   $respuesta = new xajaxResponse();
   $ClsOtro =  new ClsOtrosUsu();
   //$respuesta->alert("$cui");
   $result = $ClsOtro->get_otros_usuarios($cui);
   if(is_array($result)){
      foreach($result as $row){
         $cui = $row["otro_cui"];
         $respuesta->assign("cui","value",$cui);
         $nom = utf8_decode($row["otro_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $ape = utf8_decode($row["otro_apellido"]);
         $respuesta->assign("ape","value",$ape);
         $titulo = utf8_decode($row["otro_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $fecnac = utf8_decode($row["otro_fecha_nacimiento"]);
         $fecnac = cambia_fecha($fecnac);
         $respuesta->assign("fecnac","value",$fecnac);
         $edad = Calcula_Edad($fecnac);
         $respuesta->assign("sedad","innerHTML","$edad  a&ntilde;os");
         $tel = $row["otro_telefono"];
         $respuesta->assign("tel","value",$tel);
         $mail = $row["otro_mail"];
         $respuesta->assign("mail","value",$mail);
      }
      //abilita y desabilita botones
      $contenido = tabla_otros_usuarios($cui,$ape,$nom,$usu,1);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_OtroUsu($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail){
   $respuesta = new xajaxResponse();
   $ClsOtro =  new ClsOtrosUsu();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$fecnac = trim($fecnac);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
      $titulo = utf8_encode($titulo);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
      $titulo = utf8_decode($titulo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cui != ""){
		if($nom !="" && $ape != "" && $tel != "" && $mail != ""){
			$sql = $ClsOtro->modifica_otros_usuarios($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail);
			//$respuesta->alert("$sql");
			$rs = $ClsOtro->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
            $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
            $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
	   $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_OtroUsu($cui,$sit){
   $respuesta = new xajaxResponse();
   $ClsOtro =  new ClsOtrosUsu();

   if($cui != ""){
      $sql = $ClsOtro->cambia_sit_otros_usuarios($cui,$sit);
      //$respuesta->alert("$sql");
      $rs = $ClsOtro->exec_sql($sql);
      if($rs == 1){
         if($sit == 0){
            $respuesta->script('swal("Ok", "Autoriadad inhabilitada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Excelente!", "Autoriadad Re-Activada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }
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
	$result = $ClsUsu->get_usuario_tipo_codigo(1,$cui);
	if(is_array($result)){
		foreach($result as $row){
			$id = $row["usu_id"];
			$nombre = utf8_decode($row["usu_nombre"]);
			$mail = $row["usu_mail"];
		}
		//abilita y desabilita botones
		$mail = mail_usuario($id,$nombre,$mail);
		if($mail == 1){
         $msj = 'Un correo ha sido enviado para activar su usuario...';
      }else{
         $msj = 'para activar el usuario por favor contacte al administrador....';
      }
      $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!! \n\n '.$msj.'", "success").then((value)=>{ window.location.reload(); });');
	}else{
		$respuesta->script('swal("Error", "Algunos datos no concuerdan con este usuario, por favor contacte al daministrador.....", "error").then((value)=>{ cerrar(); });');
	}
   return $respuesta;
}


////////////////////////// ASIGNACION DE GRUPOS Y MAESTROS ////////

function Area_Grupos($area,$grupos){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$area,'$grupos'");
      $contenido = grupos_no_usuario_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      $respuesta->script("cerrar();");
	  
   return $respuesta;
}

function Graba_OtroUsu_Grupos($otrousu,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   if($otrousu != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
			$sql.= $ClsAsi->asignacion_otro_grupo($grupos[$i],$otrousu);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
			$respuesta->script("Busca_Grupos_OtroUsu($otrousu,$area);");
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Quitar_OtroUsu_Grupos($otrousu,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   if($otrousu != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
			//$respuesta->alert("$grupos[$i],$otrousu");   
			$sql.= $ClsAsi->desasignacion_otro_grupo($grupos[$i],$otrousu);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
         $respuesta->script("Busca_Grupos_OtroUsu($otrousu,$area);");
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Graba_OtroUsu_Grados($otrousu,$pensum,$nivel,$grados,$filas){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
	//$respuesta->alert("$otrousu,$pensum,$nivel,$grados,$filas");
   if($otrousu != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
		 $sql.= $ClsAcadem->insert_grado_otros_usuarios($pensum,$nivel,$grados[$i],$otrousu);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
			$respuesta->script("Busca_Grados_OtroUsu('$otrousu',$pensum,$nivel);");
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   } 
   
   return $respuesta;
}


function Quitar_OtroUsu_Grados($otrousu,$pensum,$nivel,$grados,$filas){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   if($otrousu != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
			//$respuesta->alert("$grados[$i],$otrousu");   
			$sql.= $ClsAcadem->delete_grado_otros_usuarios($pensum,$nivel,$grados[$i],$otrousu);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
			$respuesta->script("Busca_Grados_OtroUsu('$otrousu',$pensum,$nivel);");
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}

////////////////////////// ASIGNACION DE CURSOS LIBRES ///////////////////////////////

function Graba_Autoridad_Curso($otrousu,$curso){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	
	if($otrousu != "" && $curso != ""){
     	$sql = $ClsCur->insert_curso_autoridad($curso,$otrousu);
		//$respuesta->alert("$sql");
      $rs = $ClsCur->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cursos asignados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Delete_Autoridad_Curso($otrousu,$curso){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	
	if($otrousu != "" && $curso != ""){
     	$sql = $ClsCur->delete_curso_autoridad($curso,$otrousu);
		//$respuesta->alert("$sql");
      $rs = $ClsCur->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cursos des-asignados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


//////////////////---- VARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grupos_OtroUsu");
$xajax->register(XAJAX_FUNCTION, "Lista_Grados_OtroUsu");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
//////////////////---- MAESTROS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_OtroUsu");
$xajax->register(XAJAX_FUNCTION, "Buscar_OtroUsu");
$xajax->register(XAJAX_FUNCTION, "Modificar_OtroUsu");
$xajax->register(XAJAX_FUNCTION, "Situacion_OtroUsu");
$xajax->register(XAJAX_FUNCTION, "Send_Mail");
////////////////////////// ASIGNACION DE PUNTOS Y TECNICOS ////////
$xajax->register(XAJAX_FUNCTION, "Area_Grupos");
$xajax->register(XAJAX_FUNCTION, "Graba_OtroUsu_Grupos");
$xajax->register(XAJAX_FUNCTION, "Quitar_OtroUsu_Grupos");
$xajax->register(XAJAX_FUNCTION, "Graba_OtroUsu_Grados");
$xajax->register(XAJAX_FUNCTION, "Quitar_OtroUsu_Grados");
////////////////////////// ASIGNACION DE CURSOS LIBRES ////////
$xajax->register(XAJAX_FUNCTION, "Graba_Autoridad_Curso");
$xajax->register(XAJAX_FUNCTION, "Delete_Autoridad_Curso");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  