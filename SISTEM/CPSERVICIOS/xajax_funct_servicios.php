<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_servicios.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- Grupo de Servicios -----/////////////////////////////////////////////

function Grabar_Grupo_Servicio($nom){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------

	if($nom != ""){
		$cod = $ClsSer->max_grupo();
		$cod++;
		$sql = $ClsSer->insert_grupo($cod,$nom,1);
		//$respuesta->alert("$sql");
		$rs = $ClsSer->exec_sql($sql);

		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}	

   return $respuesta;

}


function Buscar_Grupo_Servicio($cod){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
   //$respuesta->alert("$cod");
	$cont = $ClsSer->count_grupo($cod);
		if($cont>0){
			if($cont==1){
				$result = $ClsSer->get_grupo($cod);
				foreach($result as $row){
					$cod = $row["gru_codigo"];
					$respuesta->assign("cod","value",$cod);
					$nom = utf8_decode($row["gru_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$sit = $row["gru_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_grupo_servicios($cod,$nom,$sit);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   	}	

   return $respuesta;

}


function Modificar_Grupo_Servicio($cod,$nom){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();

   //pasa a mayusculas
		$nom = trim($nom);
	//--------

	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
	//$respuesta->alert("$cod,$gru,$nom,$desc,$marca");
    if($cod != ""){
		if($nom != ""){
			$sql = $ClsSer->modifica_grupo($cod,$nom);
			//$respuesta->alert("$sql");
			$rs = $ClsSer->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar()");
	}
   		
   return $respuesta;
}


function Situacion_Grupo_Servicio($grup,$sit){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();

    //$respuesta->alert("$grup,$sit");
    if($grup != ""){
		if($sit == 0){
			$activo = $ClsSer->comprueba_sit_grupo($grup);
			if(!$activo){
				$sql = $ClsSer->cambia_sit_grupo($grup,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsSer->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Grupo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
			}else{
				$msj = '<h5>Este Grupo tiene Servicios en situación activa, desactivelos primero antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else if($sit == 1){
			$sql = $ClsSer->cambia_sit_grupo($grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsSer->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Grupo Activado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}
	}

	return $respuesta;
}

//////////////////---- Servicios -----/////////////////////////////////////////////

function Grabar_Servicio($grup,$barc,$nom,$desc,$chkb,$prec,$prev,$mon){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$barc = trim($barc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$barc = utf8_encode($barc);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$barc = utf8_decode($barc);
	//--------
	if($grup != "" && $nom != "" && $desc != "" && $mon != ""){
	    //$respuesta->alert("$grup,$barc,$nom,$desc,$chkb,$prec,$prev,$mon");
		if($barc != ""){
			$valbarc = $ClsSer->count_servicio('','','','',$barc,1);
			if($valbarc>0){
				$msj = '<h5>Este Codigo Interno de Servicio ya Existe con un Servicio activo...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
				return $respuesta;
			}
		}
		$cod = $ClsSer->max_servicio($grup);  
		$cod++;
		//Query
		if($chkb == 1){
			$art = $cod;
			$X1 = Agrega_Ceros($art);
			$X2 = Agrega_Ceros($grup);
			$barc = "S".$X1."S".$X2;
		}
		$sql = $ClsSer->insert_servicio($cod,$grup,$barc,$nom,$desc,$prec,$prev,$mon,1);
		//$respuesta->alert("$sql");
		$rs = $ClsSer->exec_sql($sql);
		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}

function Buscar_Servicio($cod,$gru){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();

   //$respuesta->alert("$cod");
	$cont = $ClsSer->count_servicio($cod,$gru);
		if($cont>0){
			if($cont==1){
				$result = $ClsSer->get_servicio($cod,$gru);
				foreach($result as $row){
					$cod = $row["ser_codigo"];
					$respuesta->assign("cod","value",$cod);
					$gru = $row["gru_codigo"];
					$respuesta->assign("gru","value",$gru);
					$nom = utf8_decode($row["ser_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$desc = utf8_decode($row["ser_desc"]);
					$respuesta->assign("desc","value",$desc);
					$barc = $row["ser_barcode"];
					$respuesta->assign("barc","value",$barc);
					$sit = $row["ser_situacion"];
					$respuesta->assign("sit","value",$sit);
					$prec = $row["ser_precio_costo"];
					$respuesta->assign("prec","value",$prec);
					$mon = $row["ser_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["ser_precio_venta"];
					$respuesta->assign("prev","value",$prev);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_servicios($cod,$gru,$nom,$desc,$marca,$cumed,$umed,$barc,$sit);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('chkb').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   	}	
   return $respuesta;
}

function Modificar_Servicio($cod,$grup,$barc,$nom,$desc,$prec,$prev,$mon){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();

   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$barc = trim($barc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$barc = utf8_encode($barc);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$barc = utf8_decode($barc);
	//--------
	//$respuesta->alert("$cod,$grup,$barc,$nom,$desc,$marca,$umed");
    if($cod != ""){
		if($grup != "" && $nom != "" && $desc != ""){
			if($barc != ""){
				$result2 = $ClsSer->get_servicio('','','','',$barc,1);
				$valbarc = 0;
				if(is_array($result2)) {
					foreach ($result2 as $row2){
						$cod2 = $row2['ser_codigo'];
						$grup2 = $row2['ser_grupo'];
						$valbarc++;
					}
				}
				//$respuesta->alert("$cod,$cod2 | $grup,$grup2");
				if($valbarc>0){
					if($cod != $cod2 || $grup != $grup2){
						$msj = '<h5>Este Codigo Interno de Servicio ya Existe con otro producto situación activa...</h5><br><br>';
						$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						$respuesta->assign("lblparrafo","innerHTML",$msj);
						$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
						return $respuesta;
					}
				}
			}
			$sql = $ClsSer->modifica_servicio($cod,$grup,$barc,$nom,$desc,$prec,$prev,$mon);
			//$respuesta->alert("$sql");
			$rs = $ClsSer->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
				$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
				$respuesta->script("document.getElementById('chkb').className = 'btn btn-primary';");
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar()");
	}
   		
   return $respuesta;
}

function Situacion_Servicio($grup,$art,$sit){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();

    if($grup != "" && $art != ""){
		if($sit == 0){
				$sql = $ClsSer->cambia_sit_servicio($art,$grup,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsSer->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Servicio Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
		}else if($sit == 1){
			$sql = $ClsSer->cambia_sit_servicio($art,$grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsSer->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Servicio Activado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}
	}

	return $respuesta;
}


function Combo_Grupo_Servicio($gru,$id,$sid,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$clase");
	$contenido = servicio_html($gru,$id,$acc);
	$respuesta->assign($sid,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grabar_Masa($grup,$arrnombre,$arrdesc,$arrprec,$arrprev,$arrmoneda,$arrtcambio,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
	
	//$respuesta->alert("$filas");
	if($filas > 0){
		if($grup != ""){
			$sql = "";
			$cod = $ClsSer->max_servicio($grup);
			$cod++;
			/////// ARTICULOS ///////////////////
			for($i = 1; $i <= $filas; $i++){
				$nombre = $arrnombre[$i];
				$desc = $arrdesc[$i];
				$prec = $arrprec[$i];
				$prev = $arrprev[$i];
				$moneda = $arrmoneda[$i];
				$tcambio = $arrtcambio[$i];
				//--
				$art = $cod;
				$X1 = Agrega_Ceros($art);
				$X2 = Agrega_Ceros($grup);
				$barc = "S".$X1."S".$X2;
				$sql.= $ClsSer->insert_servicio($cod,$grup,$barc,$nombre,$desc,$prec,$prev,$moneda,1);
				$cod++;
			}
			//$respuesta->alert("$sql");
			$rs = $ClsSer->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Listado de Servicio Cargados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<a class="btn btn-primary" href = "FRMservicios.php" ><span class="fa fa-check"></span> Aceptar</a> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}
	}
   		
   return $respuesta;
}

//////////////////---- Grupo de Servicios -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grupo_Servicio");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grupo_Servicio");
$xajax->register(XAJAX_FUNCTION, "Modificar_Grupo_Servicio");
$xajax->register(XAJAX_FUNCTION, "Situacion_Grupo_Servicio");
//////////////////---- Servicios -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Servicio");
$xajax->register(XAJAX_FUNCTION, "Buscar_Servicio");
$xajax->register(XAJAX_FUNCTION, "Modificar_Servicio");
$xajax->register(XAJAX_FUNCTION, "Situacion_Servicio");
$xajax->register(XAJAX_FUNCTION, "Combo_Grupo_Servicio");
$xajax->register(XAJAX_FUNCTION, "Grabar_Masa");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  