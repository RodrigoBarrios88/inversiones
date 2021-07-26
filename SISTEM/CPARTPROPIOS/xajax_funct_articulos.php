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
	$contenido = umedida_html($clase,"umed");
	$respuesta->assign("sumed","innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
function Grabar_Grupo_Articulo($nom,$dep){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
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
		$sql = $ClsArt->insert_grupo($cod,$nom,$dep,1);
		//$respuesta->alert("$sql");
		$rs = $ClsArt->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Grupo_Articulo($cod){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
   //$respuesta->alert("$cod");
	$result = $ClsArt->get_grupo($cod);
	if(is_array($result)){
      foreach($result as $row){
         $cod = $row["gru_codigo"];
         $respuesta->assign("cod","value",$cod);
         $nom = utf8_decode($row["gru_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $dep = $row["gru_depreciacion"];
         $respuesta->assign("porcent","value",$dep);
         $sit = $row["gru_situacion"];
         $respuesta->assign("sit","value",$sit);
      }
      //abilita y desabilita botones
      $contenido = tabla_grupo_articulos($cod,$nom,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar()");
	}	
   return $respuesta;
}

function Modificar_Grupo_Articulo($cod,$nom,$dep){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
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
			$sql = $ClsArt->modifica_grupo($cod,$nom,$dep);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}

function Situacion_Grupo_Articulo($grup,$sit){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
    //$respuesta->alert("$grup,$sit");
    if($grup != ""){
		if($sit == 0){
			$activo = $ClsArt->comprueba_sit_grupo($grup);
			if(!$activo){
				$sql = $ClsArt->cambia_sit_grupo($grup,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsArt->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Ok", "Grupo desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("Alto", "Este Grupo tiene articulos en situaci\u00F3n activa, desactivelos primero antes de esta acci\u00F3n...", "info").then((value)=>{ cerrar(); });');
			}
		}else if($sit == 1){
			$sql = $ClsArt->cambia_sit_grupo($grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Ok", "Grupo activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}
	return $respuesta;
}


//////////////////---- Articulos -----/////////////////////////////////////////////

function Grabar_Articulo($gru,$nom,$desc,$marca,$umed){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$marca = utf8_encode($marca);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
	//--------
	if($gru != "" && $nom != "" && $desc != "" && $marca != "" && $umed != ""){
		$cod = $ClsArt->max_articulo($gru);
		$cod++;
		$sql = $ClsArt->insert_articulo($cod,$gru,$nom,$desc,$marca,$umed);
		//$respuesta->alert("$sql");
		$rs = $ClsArt->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("document.getElementById('grab').disabled = false;");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Articulo($cod,$gru){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();

   //$respuesta->alert("$cod,$gru");
	$result = $ClsArt->get_articulo($cod,$gru);
	if(is_array($result)){
      foreach($result as $row){
         $cod = $row["art_codigo"];
         $respuesta->assign("cod","value",$cod);
         $gru = $row["gru_codigo"];
         $respuesta->assign("gru","value",$gru);
         $nom = utf8_decode($row["art_nombre"]);
         $respuesta->assign("artnom","value",$nom);
         $desc = utf8_decode($row["art_desc"]);
         $respuesta->assign("desc","value",$desc);
         $marca = utf8_decode($row["art_marca"]);
         $respuesta->assign("marca","value",$marca);
         $sit = $row["art_situacion"];
         $respuesta->assign("sit","value",$sit);
         //--
         $umed = $row["art_unidad_medida"];
         $cumed = $row["u_clase"];
         $respuesta->assign("umclase","value",$cumed);
      }
      $xcumed = umedida_html($clas,"umed");
      $respuesta->assign("sumed","innerHTML",$xcumed);
      $respuesta->assign("umed","value",$umed);
      //abilita y desabilita botones
      $contenido = tabla_articulos($cod,$grup,'','','','');
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar()");
	}	
   return $respuesta;
}


function Modificar_Articulo($cod,$gru,$nom,$desc,$marca,$umed){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$marca = utf8_encode($marca);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
	//--------
	//$respuesta->alert("$cod,$grup,$nom,$desc,$marca,$umed");
    if($cod != ""){
		if($gru != "" && $nom != "" && $desc != "" && $marca != "" && $umed != ""){
			$sql = $ClsArt->modifica_articulo($cod,$gru,$nom,$desc,$marca,$umed);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


function Situacion_Articulo($grup,$art,$sit){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();

    if($grup != "" && $art != ""){
		if($sit == 0){
			$activo = $ClsArt->comprueba_sit_articulo($art,$grup);
			//$respuesta->alert("$activo");
			if(!$activo){
				$sql = $ClsArt->cambia_sit_articulo($art,$grup,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsArt->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Ok", "Art\u00E1culo desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location="FRMarticulos.php" });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("Alto!", "Este Art\u00E1culo tiene Lotes con inventario mayor a 0, descargue de inventario primero estos articulos antes de esta acci\u00F3n...", "info").then((value)=>{ cerrar(); });');
			}
		}else if($sit == 1){
			$sql = $ClsArt->cambia_sit_articulo($art,$grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Ok", "Art\u00E1culo activado satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}
	return $respuesta;
}


function Combo_Grupo_Articulo($gru,$id){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$clase");
	$contenido = ArticuloPropio_html($gru,$id);
	$respuesta->assign("sart","innerHTML",$contenido);
	
	return $respuesta;
}


function Grabar_Masa($grup,$suc,$arrnombre,$arrdesc,$arrmarca,$arrserie,$arrpreini,$arrpreact,$arrmoneda,$arrtcambio,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
	
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
				$serie = $arrserie[$i];
				$precioini = $arrpreini[$i];
				$precioact = $arrpreact[$i];
				$moneda = $arrmoneda[$i];
				$tcambio = $arrtcambio[$i];
				//--
				$sql.= $ClsArt->insert_articulo($art,$grup,$nombre,$desc,$marca,0);
				$sql.= $ClsArt->insert_inventario(1,$grup,$art,$suc,$serie,$precioini,$precioact,$moneda);
				$art++;
			}
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}
		}
	}
   		
   return $respuesta;
}


//////////////////---- INVENTARIO -----/////////////////////////////////////////////

function Grid_Fila_Carga($filas,$num,$preini,$prefin,$mon){
   $respuesta = new xajaxResponse();
   $contenido = tabla_filas_carga($filas,$num,$preini,$prefin,$mon);
   $respuesta->assign("result","innerHTML",$contenido);  
   $respuesta->script("document.getElementById('cant').value = $filas;");
   $respuesta->script("cerrar()");
   return $respuesta;
}


function Grabar_Carga($filas,$gru,$art,$suc,$num,$preini,$prefin,$mon){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
   //convierte strig plano en array
		$num = explode("|", $num);
		$preini = explode("|", $preini);
		$prefin = explode("|", $prefin);
		$mon = explode("|", $mon);
		$sql = "";
	//------------
	if($filas > 0 && $suc != "" && $art != "" && $gru != ""){
		//-- Datos de Inventario ($tipo = 1 // Ingreso a inventario)
		$invc = $ClsArt->max_inventario($gru,$art);
		$invc++;
		// Inicia el Ciclo de filas	
		for($i = 1; $i <= $filas; $i++){
		     //Query
			$sql.= $ClsArt->insert_inventario($invc,$gru,$art,$suc,$num[$i],$preini[$i],$prefin[$i],$mon[$i]);
			$invc++;
		}
		$rs = $ClsArt->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
		   $respuesta->script('swal("Excelente!", "Carga Exitosa!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}


function Buscar_Inventario($cod,$gru,$art){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();

   $result = $ClsArt->get_inventario($cod,$gru,$art);
	//$respuesta->alert("$cont");
	if(is_array($result)){
      foreach($result as $row){
         $suc = $row["inv_sucursal"];
         $respuesta->assign("suc","value",$suc);
         $cod = $row["inv_codigo"];
         $respuesta->assign("cod","value",$cod);
         $gru = $row["gru_codigo"];
         $respuesta->assign("gru","value",$gru);
         $comboart = articulo_propio_html($gru,"art","Submit();");
         $respuesta->assign("sart","innerHTML",$comboart);
         $art = $row["art_codigo"];
         $respuesta->assign("art","value",$art);
         $nom = utf8_decode($row["art_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $desc = utf8_decode($row["art_desc"]);
         $respuesta->assign("desc","value",$desc);
         $marca = utf8_decode($row["art_marca"]);
         $respuesta->assign("marca","value",$marca);
         $preini = $row["inv_precio_inicial"];
         $respuesta->assign("preini","value",$preini);
         $prefin = $row["inv_precio_actual"];
         $respuesta->assign("prefin","value",$prefin);
         $num = $row["inv_numero"];
         $respuesta->assign("num","value",$num);
         $mon = $row["inv_moneda"];
         $respuesta->assign("mon","value",$mon);
      }
      //abilita y desabilita botones
      $contenido = tabla_articulos_inventario($art,$grup,$nom,$desc,$marca,$suc,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar()");
	}
   return $respuesta;
}


function Modificar_Inventario($cod,$grup,$art,$suc,$num,$prei,$prea,$mon){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();

   //pasa a mayusculas
		$num = trim($num);
		$desc = trim($desc);
		$marca = trim($marca);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$desc = utf8_encode($desc);
		$marca = utf8_encode($marca);
		//--
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
	//--------
	//$respuesta->alert("$cod,$grup,$art,$desc,$marca,$suc,$num,$prei,$mon");
    if($cod != ""){
		if($grup != "" && $art != "" && $suc != "" && $num != "" && $prei != "" && $prea != "" && $mon != ""){
			$sql = $ClsArt->modifica_inventario($cod,$grup,$art,$suc,$num,$prei,$prea,$mon);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}



function Situacion_Inventario($cod,$grup,$art,$sit){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
   //$respuesta->alert("$cod,$grup,$art,$sit");
    if($cod != "" && $grup != "" && $art != ""){
		if($sit == 0){
		     $sql = $ClsArt->cambia_sit_inventario($cod,$art,$grup,$sit);
		     //$respuesta->alert("$sql");
		     $rs = $ClsArt->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Detalle de Inventario desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
            }else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
		}else if($sit == 1){
			$sql = $ClsArt->cambia_sit_inventario($cod,$art,$grup,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsArt->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Detalle de Inventario activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}
	return $respuesta;
}

//////////////////---- Depreciaciones -----/////////////////////////////////////////////
function Grabar_Depreciacion($anio,$arrmeses,$filas){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticuloPropio();
   //$respuesta->alert("$cod,$grup,$art,$sit");
    if($anio != ""){
		if($filas > 0){
           $error = false;
		     for($i = 1; $i <= $filas; $i++){
               $sql = "";
					$sql = $ClsArt->insert_depreciacion($arrmeses[$i],$anio);
               $sql.= $ClsArt->update_precio_actual();
               $rs = $ClsArt->exec_sql($sql);
               if($rs != 1){
                  $error = true;
                  break;
               }
		     }
		     //$respuesta->alert("$sql");
				if($error == false){
					$respuesta->script('swal("Excelente!", "Depreciaciones Calculadas Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n, no se pudo realizar el calculo en todos los meses...", "error").then((value)=>{ cerrar(); });');
				}	
		}else{
			$respuesta->script('swal("Error", "No ha seleccionado ningun mes...", "error").then((value)=>{ cerrar(); });');
		}
	}
	return $respuesta;
}

//////////////////---- Varios -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "UnidadMedida");
//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Grupo_Articulo");
//////////////////---- Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Articulo");
$xajax->register(XAJAX_FUNCTION, "Combo_Grupo_Articulo");
$xajax->register(XAJAX_FUNCTION, "Grabar_Masa");
//////////////////---- INVENTARIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Carga");
$xajax->register(XAJAX_FUNCTION, "Grabar_Carga");
$xajax->register(XAJAX_FUNCTION, "Buscar_Inventario");
$xajax->register(XAJAX_FUNCTION, "Modificar_Inventario");
$xajax->register(XAJAX_FUNCTION, "Situacion_Inventario");
//////////////////---- Depreciaciones -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Depreciacion");
//El objeto xajax tiene que procesar cualquier petici\u00F3n
$xajax->processRequest();

?>