<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_inscripcion.php");

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

//--
function Nivel_Grado($nivel,$idgra,$idsgra,$fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$nivel,$idgra,$idsgra,$fila");
	$contenido = inscripcion_grado_html($nivel,$idgra.$fila,"");
	$respuesta->assign($idsgra.$fila,"innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- CLIENTES -----/////////////////////////////////////////////
function Show_Cliente($nit,$fila){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //$respuesta->alert("$nit,$fila");
	if($nit != ""){
		$result = $ClsCli->get_cliente('',$nit,'');
		if(is_array($result)){
			foreach($result as $row){
				$nit = trim($row["cli_nit"]);
				$respuesta->assign("nit$fila","value",$nit);
				$nombre = utf8_decode($row["cli_nombre"]);
				$respuesta->assign("clinombre$fila","value",$nombre);
				$direccion = utf8_decode($row["cli_direccion"]);
				$respuesta->assign("clidireccion$fila","value",$direccion);
			}
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script("cerrar();");
		}
	}else{
		$respuesta->script("cerrar();");
	}
	
	return $respuesta;
}


//////////////////---- Alumnos -----/////////////////////////////////////////////

function Calcular_Edad($fecnac,$fila){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("edad$fila","value","$edad años");
	}	

   return $respuesta;
}



function Calcular_Edad_Contrato($fecnac,$fila){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("contraedad$fila","value","$edad años");
	}	

   return $respuesta;
}



function Actualizar_Padre($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion){
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
		$fecnac = trim($fecnac);
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
	if($dpi != "" && $nombre != "" && $apellido != ""){
		//$sql.= $ClsPad->modifica_padre($dpi,$nom,$ape,$tel,$mail,$dir,$trabajo);
		$sql.= $ClsPad->modifica_padre_perfil($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion);
		$rs = $ClsPad->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Tus datos han sido actualizados, ahora vamos por los de tu(s) hijo(s)...", "success").then((value)=>{ window.location.href="FRMpaso1B.php" });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}




function Actualiza_Hijos($padre,$arrcontrato,$arrcuinew,$arrcuiold,$arrtipocui,$arrcodigo,$arrnombre,$arrapellido,$arrgenero,$arrfecnac,$arrnacionalidad,$arrreligion,$arridioma,$arrmail,$arrsangre,$arralergia,$arremergencia,$arremetel,$hijos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	//$respuesta->alert("entro");
   if($hijos > 0){
		$sql = "";
		//--
		for($i = 1; $i <= $hijos; $i ++){
			$contrato = $arrcontrato[$i];
			$cuinew = $arrcuinew[$i];
			$cuiold = $arrcuiold[$i];
			$codigo = $arrcodigo[$i];
			$tipocui = $arrtipocui[$i];
			$nombre = $arrnombre[$i];
			$apellido = $arrapellido[$i];
			$genero = $arrgenero[$i];
			$fecnac = $arrfecnac[$i];
			$fecnac = trim($fecnac);
         $nacionalidad = $arrnacionalidad[$i];
			$religion = $arrreligion[$i];
			$idioma = $arridioma[$i];
			$mail = $arrmail[$i];
			$sangre = $arrsangre[$i];
			$alergico = $arralergia[$i];
			$emergencia = $arremergencia[$i];
			$emergencia_tel = $arremetel[$i];
			
			//pasa a mayusculas
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
		}
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('window.location.href="FRMpaso1C.php"');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Actualiza_Datos_Generales($arrcontrato,$arrcuinew,$arrnivel,$arrgrado,$arrnit,$arrclinombre,$arrclidireccion,$hijos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	
   if($hijos > 0){
		$sql = "";
		for($i = 1; $i <= $hijos; $i ++){
			$contrato = $arrcontrato[$i];
			$cuinew = $arrcuinew[$i];
			$nivel = $arrnivel[$i];
			$grado = $arrgrado[$i];
			$nit = $arrnit[$i];
			$clinombre = $arrclinombre[$i];
			$clidireccion = $arrclidireccion[$i];
			
			//$respuesta->alert("$status,$contrato,$cuinew,$nivel,$grado,$cliente");
			$sql.= $ClsIns->modifica_alumno_cliente($cuinew,$nit,$clinombre,$clidireccion); /// actualizar;
			$sql.= $ClsIns->delete_grado_alumno($cuinew);
			$sql.= $ClsIns->insert_grado_alumno($nivel,$grado,$cuinew);
         //$respuesta->alert("$sql");
		}
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('window.location.href="FRMpaso1D.php"');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Actualiza_Seguro($arrcontrato,$arrcuinew,$arrseguro,$arrpoliza,$arrasegura,$arrplan,$arrasegurado,$arrinstuc,$arrcomment,$hijos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	
   if($hijos > 0){
		$sql = "";
		for($i = 1; $i <= $hijos; $i ++){
			$contrato = $arrcontrato[$i];
			$cuinew = $arrcuinew[$i];
			$seguro = $arrseguro[$i];
			$poliza = $arrpoliza[$i];
			$aseguradora = $arrasegura[$i];
			$plan = $arrplan[$i];
			$asegurado = $arrasegurado[$i];
			$instrucciones = $arrinstuc[$i];
			$comentarios = $arrcomment[$i];
			
			//pasa a mayusculas
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
			
			//$respuesta->alert("$cuinew,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios");
			$sql.= $ClsIns->update_seguro($cuinew,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios); /// Grabar;
		}
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('window.location.href="FRMpaso1E.php"');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Actualiza_Datos_Contrato($arrcontrato,$arrcuinew,$arrCdpi,$arrCtipodpi,$arrCnombre,$arrCapellido,$arrCfecnac,$arrCparentesco,$arrCecivil,$arrCnacionalidad,
											 $arrCmail,$arrCtelcasa,$arrCcelular,$arrCdireccion,$arrCdepartamento,$arrCmunicipio,$arrCtrabajo,$arrCteltrabajo,$arrCprofesion,$hijos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
	//$respuesta->alert("entro");
   if($hijos > 0){
		$sql = "";
		for($i = 1; $i <= $hijos; $i ++){
			$contrato = $arrcontrato[$i];
			$cuinew = $arrcuinew[$i];
			//--
			$contradpi = $arrCdpi[$i];
			$contratipodpi = $arrCtipodpi[$i];
			$contranombre = $arrCnombre[$i];
			$contraapellido = $arrCapellido[$i];
			$contrafecnac = $arrCfecnac[$i];
			$contrafecnac = trim($contrafecnac);
			$contraparentesco = $arrCparentesco[$i];
			$contraecivil = $arrCecivil[$i];
			$contranacionalidad = $arrCnacionalidad[$i];
			$contramail = $arrCmail[$i];
			$contratelcasa = $arrCtelcasa[$i];
			$contracelular = $arrCcelular[$i];
			$contradireccion = $arrCdireccion[$i];
			$contradepartamento = $arrCdepartamento[$i];
			$contramunicipio = $arrCmunicipio[$i];
			$contratrabajo = $arrCtrabajo[$i];
			$contrateltrabajo = $arrCteltrabajo[$i];
			$contraprofesion = $arrCprofesion[$i];
			//pasa a mayusculas
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
			
			$sql.= $ClsIns->update_status($contrato,$cuinew,$contradpi,$contratipodpi,$contranombre,$contraapellido,$contrafecnac,$contraparentesco,$contraecivil,$contranacionalidad,$contramail,$contratelcasa,$contracelular,$contradireccion,$contradepartamento,$contramunicipio,$contratrabajo,$contrateltrabajo,$contraprofesion); /// Modificar;             
			//////// Valida el status actual del proceso
			$status = 10; //da un numeor elevado como seguro por si NO entra al if(is_array)
			$result = $ClsIns->get_status($cuinew);
         if(is_array($result)){
            foreach($result as $row){
               $status = $row["stat_situacion"];
               $situacion_boleta = $row["alu_boleta_situacion"];
            }
         }
         if($status <= 2){ //valida si el proceso se enuentra en el paso 1 o 2.  Si el proceso esta mas avanzado no modifica el status....
            if($situacion_boleta == ""){ //NO se ha generado boleta
               $sql.= $ClsIns->cambia_sit_status($contrato,2); /// envia el proceso al paso # 2;
            }else if($situacion_boleta == 0){ // SE generó boleta, pero está anulada
               $sql.= $ClsIns->cambia_sit_status($contrato,2); /// envia el proceso al paso # 2;
            }else{ // YA se enró boleta
               $sql.= $ClsIns->cambia_sit_status($contrato,3); /// envia el proceso al paso # 3;
            }
         } // de lo contrario sigue en el status avanado que lleva
      }
		//// ejecuta SQL
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "El Paso # 1 ha sido completado (Actualizaci\u00F3n de Datos); Pasemos al Paso # 2 (Generaci\u00F3n y Pago de Boleta de Inscripci\u00F3n)...", "success").then((value)=>{ window.location.href="FRMpaso2.php" });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}



function Generar_Boleta_Inscripcion($cui){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   $ClsAcad = new ClsAcademico();
   $ClsBol = new ClsBoletaCobro();
   
	if($cui != ""){
      //--Valida que no tenga boleta creada
		$result = $ClsIns->get_boleta_cobro('','','',$cui,'',date("Y"),'','','','1,2','',''); // QUERY ESPECIAL PARA INSCRICPIONES (Ubicado en la ClsInscripciones)
		if(is_array($result)){
			$respuesta->script('swal("Ya cuenta con Boleta de Inscripci\u00F3n!", "Este alumno ya cuenta con boleta de inscripci\u00F3n, no es necesario generar otra boleta, solo re-imprima la autorizada para pagar en el banco....", "error").then((value)=>{ cerrar(); });');
         //$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{  });');
			return $respuesta;
		}
		/// Trae el nivel y Grado del Sistema Real
      $pensum = $_SESSION["pensum"];
		$result = $ClsAcad->get_grado_alumno($pensum,'','',$cui);
		if(is_array($result)){
         $reinscripcion = true;
		}else{
         $reinscripcion = false;
      }
      ///nivel a inscribirse
      $result = $ClsIns->get_grado_alumno('','',$cui);
      if(is_array($result)){
         foreach($result as $row){
            $nivel = $row["graa_nivel"];
            $grado = $row["graa_grado"];
         }
      }
      
      switch($nivel){
			case 1:
				$monto = 460;
				$descuento = 0;
				$motdescuento = '';
				$motivo = ($reinscripcion == true)?trim('RE-INSCRIPCION DE PREESCOLAR'):trim('INSCRIPCION DE PREESCOLAR');
				break;
			case 2:
				$monto = 575;
				$descuento = 0;
				$motdescuento = '';
				$motivo = ($reinscripcion == true)?trim('RE-INSCRIPCION DE ELEMENTARY SCHOOL'):trim('INSCRIPCION DE ELEMENTARY SCHOOL');
				break;
			case 3:
				$monto = 661;
				$descuento = 0;
				$motdescuento = '';
				$motivo = ($reinscripcion == true)?trim('RE-INSCRIPCION DE MIDDLE SCHOOL'):trim('INSCRIPCION DE MIDDLE SCHOOL');
				break;
			case 4:
				$monto = 675;
				$descuento = 0;
				$motdescuento = '';
				$motivo = ($reinscripcion == true)?trim('RE-INSCRIPCION DE HIGH SCHOOL'):trim('INSCRIPCION DE HIGH SCHOOL');
				break;
		}
		
		if($nivel == 3 && $grado == 1){
		    $monto = 575;
		}else if($nivel == 4 && $grado == 1){
		    $monto = 661;
		}
		
		//// DESCUENTOS POR FECHAS
		$hoy = strtotime( date('Y-m-d') );
		$desc1 = strtotime( '2020-08-31' );
		$desc2 = strtotime( '2020-09-30' );
		$desc3 = strtotime( '2020-10-31' );
		$desc4 = strtotime( '2020-11-30' );
		$desc5 = strtotime( '2020-12-31' );
		//----
		if($hoy <= $desc1){
			if($reinscripcion == true){ /// Indica que es re-Inscripcion
				$descporcent = ($reinscripcion == true)?100:50;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 31/08/2020';
			}else{ /// No es Re-Inscripcion (Inscripcion Nueva)
				$descporcent = 50;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 31/08/2020';
			}
		}else if($hoy <= $desc2 && $hoy > $desc1){
			if($reinscripcion == true){ /// Indica que es re-Inscripcion
				$descporcent = ($reinscripcion == true)?100:50;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 30/09/2020';
			}else{ /// No es Re-Inscripcion (Inscripcion Nueva)
				$descporcent = 50;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 30/09/2020';
			}
		}else if($hoy <= $desc3 && $hoy > $desc2){
		    if($reinscripcion == true){ /// Indica que es re-Inscripcion
				$descporcent = ($reinscripcion == true)?100:50;
				$respuesta->alert("$reinscripcion");
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 31/10/2020';
			}else{ /// No es Re-Inscripcion (Inscripcion Nueva)
				$descporcent = 50;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 31/10/2020';
			}
		}else if($hoy <= $desc4 && $hoy > $desc3){
			if($reinscripcion == true){ /// Indica que es re-Inscripcion
				$descporcent = 0;
				$descuento = 0; //// establece el monto de descuento
				$motdescuento = '';
			}else{ /// No es Re-Inscripcion (Inscripcion Nueva)
			    $descporcent = 30;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 30/11/2020';
			}
		}else if($hoy <= $desc5 && $hoy > $desc4){
			if($reinscripcion == true){ /// Indica que es re-Inscripcion
				$descporcent = 0;
				$descuento = 0; //// establece el monto de descuento
				$motdescuento = '';
			}else{ /// No es Re-Inscripcion (Inscripcion Nueva)
		    	$descporcent = 15;
				$descuento = ($monto * $descporcent)/100; //// establece el monto de descuento
				$motdescuento = 'DESCUENTO POR CANCELAR ANTES DEL 31/12/2020';
			}
		}
		$monto = ($monto - $descuento); // ejecuta el descuento (resta)
		//////// FECHA DE PAGO
		$fecha_pago = strtotime ( '+1 week' , strtotime ( date("Y-m-d") ) );
		$fecha_pago = date ( 'Y-m-d' , $fecha_pago );
		$fecha_pago = cambia_fecha($fecha_pago);
      //// DATOS DE LA BOLETA ///////////
		$division = $ClsIns->division;
		$grupo = $ClsIns->grupo;
        $periodo = $ClsIns->periodo;
		$codigo = $ClsBol->max_boleta_cobro($division, $grupo); // Cuenta del Colegio
        $codigo++;
		//--- repmplazado por el $documento (procedimiento manual)
		$referencia = $codigo;
		//--
		$sql = $ClsBol->insert_boleta_cobro($codigo, $periodo, $division, $grupo, $cui,'', $referencia, 'I', $monto, $motivo, $descuento, $motdescuento, $fecha_pago);
      
		//////// Valida el status actual del proceso
      $status = 10; //da un numeor elevado como seguro 
      $result = $ClsIns->get_status($cui);
      if(is_array($result)){
         foreach($result as $row){
            $status = $row["stat_situacion"];
            $contrato = $row["stat_contrato"];
         }
      }
      if($status <= 3){ //valida si el proceso se enuentra en el paso 1 o 2.  Si el proceso esta mas avanzado no modifica el status....
         $sql.= $ClsIns->cambia_sit_status($contrato,3); /// envia el proceso al paso # 3;
      }
		//--
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Boleta Solicitada con exito! Por favor, imprima el formulario de verificaci\u00F3n de informaci\u00F3n y la boleta de Inscripci\u00F3n, esta \u00FAltima debe ser pagada en el banco...", "success").then((value)=>{ openBoleta('.$codigo.','.$division.','.$grupo.'); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	
   return $respuesta;
}

function Solicitar_Aprobacion($cui){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   
	if($cui != ""){
		//////// Valida el status actual del proceso
		$status = 10; //da un numeor elevado como seguro 
		$result = $ClsIns->get_status($cui);
		if(is_array($result)){
			foreach($result as $row){
				$status = $row["stat_situacion"];
				$contrato = $row["stat_contrato"];
			}
		}
		if($status <= 4){ //valida si el proceso se enuentra en el paso 1 o 2.  Si el proceso esta mas avanzado no modifica el status....
			$sql.= $ClsIns->cambia_sit_status($contrato,4); /// envia el proceso al paso # 4;
		}
		
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->redirect("FRMpaso3.php",0);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	
   return $respuesta;
}


function Buscar_Alumno($cui,$fila){
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
   //$respuesta->alert("$cui,$fila");
	if($cui != ""){
		$result = $ClsAlu->get_alumno($cui,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$respuesta->assign("cuiold$fila","value",$cui);
				$respuesta->assign("cuinew$fila","value",$cui);
				$respuesta->assign("existe$fila","value","1");
				$respuesta->assign("status$fila","value","");
				$respuesta->assign("contrato$fila","value","");
				$tipocui = $row["alu_tipo_cui"];
				$respuesta->assign("tipocui$fila","value",$tipocui);
				$nombre = utf8_decode($row["alu_nombre"]);
				$respuesta->assign("nombre$fila","value",$nombre);
				$apellido = utf8_decode($row["alu_apellido"]);
				$respuesta->assign("apellido$fila","value",$apellido);
				//--------
				$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
				$respuesta->assign("fecnac$fila","value",$fecnac);
				$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
				$respuesta->assign("edad$fila","value",$edad);
				$genero = trim($row["alu_genero"]);
				$respuesta->assign("genero$fila","value",$genero);
				$cli = trim($row["alu_cliente_factura"]);
				$respuesta->assign("cli$fila","value",$cli);
				//--
				$sangre = trim($row["alu_tipo_sangre"]);
				$respuesta->assign("sangre$fila","value",$sangre);
				$alergico = utf8_decode($row["alu_alergico_a"]);
				$respuesta->assign("alergico$fila","value",$alergico);
				$emergencia = utf8_decode($row["alu_emergencia"]);
				$respuesta->assign("emergencia$fila","value",$emergencia);
				$emertel = trim($row["alu_emergencia_telefono"]);
				$respuesta->assign("emertel$fila","value",$emertel);
			}
			///--
			$respuesta->script("document.getElementById('nombre$fila').focus();");
		}
	}
	
	return $respuesta;
}


function Valida_CUI($cui,$padre){
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
   $ClsIns = new ClsInscripcion();
   //$respuesta->alert("$cui,$padre");
	if($cui != ""){
		$result = $ClsAlu->get_alumno($cui,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$tipocui = $row["alu_tipo_cui"];
				$nombres = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			}
         $mensaje = "Su hijo es $nombres, con $tipocui No. $cui \u00BFDesea continuar con la actualizaci\u00F3n?";
         $respuesta->script("agregarExistente('$cui','$padre','$mensaje');");
		}else{
         $mensaje = "Este n\u00FAmero de CUI no est\u00E1 registrado en el sistema, \u00BFDesea registrarlo como un alumno nuevo?";
         $respuesta->script("agregarNuevo('$cui','$padre','$mensaje');");
      }
	}else{
      $respuesta->script('swal("Error", "El n\u00FAmero de CUI es un campo obligatorio....", "error").then((value)=>{ cerrar(); });');
   }
	
	return $respuesta;
}


function Agregar_Existente($cui,$padre){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   //$respuesta->alert("$cui,$padre");
	if($cui != ""){
      $contrato = $ClsIns->max_status();
      $contrato++;
      $fecha = date("d/m/Y");
		$sql = $ClsIns->insert_alumno_existente($cui);
      $sql.= $ClsIns->asignacion_alumno_padre($padre,$cui);
      $sql.= $ClsIns->insert_status($contrato,$cui,$padre,'','','',$fecha,'','','','','','','',100,101,'','','');
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('window.location.reload();');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   return $respuesta;
}


function Agregar_Nuevo($cui,$padre){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   
	if($cui != ""){
      $contrato = $ClsIns->max_status();
      $contrato++;
      $fecha = date("d/m/Y");
		$sql = $ClsIns->insert_alumno($cui,$cui,"CUI","","","",$fecha,"","","","M","","","","","");
      $sql.= $ClsIns->asignacion_alumno_padre($padre,$cui);
      $sql.= $ClsIns->insert_status($contrato,$cui,$padre,'','','',$fecha,'','','','','','','',100,101,'','','');
		$rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('window.location.reload();');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	
   return $respuesta;
}


function Quitar_Alumno($cui){
   $respuesta = new xajaxResponse();
   $ClsIns = new ClsInscripcion();
   
	if($cui != ""){
		$sql = $ClsIns->desasignacion_alumno_general($cui);
      $sql.= $ClsIns->delete_grado_alumno($cui);
		$sql.= $ClsIns->delete_status($cui);
		$sql.= $ClsIns->delete_alumno($cui);
		
      $rs = $ClsIns->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('window.location.reload();');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	
   return $respuesta;
}


function Padre_Contrato($dpi,$fila){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();
   //$respuesta->alert("$dpi,$fila");
	if($dpi != ""){
		$result = $ClsPad->get_padre($dpi);
		if(is_array($result)){
			foreach($result as $row){
            $dpi = $row["pad_cui"];
            $respuesta->assign("contradpi$fila","value",$dpi);
            $tipodpi = trim($row["pad_tipo_dpi"]);
            $respuesta->assign("contratipodpi$fila","value",$tipodpi);
            $nombre = utf8_decode($row["pad_nombre"]);
            $respuesta->assign("contranombre$fila","value",$nombre);
            $apellido = utf8_decode($row["pad_apellido"]);
            $respuesta->assign("contraapellido$fila","value",$apellido);
            $padrefecnac = trim($row["pad_fec_nac"]);
            $padrefecnac = ($padrefecnac != "0000-00-00")?$padrefecnac:date("Y-m-d");
            $padrefecnac = cambia_fecha($padrefecnac);
            $respuesta->assign("contrafecnac$fila","value",$padrefecnac);
            //--
               $padrefecnacdia = substr($padrefecnac, 0, 2);
               $respuesta->assign("contrafecnacdia$fila","value",$padrefecnacdia);
               $padrefecnacmes = substr($padrefecnac, 3, 2);
               $respuesta->assign("contrafecnacmes$fila","value",$padrefecnacmes);
               $padrefecnacanio = substr($padrefecnac, 6, 4);
               $respuesta->assign("contrafecnacanio$fila","value",$padrefecnacanio);
            //--
            $parentesco = trim($row["pad_parentesco"]);
            $respuesta->assign("contraparentesco$fila","value",$parentesco);
            $ecivil = trim($row["pad_estado_civil"]);
            $respuesta->assign("contraecivil$fila","value",$ecivil);
            $nacionalidad = strtolower($row["pad_nacionalidad"]);
            $respuesta->assign("contranacionalidad$fila","value",$nacionalidad);
            $mail = strtolower($row["pad_mail"]);
            $respuesta->assign("contramail$fila","value",$mail);
            //--
            $direccion = utf8_decode($row["pad_direccion"]);
            $respuesta->assign("contradireccion$fila","value",$direccion);
            $departamento = utf8_decode($row["pad_departamento"]);
            $respuesta->assign("contradep$fila","value",$departamento);
            $combo = municipio_html($departamento,"contramun$fila",""); // combo
            $respuesta->assign("contradivmun$fila","innerHTML",$combo); //setea combo
            $municipio = utf8_decode($row["pad_municipio"]);
            $respuesta->assign("contramun$fila","value",$municipio);
            //--
            $telcasa = $row["pad_telefono"];
            $respuesta->assign("contratelcasa$fila","value",$telcasa);
            $celular = $row["pad_celular"];
            $respuesta->assign("contracelular$fila","value",$celular);
            $trabajo = utf8_decode($row["pad_lugar_trabajo"]);
            $respuesta->assign("contratrabajo$fila","value",$trabajo);
            $teltrabajo = $row["pad_telefono_trabajo"];
            $respuesta->assign("contrateltrabajo$fila","value",$teltrabajo);
            $profesion = utf8_decode($row["pad_profesion"]);
            $respuesta->assign("contraprofesion$fila","value",$profesion);
         }
			///--
         $respuesta->script("cerrar();");
			$respuesta->script("document.getElementById('nombre$fila').focus();");
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
			$respuesta->script('swal("Excelente!", "Cambio de CUI realizado exitosamente!", "success").then((value)=>{ window.location.href="FRMpaso1B.php"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	
   return $respuesta;
}


//////////////////---- UTILITARIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad_Contrato");
//////////////////---- CLIENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");
//////////////////---- ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Actualizar_Padre");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Hijos");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Datos_Generales");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Seguro");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Datos_Contrato");
$xajax->register(XAJAX_FUNCTION, "Generar_Boleta_Inscripcion");
$xajax->register(XAJAX_FUNCTION, "Solicitar_Aprobacion");
//////////////////---- Busqueda y Validacion -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Valida_CUI");
$xajax->register(XAJAX_FUNCTION, "Agregar_Existente");
$xajax->register(XAJAX_FUNCTION, "Agregar_Nuevo");
$xajax->register(XAJAX_FUNCTION, "Quitar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Padre_Contrato");
$xajax->register(XAJAX_FUNCTION, "Modificar_CUI");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  