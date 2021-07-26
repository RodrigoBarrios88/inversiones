<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_inscripciones.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


function Situacion_Boleta($referencia,$contrato){ //$referencia -> codigo de boleta, $documento-> No. de Referencia
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   $ClsIns = new ClsInscripcion();
	$ClsBan = new ClsBanco();
	
	if($referencia != "" && $contrato != ""){
      $cuenta = $ClsIns->cuenta;
		$banco = $ClsIns->banco;
		//-
		$result = $ClsBol->get_boleta_cobro($referencia);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["bol_codigo"];
				$periodo = $row["bol_periodo_fiscal"];
				$cuenta = $row["bol_cuenta"];
				$banco = $row["bol_banco"];
				$alumno = $row["bol_alumno"];
				$codint = $row["bol_codigo_interno"];
				$documento = $row["bol_referencia"];
				$tipo = $row["bol_tipo"];
				$monto = $row["bol_monto"];
				$motivo = $row["bol_motivo"];
				$descuento = $row["bol_descuento"];
				$motivo_desc = $row["bol_motivo_descuento"];
			}
			$fechor = date("d/m/Y h:i:s");
			$fecha = date("d/m/Y");
			$cod = $ClsBan->max_mov_cuenta($cuenta,$banco);
			$cod++;
			//Query
			$sql.= $ClsBan->insert_mov_cuenta($cod,$cuenta,$banco,'I',$monto,'DP','BOLETA DE PAGO',$documento,$fecha);
			$sql.= $ClsBan->saldo_cuenta_banco($cuenta,$banco,$monto,"+");
			$sql.= $ClsBol->insert_pago_boleta_cobro($periodo, $alumno,$codint,$documento,$cuenta,$banco,0,"",$monto,0,0,0,$fechor);
			$sql.= $ClsBol->cambia_pagado_boleta_cobro($codigo,1); // si el pago esta enlazado a alguna boleta, le cancela la situacion de pagada
		}
      //--
		$sql.= $ClsIns->cambia_sit_status($contrato,4);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La boletan fue tomada como PAGADA y el Contrato No. '.$contrato.' subio de estatus...", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


function Anular_Boleta($referencia){
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   $ClsIns = new ClsInscripcion();
	if($referencia != ""){
      $sql = $ClsBol->cambia_sit_boleta_cobro($referencia,"Anulada desde la interfaz grafica de Inscripciones del Colegio", 0);
		$rs = $ClsBol->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La boleta fue ANULADA con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}



function Regresar_Contrato($contrato,$alumno,$comentario){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	//limpia cadena
		$comentario = trim($comentario);
	//--------
	//decodificaciones de tildes y Ñ's
		$comentario = utf8_encode($comentario);
	//--------
		$comentario = utf8_decode($comentario);
	//--------
	if($contrato != ""){
		$codigo = $ClsIns->max_comentario($contrato,$alumno);
		$codigo++;
		$sql.= $ClsIns->insert_comentario($codigo,$contrato,$alumno,$comentario);
		$sql.= $ClsIns->cambia_sit_status($contrato,1);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->redirect("FRMaprobacion.php",0);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}



function Aprobacion_Contrato($contrato){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	if($contrato != ""){
		$sql = $ClsIns->cambia_sit_status($contrato,5);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->redirect("FRMaprobacion.php",0);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}



function Recepcion_Contrato($contrato){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	if($contrato != ""){
		$sql = $ClsIns->cambia_sit_status($contrato,6);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->redirect("FRMrecepcion.php",0);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}

function Inscribir_Alumno($pensum,$nivel,$grado,$cuinew,$cuiold,$codint){
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $cuinew != ""){
		/////// Actualizacion de CUI //////////
		$result = $ClsAlu->get_alumno($cuinew,'','',1);
		if(is_array($result)){ ///// Valida si el cui ya estaba registrado correctamente
			///Ya registrado
			$sql = $ClsAlu->update_inscripcion_alumno_existente($cuinew);
			//$respuesta->alert("entro en existente");
		}else{/// Si no estaba registrado correctamente
			$codint = ($codint == "")?"101010101":$codint;
			$result = $ClsAlu->get_alumno_codigo_interno($codint);
			if(is_array($result)){ ///// Valida si el Codigo Interno ya estaba registrado (SI->actualiza CUI)
				///Ya registrado pero con el cui anterior INCORRECTO
				$sql = $ClsAlu->update_cui_alumno_todo($cuinew,$cuiold);
				$sql.= $ClsAlu->update_inscripcion_alumno_existente($cuinew);
				//$respuesta->alert("entro en existente con CUI malo");
			}else{/// Si no estaba registrado -> Ingreso Nuevo
				$sql = $ClsAlu->insert_inscripcion_nuevo_alumno($cuinew);
				//$respuesta->alert("entro en nuevo ingreso");
			}
		}
		/////// Inscripcion en Pensum y Asignacion a grado
		if($nivel == 1){
			////// Aplica solo para los olivos, correccion en el orden de grados (Maternal se grabo de ultimo como codigo 4, corre todas las posiciones un puesto abajo)
			switch($grado){
				case 1: $grado = 4; break;
				case 2: $grado = 1; break;
				case 3: $grado = 2; break;
				case 4: $grado = 3; break;
			}
		}
		$codigo = $ClsAcad->max_grado_alumno($pensum,$nivel,$grado,$cuinew);
		$codigo++;
		$sql.= $ClsAcad->delete_grado_alumno($pensum,$nivel,$cuinew);
		$sql.= $ClsAcad->insert_grado_alumno($pensum,$nivel,$grado,$codigo,$cuinew);
		 
		$rs = $ClsAcad->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "El Alumno fue inscrito al nuevo Ciclo Escolar activo!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}



function Quitar_Bloqueo($cui){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	if($cui != ""){
		$sql = $ClsIns->insert_bitacora_bloaqueados($cui);
		$sql.= $ClsIns->delete_bloaqueados($cui);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->redirect("FRMblacklist.php",0);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}

//////////////////---- CLIENTES -----/////////////////////////////////////////////
function Show_Cliente($nit){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //$respuesta->alert("$nit,");
	if($nit != ""){
		$result = $ClsCli->get_cliente('',$nit,'');
		if(is_array($result)){
			foreach($result as $row){
				$cod = $row["cli_id"];
				$respuesta->assign("cli","value",$cod);
				$nom = trim($row["cli_nombre"]);
				$respuesta->assign("cliente","value",$nom);
				$nit = trim($row["cli_nit"]);
				$respuesta->assign("nit","value",$nit);
			}
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script("validaCliente('$nit','');");
		}
	}else{
		$respuesta->assign("nit","value","");
		$respuesta->assign("cliente","value","");
		$respuesta->assign("cli","value","");
		$respuesta->script("cerrar();");
	}
	
	return $respuesta;
}


function Grabar_Cliente($nit,$nom,$direc,$tel1,$tel2,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //limpia cadena
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
	//--------
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	 //$respuesta->alert("$nit,$nom,$direc,$tel1,$tel2,$mail,");
    if($nit != "" && $nom != "" && $direc != ""){
		$cod = $ClsCli->max_cliente();
		$cod++; /// Maximo codigo de Cliente
		//$respuesta->alert("$id");
		$sql = $ClsCli->insert_cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail); /// Inserta Cliente
		//$respuesta->alert("$sql");
		$rs = $ClsCli->exec_sql($sql);
		if($rs == 1){
			$respuesta->assign("cli","value",$cod);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("cliente","value",$nom);
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   
   return $respuesta;
}


function Modificar_Cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //limpia cadena
		$nom = trim($nom);
		$direc = trim($direc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cod != ""){
		if($nit != "" && $nom != "" && $direc != ""){
			$sql = $ClsCli->modifica_cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail);
			$rs = $ClsCli->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("cli","value",$cod);
            $respuesta->assign("nit","value",$nit);
            $respuesta->assign("cliente","value",$nom);
            $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n, refresque la pagina e intente de nuevo...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


//////////////////---- Utilitaria -----/////////////////////////////////////////////

function depmun($dep,$idmun,$idsmun){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = municipio_html($dep,$idmun); 
	$respuesta->assign($idsmun,"innerHTML",$contenido); 
	return $respuesta;
}


function Nivel_Grado($nivel,$idgra,$idsgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$nivel,$idgra,$idsgra");
	$contenido = inscripcion_grado_html($nivel,$idgra,"");
	$respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}



function Calcular_Edad($fecnac){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("edad","value","$edad años");
	}	

   return $respuesta;
}



function Calcular_Edad_Contrato($fecnac){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("contraedad","value","$edad años");
	}	

   return $respuesta;
}


//////////////////---- MODIFICACIONES -----/////////////////////////////////////////////

function Actualiza_Alumno($cuinew,$cuiold,$tipocui,$codigo,$nombre,$apellido,$genero,$fecnac,$nacionalidad,$religion,$idioma,$mail,$sangre,$alergico,$emergencia,$emergencia_tel){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	//$respuesta->alert("entro $cuinew");
   if($cuinew != ""){
		//limpia cadena
			$nombre = trim($nombre);
			$apellido = trim($apellido);
			$alergico = trim($alergico);
			$emergencia = trim($emergencia);
			//--//
			$nacionalidad = trim($nacionalidad);
			$religion = trim($religion);
			$idioma = trim($idioma);
			$mail = trim($mail);
		//--------
		//decodificaciones de tildes y Ñ's
			$nombre = utf8_encode($nombre);
			$apellido = utf8_encode($apellido);
			$alergico = utf8_encode($alergico);
			$emergencia = utf8_encode($emergencia);
			$nacionalidad = utf8_encode($nacionalidad);
			$religion = utf8_encode($religion);
			$idioma = utf8_encode($idioma);
		//--
			$nombre = utf8_decode($nombre);
			$apellido = utf8_decode($apellido);
			$alergico = utf8_decode($alergico);
			$emergencia = utf8_decode($emergencia);
			$nacionalidad = utf8_decode($nacionalidad);
			$religion = utf8_decode($religion);
			$idioma = utf8_decode($idioma);
		//--------
		
		$sql.= $ClsIns->modifica_alumno($cuinew,$tipocui,$codigo,$nombre,$apellido,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emergencia_tel,$mail); /// Modificar;
		
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La informac\u00F3n fue corregida con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Actualiza_Grado($cuinew,$nivel,$grado){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	
   if($cuinew != ""){
		$sql = $ClsIns->delete_grado_alumno($cuinew);
		$sql.= $ClsIns->insert_grado_alumno($nivel,$grado,$cuinew);
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La informac\u00F3n fue corregida con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}


function Actualiza_Nit($cuinew,$cliente){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	
   if($cuinew != ""){
		$sql = $ClsIns->modifica_alumno_cliente($cuinew,$cliente); /// Grabar;
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La informac\u00F3n fue corregida con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Actualiza_Seguro($cuinew,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	
   if($cuinew != ""){
		//limpia cadena
			$poliza = trim($poliza);
			$aseguradora = trim($aseguradora);
			$plan = trim($plan);
			$asegurado = trim($asegurado);
			$instrucciones = trim($instrucciones);
			$comentarios = trim($comentarios);
		//--------
		//decodificaciones de tildes y Ñ's
			$poliza = utf8_encode($poliza);
			$aseguradora = utf8_encode($aseguradora);
			$plan = utf8_encode($plan);
			$asegurado = utf8_encode($asegurado);
			$instrucciones = utf8_encode($instrucciones);
			$comentarios = utf8_encode($comentarios);
			//--
			$poliza = utf8_decode($poliza);
			$aseguradora = utf8_decode($aseguradora);
			$plan = utf8_decode($plan);
			$asegurado = utf8_decode($asegurado);
			$instrucciones = utf8_decode($instrucciones);
			$comentarios = utf8_decode($comentarios);
		//--------
		
		$sql = $ClsIns->update_seguro($cuinew,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios); /// Grabar;
		
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La informac\u00F3n fue corregida con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Actualiza_Datos_Contrato($contrato,$cuinew,$contradpi,$contratipodpi,$contranombre,$contraapellido,$contrafecnac,$contraparentesco,$contraecivil,$contranacionalidad,$contramail,$contratelcasa,$contracelular,$contradireccion,$contradepartamento,$contramunicipio,$contratrabajo,$contrateltrabajo,$contraprofesion){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	if($cuinew != ""){
		//limpia cadena
			$contranombre = trim($contranombre);
			$contraapellido = trim($contraapellido);
			$contranacionalidad = trim($contranacionalidad);
			$contradireccion = trim($contradireccion);
			$contratrabajo = trim($contratrabajo);
			$contraprofesion = trim($contraprofesion);
		//--------
		//decodificaciones de tildes y Ñ's
			$contranombre = utf8_encode($contranombre);
			$contraapellido = utf8_encode($contraapellido);
			$contranacionalidad = utf8_encode($contranacionalidad);
			$contradireccion = utf8_encode($contradireccion);
			$contratrabajo = utf8_encode($contratrabajo);
			$contraprofesion = utf8_encode($contraprofesion);
		//--
			$nombre = utf8_decode($nombre);
			$apellido = utf8_decode($apellido);
			$alergico = utf8_decode($alergico);
			$emergencia = utf8_decode($emergencia);
			$contranombre = utf8_decode($contranombre);
			$contraapellido = utf8_decode($contraapellido);
			$contranacionalidad = utf8_decode($contranacionalidad);
			$contradireccion = utf8_decode($contradireccion);
			$contratrabajo = utf8_decode($contratrabajo);
			$contraprofesion = utf8_decode($contraprofesion);
		//--------
			
      $sql = $ClsIns->update_status($contrato,$cuinew,$contradpi,$contratipodpi,$contranombre,$contraapellido,$contrafecnac,$contraparentesco,$contraecivil,$contranacionalidad,$contramail,$contratelcasa,$contracelular,$contradireccion,$contradepartamento,$contramunicipio,$contratrabajo,$contrateltrabajo,$contraprofesion); /// Modificar;             
			
      //// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente", "La informac\u00F3n fue corregida con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}


function Modificar_CUI($cui,$cuinew){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   
	if($cui != "" && $cuinew){
		$sql = $ClsIns->cambia_CUI($cui,$cuinew);
      $rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cambio de CUI realizado exitosamente!", "success").then((value)=>{ window.location.href="FRMeditmenu.php?cui='.$cuinew.'"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	
   return $respuesta;
}


/////////////////////////////////////---- COMENTARIOS -----/////////////////////////////////////////////
function Seleccionar_Comentario($codigo,$contrato,$alumno){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   //$respuesta->alert("$codigo,$contrato,$alumno");
	if($codigo != ""){
		$result = $ClsIns->get_comentario($codigo,$alumno,$contrato);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["comen_codigo"];
				$respuesta->assign("codigo","value",$codigo);
				$comentario = utf8_decode($row["comen_comentario"]);
				$respuesta->assign("coment","value",$comentario);
			}
		}
	}
	
	return $respuesta;
}


function Editar_Comentario($codigo,$contrato,$alumno,$comentario){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	if($comentario != ""){
		$sql = $ClsIns->update_comentario($codigo,$contrato,$comentario,0);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script("Regresar_Contrato('$contrato','$alumno');");
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Debe escribir algo en el comentario!", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


function Eliminar_Comentario($codigo,$contrato,$alumno){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	if($codigo != ""){
		$sql = $ClsIns->cambia_situacion_comentario($codigo,$contrato,$alumno,0);
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script("Regresar_Contrato('$contrato','$alumno');");
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


//////////////////---- INSCRIPCIONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Situacion_Boleta");
$xajax->register(XAJAX_FUNCTION, "Anular_Boleta");
$xajax->register(XAJAX_FUNCTION, "Regresar_Contrato");
$xajax->register(XAJAX_FUNCTION, "Aprobacion_Contrato");
$xajax->register(XAJAX_FUNCTION, "Recepcion_Contrato");
$xajax->register(XAJAX_FUNCTION, "Inscribir_Alumno");
$xajax->register(XAJAX_FUNCTION, "Quitar_Bloqueo");
//////////////////---- UTILITARIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad_Contrato");
//////////////////---- CLIENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");
//////////////////---- MODIFICACIONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Actualiza_Alumno");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Grado");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Nit");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Seguro");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Datos_Contrato");
$xajax->register(XAJAX_FUNCTION, "Modificar_CUI");
//////////////////---- COMENTARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Seleccionar_Comentario");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Comentario");

//El objeto xajax tiene que procesar cualquier petici&oacute;n
$xajax->processRequest();

?>  