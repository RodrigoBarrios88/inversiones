<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_pv.php");


//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- CAJA -----/////////////////////////////////////////////

function Grabar_PV($desc,$suc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	
	if($desc != "" && $suc != ""){
		$cod = $ClsPV->max_punto_venta($suc);
		$cod++; 
		$sql = $ClsPV->insert_punto_venta($cod,$suc,$desc);
		$respuesta->alert("$sql");
		$rs = $ClsPV->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}


function Buscar_PV($cod,$suc){
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();
   //$respuesta->alert("$cod,$suc");
	$cont = $ClsPV->count_punto_venta($cod,$suc,$nom,$sit);
		if($cont>0){
			if($cont==1){
				$result = $ClsPV->get_punto_venta($cod,$suc,$nom,$sit);
				foreach($result as $row){
					$cod = $row["pv_codigo"];
					$respuesta->assign("cod","value",$cod);
					$nom = utf8_decode($row["pv_nombre"]);
					$respuesta->assign("desc","value",$nom);
					$suc = $row["suc_id"];
					$respuesta->assign("suc","value",$suc);
					$sit = $row["pv_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}
			//abilita y desabilita botones
			$contenido = tabla_punto_venta($cod,$suc,$nom,$sit,$acc);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
	   	}	
   return $respuesta;
}


function Modificar_PV($cod,$nom,$suc){
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$cod,$nom,$suc");
    if($cod != ""){
		if($nom != "" && $suc != ""){
			$sql = $ClsPV->modifica_punto_venta($cod,$suc,$nom);
			//$respuesta->alert("$sql");
			$rs = $ClsPV->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("cerrar()");
	}
   		
   return $respuesta;
}


function Situacion_PV($cod,$suc,$sit){
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();

    //$respuesta->alert("$cod,$suc,$sit");
    if($cod != "" && $suc != ""){
		if($sit == 0){
			$sql = $ClsPV->cambia_sit_punto_venta($cod,$suc,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPV->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Punto de Venta Desactivado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}else if($sit == 1){
			$sql = $ClsPV->cambia_sit_punto_venta($cod,$suc,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPV->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Punto de Venta Activado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}
	}

	return $respuesta;
}


function Buscar_Saldo_PV($pv,$suc){
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();
	//$respuesta->alert("$cod,$desc,$nom,$suc,$sit");
    if($pv != "" || $suc != ""){
		$cont = $ClsPV->count_punto_venta($pv,$suc,$nom,$sit);
		if($cont>0){
			$contenido = tabla_pv_saldos($pv,$suc);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}


function SucPuntVnt($suc,$id,$sid){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = punto_venta_html($suc,$id,"");
	//$respuesta->alert("$contenido");
	$respuesta->assign("$sid","innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- Movimientos de P. Venta -----/////////////////////////////////////////////
function Grabar_Movimiento_PV($suc,$pv,$mov,$monto,$mon,$tcamb,$doc,$tipo,$mot,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();
    //pasa a mayusculas
		$mot = trim($mot);
		$doc = trim($doc);
	//--------
	//decodificaciones de tildes y Ñ's
		$mot = utf8_decode($mot);
		$doc = utf8_decode($doc);
	//--------
	//$respuesta->alert("$suc,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($suc != "" && $pv != "" && $mov != "" && $monto != "" && $mon != "" && $tcamb != "" && $doc != "" && $tipo != ""){
		$cod = $ClsPV->max_mov_pv($pv,$suc);
		$cod++;
		//Query
		$sql.= $ClsPV->insert_mov_pv($cod,$pv,$suc,$mov,$monto,$mon,$tcamb,$tipo,$mot,$doc,$fecha);
		//$respuesta->alert("$sql");
		$rs = $ClsPV->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Transacción Registrada Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}


function Buscar_pv_Conciliacion($pv,$suc,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsPV = new ClsPuntoVenta();
	//$respuesta->alert("$ban,$num,$tipo,$mon");
    if($pv != "" || $suc != ""){
		$cont = $ClsPV->count_punto_venta($pv,$suc);
		if($cont>0){
			$contenido = tabla_pv_movimiento($pv,$suc,$fini,$ffin);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}

//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_PV");
$xajax->register(XAJAX_FUNCTION, "Buscar_PV");
$xajax->register(XAJAX_FUNCTION, "Modificar_PV");
$xajax->register(XAJAX_FUNCTION, "Situacion_PV");
$xajax->register(XAJAX_FUNCTION, "Buscar_Saldo_PV");
$xajax->register(XAJAX_FUNCTION, "SucPuntVnt");
//////////////////---- Movimiento de Cuentas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Movimiento_PV");
$xajax->register(XAJAX_FUNCTION, "Buscar_PV_Movimiento");
$xajax->register(XAJAX_FUNCTION, "Buscar_PV_Conciliacion");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  