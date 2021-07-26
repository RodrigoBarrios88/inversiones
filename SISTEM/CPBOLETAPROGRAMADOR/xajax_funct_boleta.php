<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_boleta.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Combo_Division_Grupo($grupo,$division,$scue,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$grupo,$division,$scue,$acc");
	$contenido = "<label>Divisi&oacute;n:</label>".division_html($grupo,$division,$acc);
	$respuesta->assign($scue,"innerHTML",$contenido);
	
	return $respuesta;
}


function Nivel_Grado($pensum,$nivel,$idgra,$idsgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$area,$grado");
	$contenido = grado_html($pensum,$nivel,$idgra,"");
	$respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}


function Quita_Fila_Config($arrmonto,$arrmotivo,$arrperiodo,$arrmes,$arrdia,$cant){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$arrmonto,$arrmotivo,$arrmes,$arrdia,$cant)");
	$contenido = tabla_new_configuracion($arrmonto,$arrmotivo,$arrperiodo,$arrmes,$arrdia,$cant);
	$respuesta->assign("result","innerHTML",$contenido);
	$respuesta->assign("cant","value",$cant);
	for($i = 1; $i <= $cant; $i ++){
		$mes = $arrmes[$i];
		$respuesta->assign("mes$i","value",$mes);
	}	
	$respuesta->script("cerrar();");
	
	return $respuesta;
}



function Grabar_Configuracion($grupo,$division,$tipo,$pensum,$nivel,$grado,$arrmonto,$arrmotivo,$arrperiodo,$arrmes,$arrdia,$arranio,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
    //pasa a mayusculas
		$mot = trim($mot);
	//--------
	//decodificaciones de tildes y Ñ's
		$mot = utf8_decode($mot);
	//--------
	//valida $grado
		$grado = ($grado == "")?0:$grado;
	//--------
	//$respuesta->alert("$grupo,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($grupo != "" && $division != "" && $tipo != "" && $cant != ""){
		$codigo = $ClsBol->max_configuracion_boleta_cobro();
		$codigo++;
		//Query
		$sql = "";
		for($i = 1; $i <= $cant; $i ++){
			$monto = $arrmonto[$i];
			$motivo = $arrmotivo[$i];
			$periodo = $arrperiodo[$i];
			$mes = $arrmes[$i];
			$dia = $arrdia[$i];
			$anio = $arranio[$i];
			$sql.= $ClsBol->insert_configuracion_boleta_cobro($codigo,$periodo,$division,$grupo,$tipo,$pensum,$nivel,$grado,$monto,$motivo,$mes,$dia,$anio);
			$codigo++;
		}	
		
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMnewconfiguracion.php"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



function Buscar_Configuracion($codigo){
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   $ClsPer = new ClsPeriodoFiscal();
	//$respuesta->alert("$codigo");
   if($codigo != ""){
		$result = $ClsBol->get_configuracion_boleta_cobro($codigo,$division,$grupo,$tipo,$periodo);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["cbol_codigo"];
				$division = $row["cbol_division"];
				$grupo = $row["cbol_grupo"];
				$tipo = $row["cbol_tipo"];
				$pensum = $row["cbol_pensum"];
				$nivel = $row["cbol_nivel"];
				$grado = $row["cbol_grado"];
				$motivo = utf8_decode($row["cbol_motivo"]);
				$monto = $row["cbol_monto"];
				$periodo = $row["cbol_periodo_fiscal"];
				$mes = $row["cbol_mes"];
				$dia = $row["cbol_dia"];
				//--
				$respuesta->assign("codigo","value",$codigo);
				$respuesta->assign("grupo","value",$grupo);
				$respuesta->assign("tipo","value",$tipo);
				$respuesta->assign("pensum","value",$pensum);
				$respuesta->assign("nivel","value",$nivel);
				$respuesta->assign("monto","value",$monto);
				$respuesta->assign("motivo","value",$motivo);
				$respuesta->assign("periodo","value",$periodo);
				$respuesta->assign("mes","value",$mes);
				$respuesta->assign("dia","value",$dia);
			}
         //perido fiscal
         $result = $ClsPer->get_periodo($periodo);
         if(is_array($result)){
            foreach($result as $row){
               $periodo_descripcion = utf8_decode($row["per_descripcion_completa"]);
            }
         }else{
            $periodo_descripcion = "- No habilitado -";
         }
         $respuesta->assign("periodoDesc","value",$periodo_descripcion);
         //--
			$contenido = division_html($grupo,"division","");
			$respuesta->assign("sdiv","innerHTML",$contenido);
			$respuesta->assign("division","value",$division);
			$contenido = grado_html($pensum,$nivel,"grado","");
			$respuesta->assign("divgra","innerHTML",$contenido);
			$respuesta->assign("grado","value",$grado);
			$respuesta->script("cerrar();");
		}	
	}
   		
   return $respuesta;
}



function Modificar_Configuracion($codigo,$grupo,$division,$tipo,$pensum,$nivel,$grado,$monto,$motivo,$periodo,$mes,$dia){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
    //pasa a mayusculas
		$mot = trim($mot);
	//--------
	//decodificaciones de tildes y Ñ's
		$mot = utf8_decode($mot);
	//--------
	//valida $grado
		$grado = ($grado == "")?0:$grado;
	//--------
	//$respuesta->alert("$grupo | $division | $tipo | $codigo ");
	if($grupo != "" && $division != "" && $tipo != "" && $codigo != ""){
		$sql.= $ClsBol->update_configuracion_boleta_cobro($codigo,$division,$grupo,$tipo,$pensum,$nivel,$grado,$monto,$motivo,$periodo,$mes,$dia);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente", "Configuraci\u00F3n Modificada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



function Eliminar_Configuracion($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   //$respuesta->alert("$grupo,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($codigo != ""){
		$sql.= $ClsBol->delete_configuracion_boleta_cobro($codigo);
		
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "Configuraci\u00F3n Eliminada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



//////////////////---- Movimientos de Cuenta -----/////////////////////////////////////////////

function Programar_Boletas_Cobro($arrdivision,$arrgrupo,$arralumno,$arrcodalumno,$arrmonto,$arrdesc,$arrmotdesc,$arrmotivo,$arrfecha,$periodo,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	if($filas > 0){
		$codigo = $ClsBol->max_boleta_cobro();
		$codigo++;
		//Query
		$sql = "";
      //$respuesta->alert("$codigo");
		for($i = 1; $i <= $filas; $i ++){
			$division = $arrdivision[$i];
			$grupo = $arrgrupo[$i];
			$alumno = $arralumno[$i];
			$codalumno = $arrcodalumno[$i];
			$monto = $arrmonto[$i];
			$desc = $arrdesc[$i];
			$motdesc = $arrmotdesc[$i];
			$motivo = utf8_decode($arrmotivo[$i]);
			$fecha = $arrfecha[$i];
			$sql.= $ClsBol->insert_boleta_cobro($codigo,$periodo,$division,$grupo,$alumno,$codalumno,$codigo,"C",$monto,$motivo,$desc,$motdesc,$fecha);
			$codigo++;
		}	
		
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($alumno, $usu);
      	$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openBoletas(\''.$hashkey.'\',\''.$grupo.'\',\''.$division.'\',\''.$periodo.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}

//////////////////---- Configuracion de Pagos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Division_Grupo");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Quita_Fila_Config");
$xajax->register(XAJAX_FUNCTION, "Grabar_Configuracion");
$xajax->register(XAJAX_FUNCTION, "Buscar_Configuracion");
$xajax->register(XAJAX_FUNCTION, "Modificar_Configuracion");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Configuracion");
//////////////////---- Programacion de Blotas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Programar_Boletas_Cobro");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  