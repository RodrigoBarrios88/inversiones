<?php
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_articulos.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Unidad de Medida /////////
function UnidadMedida($clase){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$clase");
	$contenido = umedida_html($clase,'umed');
	$respuesta->assign("sumed","innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
function Grabar_Grupo_Articulo($nom){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
	if($nom != ""){
		$cod = $ClsArt->max_grupo();
		$cod++;
		$sql = $ClsArt->insert_grupo($cod,$nom,1);
		//$respuesta->alert("$sql");
		$rs = $ClsArt->exec_sql($sql);
		if($rs == 1){
			$contenido = tabla_grupo_articulos($cod,$nom,$sit);
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
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


function Buscar_Grupo_Articulo($cod){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

   //$respuesta->alert("$cod");
	$cont = $ClsArt->count_grupo($cod);
		if($cont>0){
			if($cont==1){
				$result = $ClsArt->get_grupo($cod);
				foreach($result as $row){
					$cod = $row["gru_codigo"];
					$respuesta->assign("cod","value",$cod);
					$nom = $row["gru_nombre"];
					$nom = utf8_decode($nom);
					$respuesta->assign("nom","value",$nom);
					$sit = $row["gru_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_grupo_articulos($cod,'','');
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   	}	
   return $respuesta;
}

function Modificar_Grupo_Articulo($cod,$nom){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

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
			$sql = $ClsArt->modifica_grupo($cod,$nom);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
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


function Situacion_Grupo_Articulo($grup,$sit){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

    //$respuesta->alert("$grup,$sit");
    if($grup != ""){
		if($sit == 0){
			$activo = $ClsArt->comprueba_sit_grupo($grup);
			if(!$activo){
				$sql = $ClsArt->cambia_sit_grupo($grup,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsArt->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Grupo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
			}else{
				$msj = '<h5>Este Grupo tiene Articulos en situación activa, desactivelos primero antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else if($sit == 1){
			$sql = $ClsArt->cambia_sit_grupo($grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Grupo Activado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
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


//////////////////---- Articulos -----/////////////////////////////////////////////
function Grabar_Articulo($gru,$barc,$nom,$desc,$marca,$umed,$chkb,$margen,$mon){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$marca = utf8_encode($marca);
		$barc = utf8_encode($barc);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
		$barc = utf8_decode($barc);
	//--------
	if($gru != "" && $nom != "" && $desc != "" && $marca != "" && $umed != "" && $margen != "" && $mon != ""){
		if($barc != ""){
			$valbarc = $ClsArt->count_articulo('','','','','','','',$barc,1);
			if($valbarc>0){
				$msj = '<h5>Este Codigo Interno de Producto ya Existe con un producto activo...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
				return $respuesta;
			}
		}
		$cod = $ClsArt->max_articulo($gru);
		$cod++;
		//Query
		if($chkb == 1){
			$X1 = Agrega_Ceros($cod);
			$X2 = Agrega_Ceros($gru);
			$barc = $X1."A".$X2;
		}
		$sql = $ClsArt->insert_articulo($cod,$gru,$barc,$nom,$desc,$marca,$margen,$mon,$umed,1);
		//$respuesta->alert("$sql");
		$rs = $ClsArt->exec_sql($sql);
		if($rs == 1){
			$contenido = tabla_articulos($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc);
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
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



function Buscar_Articulo($cod,$gru){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

   //$respuesta->alert("$cod,$gru");
	$cont = $ClsArt->count_articulo($cod,$gru);
		if($cont>0){
			if($cont==1){
				$result = $ClsArt->get_articulo($cod,$gru);
				foreach($result as $row){
					$cod = $row["art_codigo"];
					$respuesta->assign("cod","value",$cod);
					$gru = $row["gru_codigo"];
					$respuesta->assign("gru","value",$gru);
					$art = $row["art_codigo"];
					$respuesta->assign("gru","value",$gru);
					$nom = $row["art_nombre"];
					$nom = utf8_decode($nom);
					$respuesta->assign("artnom","value",$nom);
					$desc = $row["art_desc"];
					$desc = utf8_decode($desc);
					$respuesta->assign("desc","value",$desc);
					$marca = $row["art_marca"];
					$marca = utf8_decode($marca);
					$respuesta->assign("marca","value",$marca);
					$barc = $row["art_barcode"];
					$respuesta->assign("barc","value",$barc);
					$sit = $row["art_situacion"];
					$respuesta->assign("sit","value",$sit);
					$margen = $row["art_margen"];
					$respuesta->assign("margen","value",$margen);
					$precosto = number_format($row["art_precio_costo"],2); 
					$precosto = ($precosto != "")?$precosto:0;
					$respuesta->assign("precost","value",$precosto);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["art_precio"];
					$respuesta->assign("prev","value",$prev);
					// solo para FRM actualizacion de precios
					if($margen > 0){
						$precio = (($precosto*$margen)/100)+$precosto;
					}else{
						$precio = $precosto;
					}
					//---
					$precio = number_format($precio, 2);   
					$respuesta->assign("precio","value",$precio);
					//--
					$umed = $row["art_unidad_medida"];
					$cumed = $row["u_clase"];
					$respuesta->assign("umclase","value",$cumed);
				}
				$xart = suministro_html($gru,"art","");
				$respuesta->assign("sart","innerHTML",$xart);
				$respuesta->assign("art","value",$art);
				//$respuesta->alert("$gru,$art");
				//$respuesta->alert("$cumed");
				$xcumed = umedida_html($cumed,"umed");
				$respuesta->assign("sumed","innerHTML",$xcumed);
				$respuesta->assign("umed","value",$umed);
			}
			///abilita y desabilita botones
			$contenido = tabla_articulos($cod,$gru,'','','','','','','','');
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('chkb').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   }
		$respuesta->script("cerrar()");
   return $respuesta;
}


function Modificar_Articulo($cod,$grup,$barc,$nom,$desc,$marca,$umed,$margen){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$marca = utf8_encode($marca);
		$barc = utf8_encode($barc);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
		$barc = utf8_decode($barc);
	//--------
	//$respuesta->alert("$cod,$grup,$barc,$nom,$desc,$marca,$umed");
    if($cod != ""){
		if($grup != "" && $nom != "" && $desc != "" && $umed != "" && $marca != ""){
			if($barc != ""){
				$result2 = $ClsArt->get_articulo('','','','','','','',$barc,1);
				$valbarc = 0;
				if(is_array($result2)) {
					foreach ($result2 as $row2){
						$cod2 = $row2['art_codigo'];
						$grup2 = $row2['art_grupo'];
						$valbarc++;
					}
				}
				//$respuesta->alert("$cod,$cod2 | $grup,$grup2");
				if($valbarc>0){
					if($cod != $cod2 || $grup != $grup2){
						$msj = '<h5>Este Codigo Interno de Producto ya Existe con otro producto situación activa...</h5><br><br>';
						$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						$respuesta->assign("lblparrafo","innerHTML",$msj);
						$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
						return $respuesta;
					}
				}
			}
			$sql = $ClsArt->modifica_articulo($cod,$grup,$barc,$nom,$desc,$umed,$marca,$margen);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
				$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
				$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
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


function Buscar_Articulo_Precio($cod,$gru){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

   //$respuesta->alert("$cod");
	$cont = $ClsArt->count_articulo($cod,$gru);
		if($cont>0){
			if($cont==1){
				$result = $ClsArt->get_articulo($cod,$gru);
				foreach($result as $row){
					$cod = $row["art_codigo"];
					$respuesta->assign("cod","value",$cod);
					$gru = $row["gru_codigo"];
					$respuesta->assign("gru","value",$gru);
					$art = $row["art_codigo"];
					$respuesta->assign("gru","value",$gru);
					$nom = $row["art_nombre"];
					$nom = utf8_decode($nom);
					$respuesta->assign("artnom","value",$nom);
					$desc = $row["art_desc"];
					$desc = utf8_decode($desc);
					$respuesta->assign("desc","value",$desc);
					$marca = $row["art_marca"];
					$marca = utf8_decode($marca);
					$respuesta->assign("marca","value",$marca);
					$barc = $row["art_barcode"];
					$respuesta->assign("barc","value",$barc);
					$sit = $row["art_situacion"];
					$respuesta->assign("sit","value",$sit);
					$margen = $row["art_margen"];
					$respuesta->assign("margen","value",$margen);
					$precosto = $row["art_precio_costo"];
					$precosto = ($precosto != "")?$precosto:0;
					$respuesta->assign("precost","value",$precosto);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					$precio = $row["art_precio"];
					$respuesta->assign("precio","value",$precio);
					// solo para FRM actualizacion de precios
					if($margen > 0){
						$precio = (($precosto*$margen)/100)+$precosto;
					}else{
						$precio = $precosto;
					}
					//---
					$precio = numbre_format($precio, 2);   
					$respuesta->assign("precio","value",$precio);
					//--
					$umed = $row["art_unidad_medida"];
					$cumed = $row["u_clase"];
					$respuesta->assign("umclase","value",$cumed);
				}
				$xart = suministro_html($gru,"art","");
				$respuesta->assign("sart","innerHTML",$xart);
				$respuesta->assign("art","value",$art);
				//$respuesta->alert("$gru,$art");
				//$respuesta->alert("$cumed");
				$xcumed = umedida_html($cumed,"umed");
				$respuesta->assign("sumed","innerHTML",$xcumed);
				$respuesta->assign("umed","value",$umed);
			}
			///abilita y desabilita botones
			$contenido = tabla_articulos($cod,$gru,'','','','','','','','');
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('chkb').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   	}	
   return $respuesta;
}



function Modificar_Precio($cod,$grup,$prec,$margen,$mon){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

   //$respuesta->alert("$cod,$grup,$prec");
    if($cod != ""){
		if($grup != "" && $cod != "" && $prec != "" && $mon != ""){
			$sql = $ClsArt->cambia_precio_articulo($cod,$grup,$prec,$margen,$mon);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Precio Actualizado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			    $respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
				$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
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


function Situacion_Articulo($grup,$art,$sit){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

    if($grup != "" && $art != ""){
		if($sit == 0){
			$activo = $ClsArt->comprueba_sit_articulo($art,$grup);
			if(!$activo){
				$sql = $ClsArt->cambia_sit_articulo($art,$grup,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsArt->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Art&iacute;culo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
			}else{
				$msj = '<h5>Este Art&iacute;culo tiene Lotes con inventario mayor a 0, descargue de inventario primero estos articulos antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else if($sit == 1){
			$sql = $ClsArt->cambia_sit_articulo($art,$grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Art&iacute;culo Activado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
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


function Combo_Grupo_Articulo($gru,$id,$sid,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$clase");
	$contenido = suministro_html($gru,$id,$acc);
	$respuesta->assign($sid,"innerHTML",$contenido);
	
	
	return $respuesta;
}



function Grabar_Masa($grup,$suc,$arrnombre,$arrdesc,$arrmarca,$arrprov,$arrprec,$arrmoneda,$arrtcambio,$arrcant,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
	$ClsInv = new ClsInventarioSuministro();
	
	//$respuesta->alert("$filas");
	if($filas > 0){
		if($grup != "" && $suc != ""){
			$sql = "";
			$art = $ClsArt->max_articulo($grup);
			$art++;
			/////// ARTICULOS ///////////////////
			for($i = 1; $i <= $filas; $i++){
				$nombre = $arrnombre[$i];
				$desc = $arrdesc[$i];
				$marca = $arrmarca[$i];
				$prov = $arrprov[$i];
				$precio = $arrprec[$i];
				$moneda = $arrmoneda[$i];
				$tcambio = $arrtcambio[$i];
				$cantidad = $arrcant[$i];
				//--
				$X1 = Agrega_Ceros($art);
				$X2 = Agrega_Ceros($grup);
				$barc = $X1."A".$X2;
				$sql.= $ClsArt->insert_articulo($art,$grup,$barc,$nombre,$desc,$marca,$precio,$moneda,0,1);
				$sql.= $ClsArt->insert_lote(1,$grup,$art,$prov,$suc,$precio,0,0,$cantidad);
				$art++;
			}
			///////// INVENTARIO ////////////////
			$art = $ClsArt->max_articulo($grup);
			$art++;
			$invc = $ClsInv->max_inventario(1);
			$invc++;
			$fecha = date("d/m/Y");
			$sql.= $ClsInv->insert_inventario($invc,1,"CI","S/N",$suc,$fecha,1);
			for($i = 1; $i <= $filas; $i++){
				$nombre = $arrnombre[$i];
				$desc = $arrdesc[$i];
				$marca = $arrmarca[$i];
				$prov = $arrprov[$i];
				$precio = $arrprec[$i];
				$moneda = $arrmoneda[$i];
				$tcambio = $arrtcambio[$i];
				$cantidad = $arrcant[$i];
				//--
				$sql.= $ClsInv->insert_det_inventario($i,$invc,1,$grup,$art,1,$cantidad);
				$art++;
			}	
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<a type="button" class="btn btn-primary" href = "FRMarticulos.php" ><span class="fa fa-check"></span> Aceptar</a> ';
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

//////////////////---- Lote -----/////////////////////////////////////////////
function Buscar_Lote($cod,$art,$gru){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

    //$respuesta->alert("$cod,$art,$gru");
	$cont = $ClsArt->count_lote($cod,$gru,$art);
		if($cont>0){
			if($cont==1){
				$result = $ClsArt->get_lote($cod,$gru,$art);
				foreach($result as $row){
					$suc = $row["lot_sucursal"];
					$respuesta->assign("suc","value",$suc);
					$barcod = $row["art_barcode"];
					$respuesta->assign("barc","value",$barcod);
					$cod = $row["lot_codigo"];
					$respuesta->assign("cod","value",$cod);
					$gru = $row["gru_codigo"];
					$respuesta->assign("gru","value",$gru);
					$art = $row["art_codigo"];
					$margen = $row["art_margen"];
					$respuesta->assign("marg","value",$margen);
					//-- proveedor
					$proc = $row["prov_id"];
					$respuesta->assign("prov","value",$proc);
					$pnit = $row["prov_nit"];
					$respuesta->assign("nit","value",$pnit);
					$pnom = $row["prov_nombre"];
					$respuesta->assign("nom","value",$pnom);
					//--
					$prem = $row["lot_precio_manufactura"];
					$respuesta->assign("prem","value",$prem);
					$prec = $row["lot_precio_costo"];
					$respuesta->assign("prec","value",$prec);
					$prev = $row["lot_precio_venta"];
					$respuesta->assign("prev","value",$prev);
				  
				}
				$combo = suministro_html($gru,"art","Buscar();");
				$respuesta->assign("sart","innerHTML",$combo);
				$respuesta->assign("art","value",$art);
			}
			
			//abilita y desabilita botones
			$contenido = tabla_lotes($cod,$gru,$art,$barc,$suc,$prov,'M');
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   	}	
   return $respuesta;
}

function Modificar_Lote($cod,$grup,$art,$prov,$prec,$prev,$prem){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();

   //$respuesta->alert("$cod,$grup,$art,$prov,$prec,$prev,$prem,$umed");
    if($cod != ""){
		if($grup != "" && $art != "" && $prov != "" && $prem != "" && $prec != "" && $prev != ""){
			$sql = $ClsArt->modifica_lote($cod,$grup,$art,$prov,$prec,$prev,$prem);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Lote Modificado Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
				$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
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


function Seleccionar_Costo_Lote($lot,$art,$grup){
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventario();
	
    $cont = $ClsInv->count_costo("",$lot,$art,$grup);
		if($cont>0){
			//--
			$contenido = tabla_lotes($lot,$grup,$art,$barc,$suc,$prov,'B');
			$respuesta->assign("result","innerHTML",$contenido);
			//--
			$contenido = tabla_costos($cod,$lot,$art,$grup);
			$respuesta->assign("result2","innerHTML",$contenido);
			$respuesta->script("cerrar()");
	   	}else{
			$msj = '<h5>Este lote no tiene Costos enlazados...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}
   return $respuesta;
}


///////////////////////// PROVEEDORES //////////////////////////////////
function Show_Proveedor($nit){
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //$respuesta->alert("$nit");
	if($nit != ""){
		$cont = $ClsProv->count_proveedor('',$nit,'','',1);
		if($cont>0){
			$result = $ClsProv->get_proveedor('',$nit,'','',1);
			foreach($result as $row){
				$cod = $row["prov_id"];
				$respuesta->assign("prov","value",$cod);
				$nom = trim($row["prov_nombre"]);
				$respuesta->assign("nom","value",$nom);
				$nit = trim($row["prov_nit"]);
				$respuesta->assign("nit","value",$nit);
			}
			$respuesta->script("document.getElementById('art').focus();");
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>Este Proveedor no existe, desea agregarlo?</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "NewProveedor(\''.$nit.'\');" ><span class="fa fa-check"></span> Si</button> ';
			$msj.= '<button type="button" class="btn btn-danger" onclick = "cerrar()" ><span class="glyphicon glyphicon-times"></span> No</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("nit","value","");
			$respuesta->assign("nom","value","");
			$respuesta->assign("prov","value","");
		}
	}else{
		$respuesta->assign("nit","value","");
		$respuesta->assign("nom","value","");
		$respuesta->assign("prov","value","");
		$respuesta->script("cerrar()");
	}
	
	return $respuesta;
}

function Grabar_Proveedor($nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
		$contact = utf8_decode($contact);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    if($nom != "" && $direc != "" && $tel1 != "" && $contact != ""){
		$id = $ClsProv->max_proveedor();
		$id++; /// Maximo codigo de Empresa
		//$respuesta->alert("$id");
		$sql = $ClsProv->insert_proveedor($id,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc); /// Inserta Empresa
		//$respuesta->alert("$sql");
		$rs = $ClsProv->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();Ul_Proveedor_Carga();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("prov","value",$id);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("nom","value",$nom);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   
   return $respuesta;
}

function Buscar_Proveedor($nom,$contact){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //pasa a mayusculas
		$nom = trim($nom);
		$contact = trim($contact);
   //--		
   //decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$contact = utf8_decode($contact);
	//--------
	//$respuesta->alert("$nit,$nom,$contact");
    if($nom != "" || $contact != ""){
		$cont = $ClsProv->count_proveedor('','',$nom,$contact);
		if($cont>0){
			$contenido = tabla_lista_proveedores($nom,$contact);
			$respuesta->assign("resultProv","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}




//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Grupo_Articulo");
//////////////////---- Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo_Precio");
$xajax->register(XAJAX_FUNCTION, "Modificar_Precio");
$xajax->register(XAJAX_FUNCTION, "Situacion_Articulo");
$xajax->register(XAJAX_FUNCTION, "Combo_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Grabar_Masa");
//////////////////---- Lote -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Lote");
$xajax->register(XAJAX_FUNCTION, "Modificar_Lote");
$xajax->register(XAJAX_FUNCTION, "Seleccionar_Costo_Lote");
/////////////////------ Unidad de Medida -----////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "UnidadMedida");
//////////////////---- Proveedores -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Grabar_Proveedor");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  