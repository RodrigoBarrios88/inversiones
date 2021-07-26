<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_encuesta.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- ENCUESTA -----/////////////////////////////////////////////

function Buscar_Encuesta($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
   $result = $ClsEnc->get_encuesta($codigo);
	//$respuesta->alert("$result");
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["enc_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $titulo = utf8_decode($row["enc_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $desc = utf8_decode($row["enc_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $feclimit = $row["enc_fecha_limite"];
         $feclimit = cambia_fechaHora($feclimit);
         $respuesta->assign("feclimit","value",$feclimit);
         $destinatarios = $row["enc_destinatarios"];
         $respuesta->assign("destinatarios","value",$destinatarios);
      }
      //--
      $respuesta->script('document.getElementById("titulo").focus();');
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}


function Grabar_Encuesta($target,$tipo_target,$destinatarios,$titulo,$desc,$feclimit,$checks,$filas){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
	//$respuesta->alert("$target,$tipo_target,$destinatarios,$titulo,$desc,$feclimit,$checks,$filas");
	//--
	$titulo = trim($titulo);
	$desc = trim($desc);
	$target = trim($target);
	$feclimit = trim($feclimit);
	$desc = str_replace(";", ",", $desc);
	//--
	$titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	$target = utf8_encode($target);
	//--
	$titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	$target = utf8_decode($target);
    
   if($target != "" && $titulo != "" && $desc != "" && $feclimit != ""){
		$codigo = $ClsEnc->max_encuesta();
		$codigo++; /// Maximo codigo
		$sql = $ClsEnc->insert_encuesta($codigo,$target,$tipo_target,$destinatarios,$titulo,$desc,$feclimit); /// Inserta a tabla Maestra
		
		if($target == "SELECT"){
			if($tipo_target == 1){
				$pensum = $_SESSION["pensum"];
				for($i = 1; $i <= $filas; $i++){
					$bloque = explode(".",$checks[$i]);
					$pensum = $bloque[0];
					$nivel = $bloque[1];
					$grado = $bloque[2];
					$sql.= $ClsEnc->insert_encuesta_target_grados($codigo,$pensum,$nivel,$grado); /// Inserta detalle
				}
			}else if($tipo_target == 2){	
				for($i = 1; $i <= $filas; $i++){
					$grupo = $checks[$i];
					$sql.= $ClsEnc->insert_encuesta_target_grupos($codigo,$grupo); /// Inserta detalle
				}
			}
		}
		
		$rs = $ClsEnc->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsEnc->encrypt($codigo, $usu);
			$respuesta->script('swal("Excelente!", "Encuesta grabada satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMpreguntas.php?hashkey='.$hashkey.'" });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}

function Modificar_Encuesta($cod,$titulo,$desc,$feclimit,$destinatarios){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
	//$respuesta->alert("$cod");
	//--
	$titulo = trim($titulo);
	$desc = trim($desc);
	$target = trim($target);
	$feclimit = trim($feclimit);
	$desc = str_replace(";", ",", $desc);
	//--
	$titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	$target = utf8_encode($target);
	//--
	$titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	$target = utf8_decode($target);
    
    if($cod != ""){
		$sql = $ClsEnc->modifica_encuesta($cod,$titulo,$desc,$feclimit,$destinatarios);
		$rs = $ClsEnc->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Encuesta actualizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Situacion_Encuesta($cod){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();

   //$respuesta->alert("$cod");
   if($cod != ""){
      $sql = $ClsEnc->cambia_sit_encuesta($cod,0);
      $rs = $ClsEnc->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Ok", "Encuesta eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


function Cerrar_Encuesta($cod){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();

   //$respuesta->alert("$cod");
   if($cod != ""){
      $sql = $ClsEnc->cambia_sit_encuesta($cod,2);
      $rs = $ClsEnc->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Se ha cerrado la encuesta satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


/////////////////////////////////////////////---- PUBLICACION DE ENCUESTA -----//////////////////////////////////////////////

function Publicar_Encuesta($codigo){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
	$ClsPush = new ClsPushup();
	 
   if($codigo != ""){
		$result = $ClsEnc->get_encuesta($codigo);
		//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["enc_codigo"];
				$titulo = utf8_decode($row["enc_titulo"]);
				$desc = utf8_decode($row["enc_descripcion"]);
				$feclimit = $row["enc_fecha_limite"];
				$feclimit = cambia_fechaHora($feclimit);
				$target = trim($row["enc_target"]);
				$tipo_target = trim($row["enc_tipo_target"]);
			}
		}
		
		if($target == "SELECT"){
			if($tipo_target == 1){
				$pensum = $_SESSION["pensum"];
				$result = $ClsEnc->get_encuesta_grados($codigo,'','','');
				if(is_array($result)){
					foreach($result as $row){
						$pensum = $row["tar_pensum"];
						$nivel = $row["tar_nivel"];
						$grado = $row["tar_grado"];
						//--
						$arrnivel.= $nivel.",";
						$arrgrado.= $grado.",";
					}
				}
				$arrnivel = substr($arrnivel,0,-1);
				$arrgrado = substr($arrgrado,0,-1);
            $result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,$arrnivel,$arrgrado,"");
			}else if($tipo_target == 2){
            $arrgrupo = "";
				$result = $ClsEnc->get_encuesta_grupos($codigo,'');
            if(is_array($result)){
					foreach($result as $row){
						$grupo = $row["tar_grupo"];
						$arrgrupo.= $grupo.",";
               }
				}
            $arrgrupo = substr($arrgrupo,0,-1);
				$result_push = $ClsPush->get_grupos_users($arrgrupo);
			}
		}else{
			$pensum = $_SESSION["pensum"];
			$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,'','','');
		}
		
		/// registra la notificacion //
		if(is_array($result_push)) {
			$title = 'Nueva Encuesta';
			$message = $titulo;
			$push_tipo = 4;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
         //--
			foreach ($result_push as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
		}
		
		$rs = $ClsEnc->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			///// Ejecuta notificaciones push
			if(is_array($result_push)) {
				foreach ($result_push as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               //--
               $data = array(
                  'landing_page'=> 'encuesta2',
                  'codigo' => $item_id
               );
					//envia la push
					if($device_type == 'android') {
						SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
        			}else if($device_type == 'ios') {
        				SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
            	}	
				}
			}
			////
			$respuesta->script('swal("Ok", "Encuesta notificada con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}



//////////////////---- PREGUNTAS -----/////////////////////////////////////////////

function Grabar_Pregunta($encuesta,$desc,$tipo){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
	//--
	$desc = trim($desc);
	//--
	$desc = utf8_encode($desc);
	//--
	$desc = utf8_decode($desc);
	
	if($encuesta != ""){
		$codigo = $ClsEnc->max_pregunta($encuesta);
		$codigo++;
		$sql = $ClsEnc->insert_pregunta($codigo,$encuesta,$desc,$tipo);
		$rs = $ClsEnc->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Pregunta grabada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Buscar_Pregunta($codigo,$encuesta){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
   $result = $ClsEnc->get_pregunta($codigo,$encuesta);
	//$respuesta->alert("$result");
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["pre_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $encuesta = utf8_decode($row["pre_encuesta"]);
         $respuesta->assign("encuesta","value",$encuesta);
         $desc = utf8_decode($row["pre_descripcion"]);
         $respuesta->assign("pregunta","value",$desc);
         $tipo = $row["pre_tipo"];
         $respuesta->assign("tipo","value",$tipo);
      }
      //--
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}


function Modificar_Pregunta($codigo,$encuesta,$desc,$tipo){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();
	//$respuesta->alert("$cod");
	//--
	$desc = trim($desc);
	//--
	$desc = utf8_encode($desc);
	//--
	$desc = utf8_decode($desc);
	
	if($codigo != "" && $encuesta != ""){
		$sql = $ClsEnc->modifica_pregunta($codigo,$encuesta,$desc,$tipo);
		$rs = $ClsEnc->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Pregunta actualizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Situacion_Pregunta($codigo,$encuesta){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();

   //$respuesta->alert("$cod");
   if($codigo != "" && $encuesta != ""){
      $sql = $ClsEnc->delete_pregunta($codigo,$encuesta);
      $rs = $ClsEnc->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Ok", "Pregunta eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


//////////////////---- RESPUESTAS -----/////////////////////////////////////////////

function Grabar_Respuesta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$texto){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();

	if($encuesta != "" && $pregunta != "" && $persona != "" && $tipo != "" && $ponderacion != ""){
      $sql = $ClsEnc->insert_respuesta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$texto);
      $rs = $ClsEnc->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         return $respuesta;
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


//////////////////---- ENCUESTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Encuesta");
$xajax->register(XAJAX_FUNCTION, "Grabar_Encuesta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Encuesta");
$xajax->register(XAJAX_FUNCTION, "Situacion_Encuesta");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Encuesta");
$xajax->register(XAJAX_FUNCTION, "Publicar_Encuesta");
//////////////////---- PREGUNTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Situacion_Pregunta");
//////////////////---- RESPUESTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Respuesta");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  