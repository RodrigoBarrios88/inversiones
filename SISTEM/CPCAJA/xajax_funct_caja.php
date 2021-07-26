<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_caja.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- CAJA -----/////////////////////////////////////////////
function Grabar_Caja($desc,$mon,$suc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCaj = new ClsCaja();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	
	if($desc != "" && $mon != "" && $suc != ""){
		$cod = $ClsCaj->max_caja($suc);
		$cod++; 
		$sql = $ClsCaj->insert_caja($cod,$suc,$mon,$desc);
		//$respuesta->alert("$sql");
		$rs = $ClsCaj->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   		
   return $respuesta;
}


function Buscar_Caja($cod,$suc){
   $respuesta = new xajaxResponse();
   $ClsCaj = new ClsCaja();

   //$respuesta->alert("$cod");
	$cont = $ClsCaj->count_caja($cod,$suc,$mon,$sit);
		if($cont>0){
			if($cont==1){
				$result = $ClsCaj->get_caja($cod,$suc,$mon,$sit);
				foreach($result as $row){
					$cod = $row["caja_codigo"];
					$respuesta->assign("cod","value",$cod);
					$desc = utf8_decode($row["caja_descripcion"]);
					$respuesta->assign("desc","value",$desc);
					$mon = $row["mon_id"];
					$respuesta->assign("mon","value",$mon);
					$suc = $row["suc_id"];
					$respuesta->assign("suc","value",$suc);
					$sit = $row["caja_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}
			//abilita y desabilita botones
			$contenido = tabla_caja($cod,$suc,$mon,$sit,$acc);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
	   	}	
   return $respuesta;
}


function Modificar_Caja($cod,$desc,$mon,$suc){
   $respuesta = new xajaxResponse();
   $ClsCaj = new ClsCaja();

   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$cod,$desc,$mon,$suc");
    if($cod != ""){
		if($desc != "" && $mon != "" && $suc != ""){
			$sql = $ClsCaj->modifica_caja($cod,$suc,$mon,$desc);
			//$respuesta->alert("$sql");
			$rs = $ClsCaj->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("cerrar()");
	}
   		
   return $respuesta;
}


function Situacion_Caja($cod,$suc){
   $respuesta = new xajaxResponse();
   $ClsCaj = new ClsCaja();

    //$respuesta->alert("$cod,$suc,$sit");
    if($cod != "" && $suc != ""){
		$activo = $ClsCaj->comprueba_sit_caja($cod,$suc);
		if(!$activo){
			$sql = $ClsCaj->cambia_sit_caja($cod,$suc,0);
			//$respuesta->alert("$sql");
			$rs = $ClsCaj->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Caja Desactivada Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}else{
			$msj = '<h5>Esta Caja tiene saldo mayor a 0, nivele a 0 el saldo antes de esta acción...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}

	}

	return $respuesta;
}


function Combo_Cuenta_caja($ban,$cue,$scue,$onclick){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$onclick");
	$contenido = Cuenta_caja_html($ban,$cue,$onclick);
	$respuesta->assign($scue,"innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- Movimientos de Caja -----/////////////////////////////////////////////
function Grabar_Movimiento_Caja($suc,$caja,$mov,$monto,$doc,$tipo,$mot,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCaj = new ClsCaja();
    //pasa a mayusculas
		$mot = trim($mot);
	//--------
	//decodificaciones de tildes y Ñ's
		$mot = utf8_decode($mot);
	//--------
	//$respuesta->alert("$suc,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($suc != "" && $caja != "" && $mov != "" && $monto != "" && $doc != "" && $tipo != ""){
		$cod = $ClsCaj->max_mov_caja($caja,$suc);
		$cod++;
		//Query
		$signo = ($mov == "I")?"+":"-";
		$sql.= $ClsCaj->insert_mov_caja($cod,$caja,$suc,$mov,$monto,$tipo,$mot,$doc,$fecha);
		$sql.= $ClsCaj->saldo_caja($caja,$suc,$monto,$signo);
		//$respuesta->alert("$sql");
		$rs = $ClsCaj->exec_sql($sql);
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


//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Caja");
$xajax->register(XAJAX_FUNCTION, "Buscar_Caja");
$xajax->register(XAJAX_FUNCTION, "Modificar_Caja");
$xajax->register(XAJAX_FUNCTION, "Situacion_Caja");
$xajax->register(XAJAX_FUNCTION, "Buscar_Caja_Saldo");
//////////////////---- Movimiento de Cuentas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Movimiento_Caja");
$xajax->register(XAJAX_FUNCTION, "Buscar_Caja_Movimiento");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  