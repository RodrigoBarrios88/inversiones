<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_maestro.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- VARIOS -----/////////////////////////////////////////////
function Pensum_Nivel($pensum,$idniv,$idsniv,$accniv){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$idniv,$idsniv,$accniv");
    $contenido = nivel_html($pensum,$idniv,$accniv);
    $respuesta->assign($idsniv,"innerHTML",$contenido);
	
	return $respuesta;
}

function Nivel_Grado($pensum,$nivel,$idgra,$idsgra,$accgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$idgra,$idsgra,$accgra");
    $contenido = grado_html($pensum,$nivel,$idgra,$accgra);
    $respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Materia($pensum,$nivel,$grado,$idmat,$idsmat,$accmat){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$idmat,$idsmat,$accmat");
    $contenido = materia_html($pensum,$nivel,$grado,$idmat,$accmat);
    $respuesta->assign($idsmat,"innerHTML",$contenido);
	
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

//////////////////---- Maestros -----/////////////////////////////////////////////
function Grabar_Maestro($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   $ClsMae = new ClsMaestro();
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
		$sql = $ClsMae->insert_maestro($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail); /// Inserta
		$pass = Generador_Contrasena();
		$id = $ClsUsu->max_usuario();
		$id++; /// Maximo codigo
		$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,2,$cui,$mail,$pass,1);
		//$respuesta->alert("Contraseña $pass, DPI $cui");
		//$respuesta->alert("$sql");
		$rs = $ClsMae->exec_sql($sql);
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


function Buscar_Maestro($cui){
   $respuesta = new xajaxResponse();
   $ClsMae = new ClsMaestro();
   //$respuesta->alert("$cui");
   $result = $ClsMae->get_maestro($cui);
   if(is_array($result)){
      foreach($result as $row){
         $cui = $row["mae_cui"];
         $respuesta->assign("cui","value",$cui);
         $nom = utf8_decode($row["mae_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $ape = utf8_decode($row["mae_apellido"]);
         $respuesta->assign("ape","value",$ape);
         $titulo = utf8_decode($row["mae_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $fecnac = utf8_decode($row["mae_fecha_nacimiento"]);
         $fecnac = cambia_fecha($fecnac);
         $respuesta->assign("fecnac","value",$fecnac);
         $edad = Calcula_Edad($fecnac);
         $respuesta->assign("sedad","innerHTML","$edad  a&ntilde;os");
         $tel = $row["mae_telefono"];
         $respuesta->assign("tel","value",$tel);
         $mail = $row["mae_mail"];
         $respuesta->assign("mail","value",$mail);
      }
      //abilita y desabilita botones
      $contenido = tabla_maestros($cui,'','','',1);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Maestro($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail){
   $respuesta = new xajaxResponse();
   $ClsMae = new ClsMaestro();
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
			$sql = $ClsMae->modifica_maestro($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail);
			//$respuesta->alert("$sql");
			$rs = $ClsMae->exec_sql($sql);
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


function Situacion_Maestro($cui,$sit){
   $respuesta = new xajaxResponse();
   $ClsMae = new ClsMaestro();

   if($cui != ""){
      $sql = $ClsMae->cambia_sit_maestro($cui,$sit);
      //$respuesta->alert("$sql");
      $rs = $ClsMae->exec_sql($sql);
      if($rs == 1){
         if($sit == 0){
            $respuesta->script('swal("Ok", "Maestro inhabilitado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Excelente!", "Maestro Re-Activado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
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
	$result = $ClsUsu->get_usuario_tipo_codigo(2,$cui);
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

///////::_______
function Graba_Maestro_Seccion($maestro,$pensum,$nivel,$grado,$arrcodigos){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   if($maestro != ""){
	   $sql = "";
      $sql.= $ClsAcadem->delete_grupo_seccion_maestro($maestro,$pensum,$nivel,$grado);
      if(is_array($arrcodigos)){
         $count = count($arrcodigos); //cuenta cuantas vienen en el array
         for($i = 0; $i < $count; $i++){
            /////////---------------
            $codigo = $arrcodigos[$i];
            //--
            $separa = explode("|",$codigo);
            $pensum = $separa[0];
            $nivel = $separa[1];
            $grado = $separa[2];
            $seccion = $separa[3];
            //////// REVISA SI TIENE MATERIAS ASIGNADAS //////
            $result = $ClsAcadem->comprueba_materia_maestro($pensum,$nivel,$grado,"",$maestro,"");
            if(is_array($result)){ ///// SI TIENE ENTONCES
               foreach($result as $row){
                 $materia = $row["matm_materia"];
                 $sql.= $ClsAcadem->insert_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro); /////// ASIGNA AL MAESTRO A IMPARTIR DICHAS MATERIAS A LA SECCION SELECCIONADA
               }
            }
            //////// ASIGNA AL MAESTRO A LA SECCIÓN //////
            $sql.= $ClsAcadem->insert_seccion_maestro($pensum,$nivel,$grado,$seccion,$maestro);
         }
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Secciones asignadas satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Graba_Maestro_Materia($maestro,$pensum,$nivel,$grado,$arrcodigos){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   if($maestro != ""){
		$sql = "";
      $sql.= $ClsAcadem->delete_grupo_materia_maestro($maestro,$pensum,$nivel,$grado);
      if(is_array($arrcodigos)){
         $count = count($arrcodigos); //cuenta cuantas vienen en el array
         for($i = 0; $i < $count; $i++){
            /////////---------------
            $codigo = $arrcodigos[$i];
            //--
            $separa = explode("|",$codigo);
            $pensum = $separa[0];
            $nivel = $separa[1];
            $grado = $separa[2];
            $materia = $separa[3];
            //////// REVISA SI TIENE SECCIONES ASIGNADAS //////
            $result = $ClsAcadem->comprueba_seccion_maestro($pensum,$nivel,$grado,"",$maestro,"");
            if(is_array($result)){ ///// SI TIENE ENTONCES
               foreach($result as $row){
                  $seccion = $row["secm_seccion"];
                  $sql.= $ClsAcadem->insert_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro); /////// ASIGNA AL MAESTRO A IMPARTIR DICHAS MATERIAS SELECCIONADA A LAS SECCIONES ANTES REGISTRADAS
               }
            }
            //////// ASIGNA AL MAESTRO A LA MATERIA //////
            $sql.= $ClsAcadem->insert_materia_maestro($pensum,$nivel,$grado,$materia,$maestro);
         }
      }
		//$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Materias asignadas satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Graba_Maestro_Grupos($maestro,$arrcodigos){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
	
	if($maestro != ""){
      $sql = "";
      $sql.= $ClsAsi->desasignacion_completa_maestro_grupo($maestro);
      if(is_array($arrcodigos)){
         $count = count($arrcodigos); //cuenta cuantas vienen en el array
         for($i = 0; $i < $count; $i++){
            $sql.= $ClsAsi->asignacion_maestro_grupo($arrcodigos[$i],$maestro);
         }
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Grupos asignados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


///////::_______

function Quitar_Maestro_Seccion($maestro,$pensum,$nivel,$grado,$tipo,$secciones,$filas){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   if($maestro != "" && $filas > 0){
		$sql = "";
      for($i = 0; $i < $filas; $i++){
			//////// REVISA SI TIENE ASIGNADAS MATERIAS EN ESAS SECCIONES //////
			$result = $ClsAcadem->comprueba_materia_seccion_maestro($pensum,$nivel,$grado,$secciones[$i],'',$maestro);
			if(is_array($result)){ ///// SI TIENE ENTONCES
				foreach($result as $row){
					$materia = $row["secmat_materia"];
					$sql.= $ClsAcadem->delete_materia_seccion_maestro($pensum,$nivel,$grado,$secciones[$i],$materia,$maestro); /////// DES-ASIGNA AL MAESTRO DE IMPARTIR DICHAS MATERIAS SELECCIONADA A LAS SECCIONES REGISTRADAS
				}
			}
			//////// DES-ASIGNA AL MAESTRO A LA SECCION //////
			$sql.= $ClsAcadem->delete_seccion_maestro($pensum,$nivel,$grado,$secciones[$i],$maestro);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
         $respuesta->script("Busca_Secciones_Maestro('$maestro',$pensum,$nivel,$grado,'$tipo');");
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Quitar_Maestro_Materia($maestro,$pensum,$nivel,$grado,$tipo,$materias,$filas){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   if($maestro != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
		 //////// REVISA SI TIENE ASIGNADAS SECCIONES EN ESAS MATERIAS //////
			$result = $ClsAcadem->comprueba_materia_seccion_maestro($pensum,$nivel,$grado,'',$materias[$i],$maestro);
			if(is_array($result)){ ///// SI TIENE ENTONCES
				foreach($result as $row){
					$seccion = $row["secmat_seccion"];
					$sql.= $ClsAcadem->delete_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materias[$i],$maestro); /////// DES-ASIGNA AL MAESTRO DE IMPARTIR DICHAS MATERIAS SELECCIONADA A LAS SECCIONES REGISTRADAS
				}
			}
			//////// DES-ASIGNA AL MAESTRO A LA SECCION //////
		 $sql.= $ClsAcadem->delete_materia_maestro($pensum,$nivel,$grado,$materias[$i],$maestro);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
         $respuesta->script("Busca_Materias_Maestro('$maestro',$pensum,$nivel,$grado,'$tipo');");
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Quitar_Maestro_Grupos($maestro,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   if($maestro != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
		 //$respuesta->alert("$grupos[$i],$maestro");   
		 $sql.= $ClsAsi->desasignacion_maestro_grupo($grupos[$i],$maestro);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
         $respuesta->script("Busca_Grupos_Maestro('$maestro',$area);");
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}

function Delete_Materia_Seccion_Maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   if($maestro != "" && $materia != "" && $seccion != "" && $grado != "" && $nivel != "" && $pensum != ""){
      $sql.= $ClsAcadem->delete_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro); /////// DES-ASIGNA AL MAESTRO DE IMPARTIR DICHAS MATERIAS SELECCIONADA A LAS SECCIONES REGISTRADAS
		//$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros eliminados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


////////////////////////// ASIGNACION DE CURSOS LIBRES ///////////////////////////////

function Graba_Maestro_Curso($maestro,$curso){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	
	if($maestro != "" && $curso != ""){
     	$sql = $ClsCur->insert_curso_maestro($curso,$maestro);
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


function Delete_Maestro_Curso($maestro,$curso){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	
	if($maestro != "" && $curso != ""){
     	$sql = $ClsCur->delete_curso_maestro($curso,$maestro);
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
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
//////////////////---- MAESTROS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Maestro");
$xajax->register(XAJAX_FUNCTION, "Buscar_Maestro");
$xajax->register(XAJAX_FUNCTION, "Modificar_Maestro");
$xajax->register(XAJAX_FUNCTION, "Situacion_Maestro");
$xajax->register(XAJAX_FUNCTION, "Send_Mail");
////////////////////////// ASIGNACION DE GRUPOS, SECCIONES, MATERIAS Y MAESTROS ////////
$xajax->register(XAJAX_FUNCTION, "Graba_Maestro_Seccion");
$xajax->register(XAJAX_FUNCTION, "Graba_Maestro_Materia");
$xajax->register(XAJAX_FUNCTION, "Graba_Maestro_Grupos");
$xajax->register(XAJAX_FUNCTION, "Quitar_Maestro_Seccion");
$xajax->register(XAJAX_FUNCTION, "Quitar_Maestro_Materia");
$xajax->register(XAJAX_FUNCTION, "Quitar_Maestro_Grupos");
$xajax->register(XAJAX_FUNCTION, "Delete_Materia_Seccion_Maestro");
////////////////////////// ASIGNACION DE CURSOS LIBRES ////////
$xajax->register(XAJAX_FUNCTION, "Graba_Maestro_Curso");
$xajax->register(XAJAX_FUNCTION, "Delete_Maestro_Curso");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  