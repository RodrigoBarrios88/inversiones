<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_hijos.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Modificar_Hijos($arrcui,$arrtipocui,$arrcodigo,$arrnombre,$arrapellido,$arrgenero,$arrfecnac,$arrnacionalidad,$arrreligion,$arridioma,$arrmail,$arrsangre,
                         $arralergia,$arremergencia,$arremetel,$arrrecoge,$arrredesociales,$arrseguro,$arrnit,$arrclinombre,$arrclidireccion,$arrpoliza,$arrasegura,
                         $arrplan,$arrasegurado,$arrinstuc,$arrcomment,$hijos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
	$ClsSeg = new ClsSeguro();
	
   if($hijos > 0){
		for($i = 1; $i <= $hijos; $i ++){
			$cui = $arrcui[$i];
			$tipocui = $arrtipocui[$i];
			$codigo = $arrcodigo[$i];
			$nombre = $arrnombre[$i];
			$apellido = $arrapellido[$i];
			$genero = $arrgenero[$i];
			$fecnac = $arrfecnac[$i];
			$nacionalidad = $arrnacionalidad[$i];
			$religion = $arrreligion[$i];
			$idioma = $arridioma[$i];
			$mail = $arrmail[$i];
			$sangre = $arrsangre[$i];
			$alergico = $arralergia[$i];
			$emergencia = $arremergencia[$i];
			$emetel = $arremetel[$i];
			$recoge = $arrrecoge[$i];
         $redesociales = $arrredesociales[$i];
			$seguro = $arrseguro[$i];
			$nit = $arrnit[$i];
			$clinombre = $arrclinombre[$i];
			$clidireccion = $arrclidireccion[$i];
			$poliza = $arrpoliza[$i];
			$aseguradora = $arrasegura[$i];
			$plan = $arrplan[$i];
			$asegurado = $arrasegurado[$i];
			$instrucciones = $arrinstuc[$i];
			$comentarios = $arrcomment[$i];
         
			//--
         $nombre = trim($nombre);
         $apellido = trim($apellido);
         $alergico = trim($alergico);
         $poliza = trim($poliza);
         $aseguradora = trim($aseguradora);
         $plan = trim($plan);
         $asegurado = trim($asegurado);
         $instrucciones = trim($instrucciones);
         $comentarios = trim($comentarios);
         //--//
         $nacionalidad = trim($nacionalidad);
         $religion = trim($religion);
         $idioma = trim($idioma);
         $mail = trim($mail);
         //--//
         $nit = trim($nit);
         $clinombre = trim($clinombre);
         $clidireccion = trim($clidireccion);
         //--------
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
			//--------
			
			//$respuesta->alert("$cui,$codigo,$nombre,$apellido,$genero,$fecnac,$nacionalidad,$religion,$idioma,$genero,$mail,$sangre,$emergencia,$emetel,$seguro,$cliente,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios,$i");
			
			//--
			$sql.= $ClsAlu->modifica_alumno($cui,$tipocui,$codigo,$nombre,$apellido,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emetel,$mail,$recoge,$redesociales);  /// modificar;
         $sql.= $ClsAlu->modificar_cliente($cui,$nit,$clinombre,$clidireccion);
			$sql.= $ClsSeg->update_seguro($cui,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios);
		}
		//-
		if($sql != ""){
			$rs = $ClsAlu->exec_sql($sql);
			//$respuesta->alert($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente", "Datos modificados satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
         }else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}


function Buscar_Seguro($cui,$fila){
   $respuesta = new xajaxResponse();
   $ClsSeg = new ClsSeguro();
   //$respuesta->alert("$cui,$fila");
	if($cui != ""){
		$result = $ClsSeg->get_seguro($cui);
		if(is_array($result)){
			foreach($result as $row){
				$poliza = utf8_decode($row["seg_poliza"]);
				$respuesta->assign("poliza$fila","value","");
				$aseguradora = utf8_decode($row["seg_aseguradora"]);
				$plan = utf8_decode($row["seg_plan"]);
				$asegurado = utf8_decode($row["seg_asegurado_principal"]);
				$instrucciones = utf8_decode($row["seg_instrucciones"]);
				$comentarios = utf8_decode($row["seg_comentarios"]);
				//--
				$respuesta->assign("poliza$fila","value",$poliza);
				$respuesta->assign("aseguradora$fila","value",$aseguradora);
				$respuesta->assign("plan$fila","value",$plan);
				$respuesta->assign("asegurado$fila","value",$asegurado);
				$respuesta->assign("instrucciones$fila","value",$instrucciones);
				$respuesta->assign("comentarios$fila","value",$comentarios);
			}
			$respuesta->Script("cerrar()");
		}else{
			$respuesta->assign("poliza$fila","value","");
			$respuesta->assign("aseguradora$fila","value","");
			$respuesta->assign("plan$fila","value","");
			$respuesta->assign("asegurado$fila","value","");
			$respuesta->assign("instrucciones$fila","value","");
			$respuesta->assign("comentarios$fila","value","");
			$respuesta->Script("cerrar()");
		}
	}else{
		$respuesta->assign("poliza$fila","value","");
		$respuesta->assign("aseguradora$fila","value","");
		$respuesta->assign("plan$fila","value","");
		$respuesta->assign("asegurado$fila","value","");
		$respuesta->assign("instrucciones$fila","value","");
		$respuesta->assign("comentarios$fila","value","");
		$respuesta->Script("cerrar()");
	}
	
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


function Grabar_Cliente($nit,$nom,$direc,$tel1,$tel2,$mail,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	 //$respuesta->alert("$nit,$nom,$direc,$tel1,$tel2,$mail,$fila");
    if($nit != "" && $nom != "" && $direc != ""){
		$id = $ClsCli->max_cliente();
		$id++; /// Maximo codigo de Cliente
		//$respuesta->alert("$id");
		$sql = $ClsCli->insert_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail); /// Inserta Cliente
		$rs = $ClsCli->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->assign("cli$fila","value",$id);
			$respuesta->assign("nit$fila","value",$nit);
			$respuesta->assign("cliente$fila","value",$nom);
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   
   return $respuesta;
}


function Modificar_Cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail,$fila){
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
				$respuesta->assign("cli$fila","value",$cod);
            $respuesta->assign("nit$fila","value",$nit);
            $respuesta->assign("cliente$fila","value",$nom);
            $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n, refresque la pagina e intente de nuevo...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}




//////////////////---- HIJOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Modificar_Hijos");
$xajax->register(XAJAX_FUNCTION, "Buscar_Seguro");
//////////////////---- CLIENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  