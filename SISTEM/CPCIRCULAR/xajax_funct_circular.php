<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_circular.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// LISTA /////////
function Target_Grupos($target,$tipo){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$target,$tipo");
	if($target == "SELECT"){
		if($tipo == 1){
			$contenido = tabla_grados_secciones();
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}else if($tipo == 2){
			$contenido = grupos_lista_multiple("grupos");
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}else{
			$contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}
   }else{
	  $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
	  $respuesta->assign("divgrupos","innerHTML",$contenido);
   }
   return $respuesta;
}


//////////////////---- INFORMACION -----/////////////////////////////////////////////

function Grabar_Circular($titulo,$desc,$target,$tipo,$autorizacion,$arrgrupo,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCir = new ClsCircular();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$titulo,$desc,$target,$tipo,$documento,$autorizacion,$arrgrupo,$filas");
   $titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	//--
   $titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	
   if($titulo != ""){
      $circular = $ClsCir->max_circular();
		$circular++; /// Maximo codigo
      $documento = str_shuffle($circular.uniqid()).".pdf";
		$sql = $ClsCir->insert_circular($circular,$titulo,$desc,$target,$tipo,$documento,$autorizacion); /// Inserta a tabla Circular
		
		if($target == "SELECT"){
			if($tipo == 1){
				$pensum = $_SESSION["pensum"];
				for($i = 0; $i< $filas; $i++){
					$bloque = explode(".",$arrgrupo[$i]);
				   $nivel = $bloque[1];
				   $grado = $bloque[2];
				   $seccion = $bloque[3];
				   $sql.= $ClsCir->insert_det_circular_secciones($circular,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					//--
					$arrnivel.= $nivel.",";
					$arrgrado.= $grado.",";
					$arrsecc.= $seccion.",";
				}
				$arrnivel = substr($arrnivel,0,-1);
				$arrgrado = substr($arrgrado,0,-1);
				$arrsecc = substr($arrsecc,0,-1);
				$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,$arrnivel,$arrgrado,$arrsecc);
			}else if($tipo == 2){	
				for($i = 0; $i< $filas; $i++){
				   $grupo = $arrgrupo[$i];
					$sql.= $ClsCir->insert_det_circular_grupos($circular,$grupo); /// Inserta detalle
					//--
					$strgrupo.= $grupo.",";
				}
				$strgrupo = substr($strgrupo,0,-1);
				$result_push = $ClsPush->get_grupos_users($strgrupo);
			}
		}else{
			$pensum = $_SESSION["pensum"];
			$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,'','','');
		}
		/// registra la notificacion //
		if(is_array($result_push)) {
			$message = "(Circular) $titulo";
			$push_tipo = 6;
			$item_id = $circular;
			foreach ($result_push as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
		}
		$rs = $ClsCir->exec_sql($sql);
		//$respuesta->alert($sql);
		 if($rs == 1){
			if($documento != ""){
				$respuesta->assign("codigo","value",$circular);
            $respuesta->assign("docname","value",$documento);
				$respuesta->script("Submit();");
			}else{
				$respuesta->script('swal("Excelente!", "Nueva circular enviada con exito!", "success").then((value)=>{ window.location.reload(); });');
			}
		 }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}



function Modificar_Circular($codigo,$titulo,$desc,$documento,$autorizacion){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCir = new ClsCircular();
	//$respuesta->alert("$titulo,$desc,$target,$tipo,$documento,$autorizacion,$arrgrupo,$filas");
   $titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	//--
   $titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	//--
	$documento = trim($documento);
   
   if($titulo != ""){
      $sql = $ClsCir->modifica_circular($codigo,$titulo,$desc,$autorizacion); /// Inserta a tabla Maestra
      if($documento != ""){
         $documento = str_shuffle($codigo.uniqid()).".pdf";
         $sql.= $ClsCir->modifica_documento($codigo,$documento);
      }
		$rs = $ClsCir->exec_sql($sql);
		//$respuesta->alert($sql);
		 if($rs == 1){
			if($documento != ""){
				$respuesta->assign("codigo","value",$codigo);
            $respuesta->assign("docname","value",$documento);
				$respuesta->script("Submit();");
			}else{
				$respuesta->script('swal("Excelente!", "Informaci\u00F3n de circular actualizada con exito!", "success").then((value)=>{ window.location.reload(); });');
			}
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}



function Buscar_Circular($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsCir = new ClsCircular();
	
	//$respuesta->alert("$codigo");
   $result = $ClsCir->get_circular($codigo);
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["cir_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $titulo = utf8_decode($row["cir_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $desc = utf8_decode($row["cir_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $publicacion = $row["cir_fecha_publicacion"];
         $respuesta->assign("publicacion","value",$publicacion);
         $autorizacion = $row["cir_autorizacion"];
         if($autorizacion == 1){
            $respuesta->script('document.getElementById("autorizacionsi").checked = true;');
         }else{
            $respuesta->script('document.getElementById("autorizacionno").checked = true;');
         }
         //documento
         $documento = $row["cir_documento"];
         $respuesta->assign("documentoold","value",$documento);
         $olddoc = '<i class = "fa fa-file-text-o fa-2x"></i> '.$documento;
         $olddoc.= ' &nbsp; &nbsp; <a class="btn btn-default btn-xs" href="../../CONFIG/Circulares/'.$documento.'" target = "_blank" title = "ver Circular" ><span class="fa fa-search"></span></a>';
         $respuesta->assign("olddoc","innerHTML",$olddoc);
      }
      //--
      $respuesta->script('document.getElementById("titulo").focus();');
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}



function Situacion_Circular($cod){
   $respuesta = new xajaxResponse();
   $ClsCir = new ClsCircular();

   //$respuesta->alert("$cod");
   if($cod != ""){
      $sql = $ClsCir->cambia_sit_circular($cod,0);
      $rs = $ClsCir->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Ok!", "Circular eliminada satisfactoriamente...", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }	
	}

	return $respuesta;
}


//////////////////---- COMBOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Target_Grupos");
//////////////////---- ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Circular");
$xajax->register(XAJAX_FUNCTION, "Modificar_Circular");
$xajax->register(XAJAX_FUNCTION, "Buscar_Circular");
$xajax->register(XAJAX_FUNCTION, "Situacion_Circular");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  