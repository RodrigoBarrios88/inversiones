<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_temporal.php");

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


function Grado_Seccion($pensum,$nivel,$grado,$idsec,$idssec,$accsec){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idsec,$idssec,$accsec");
    $contenido = seccion_html($pensum,$nivel,$grado,'',$idsec,$accsec);
    $respuesta->assign($idssec,"innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- Temporal Alumnos -----/////////////////////////////////////////////
function Grabar_Alumno($codigo,$nom,$ape,$pensum,$nivel,$grado,$seccion){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTempAlu = new ClsTempAlumno();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	
	if($codigo !="" && $nom !="" && $ape != "" && $pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		//$respuesta->alert("$id");
		$sql = $ClsTempAlu->insert_alumno($codigo,$nom,$ape,$pensum,$nivel,$grado,$seccion); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsTempAlu->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("boton","value","G");
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Alumno($codigo){
   $respuesta = new xajaxResponse();
   $ClsTempAlu = new ClsTempAlumno();
   //$respuesta->alert("$codigo");
		$cont = $ClsTempAlu->count_alumno($codigo);
		if($cont>0){
			if($cont==1){
				    $result = $ClsTempAlu->get_alumno($codigo);
				    foreach($result as $row){
						$codigo = $row["talu_codigo"];
						$respuesta->assign("codigo","value",$codigo);
				    	$ape = utf8_decode($row["talu_apellido"]);
						$respuesta->assign("ape","value",$ape);
						$nom = utf8_decode($row["talu_nombre"]);
						$respuesta->assign("nom","value",$nom);
						$pensum = $row["talu_pensum"];
						$respuesta->assign("pensum","value",$pensum);
						$nivel = $row["talu_nivel"];
						$grado = $row["talu_grado"];
						$seccion = $row["talu_seccion"];
				}
				//--
				$contenido = nivel_html($pensum,'nivel','Combo_Grado();');
				$respuesta->assign('divnivel',"innerHTML",$contenido);
				$respuesta->assign("nivel","value",$nivel);
				//--
				$contenido = grado_html($pensum,$nivel,'grado','Combo_Seccion();');
				$respuesta->assign('divgrado',"innerHTML",$contenido);
				$respuesta->assign("grado","value",$grado);
				//--
				$contenido = seccion_html($pensum,$nivel,$grado,'','seccion','Submit();');
				$respuesta->assign('divseccion',"innerHTML",$contenido);
				$respuesta->assign("seccion","value",$seccion);
			}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->assign("boton","value","M");
			$respuesta->script("cerrar();");
	   	}	
   return $respuesta;
}


function Modificar_Alumno($codigo,$nom,$ape,$pensum,$nivel,$grado,$seccion){
   $respuesta = new xajaxResponse();
   $ClsTempAlu = new ClsTempAlumno();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	if($codigo != ""){
		if($nom !="" && $ape != "" && $pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
			$sql = $ClsTempAlu->modifica_alumno($codigo,$nom,$ape,$pensum,$nivel,$grado,$seccion);
			//$respuesta->alert("$sql");
			$rs = $ClsTempAlu->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->assign("boton","value","G");
			}else{
				$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			   $respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').disabled = false;");
				$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
			   $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			   $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
	       $msj = '<h5>Error de Traslaci&oacute;n..., refresque la pagina e intente de nuevo</h5><br><br>';
	       $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
	       $respuesta->assign("lblparrafo","innerHTML",$msj);
	       $respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
	       $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
	       $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Alumno($codigo,$sit){
   $respuesta = new xajaxResponse();
   $ClsTempAlu = new ClsTempAlumno();

	//$respuesta->alert("$codigo,$sit");
	if($codigo != ""){
		$sql = $ClsTempAlu->cambia_sit_alumno($codigo,$sit);
		//$respuesta->alert("$sql");
		$rs = $ClsTempAlu->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Alumno inhabilitado Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("boton","value","G");
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}

	return $respuesta;
}


//////////////////---- SINCRONIZACION -----/////////////////////////////////////////////
function Sincronizar_Alumnos($arrcodigo,$arrcui,$arrnom,$arrape,$filas){
   $respuesta = new xajaxResponse();
   $ClsTempAlu = new ClsTempAlumno();

	//$respuesta->alert("$codigo,$sit");
	if($filas != ""){
		$sql = "";
		for($i = 0; $i < $filas; $i++){
				$codigo = $arrcodigo[$i];
				$cui = $arrcui[$i];
				$nom = $arrnom[$i];
				$ape = $arrape[$i];
			//pasa a mayusculas
				$nom = trim($nom);
				$ape = trim($ape);
			//--------
			//decodificaciones de tildes y Ñ's
				$nom = utf8_encode($nom);
				$ape = utf8_encode($ape);
				//--
				$nom = utf8_decode($nom);
				$ape = utf8_decode($ape);
			//--------
			$sql.= $ClsTempAlu->sincroniza_alumno($cui,$codigo,$nom,$ape);
			$sql.= $ClsTempAlu->cambia_sit_alumno($codigo,2);
		}
		
		//$respuesta->alert("$sql");
		$rs = $ClsTempAlu->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Secci&oacute;n sincronizada completa Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("boton","value","G");
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}

	return $respuesta;
}

//////////////////---- VARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Seccion");
//////////////////---- PADRES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Buscar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Modificar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Situacion_Alumno");
//////////////////---- SINCRONIZACION -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Sincronizar_Alumnos");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  