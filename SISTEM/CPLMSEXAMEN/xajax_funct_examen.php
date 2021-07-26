<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_examen.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- ENCUESTA -----/////////////////////////////////////////////

function Grabar_Examen($curso,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecini,$horini,$fecfin,$horfin){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	$ClsCur = new ClsCursoLibre();
	//$respuesta->alert("$curso,$tema,$tipo,$titulo,$desc,$fec,$hor");
	//--
	$titulo = trim($titulo);
	$desc = trim($desc);
	$tipo = trim($tipo);
	$desc = str_replace(";",".",$desc);
	//--
	$titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	//--
	$titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	//--
	$fecinicio = "$fecini $horini";
	$feclimit = "$fecfin $horfin";
    if($curso != "" && $tema != "" && $tipo != "" && $titulo != "" && $desc != "" && $tipocalifica != "" && $fecinicio != "" && $feclimit != ""){
		$codigo = $ClsExa->max_examen_curso();
		$codigo++;
		$sql = $ClsExa->insert_examen_curso($codigo,$curso,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecinicio,$feclimit);
		$result = $ClsCur->get_curso_alumno($curso,"");
		if(is_array($result)){
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				$sql.= $ClsExa->insert_det_examen_curso($codigo,$alumno,0,"",1);
			}
		}
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsExa->encrypt($codigo, $usu);
			$respuesta->redirect("FRMpreguntas.php?hashkey=$hashkey",0);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}



function Buscar_Examen($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
   $result = $ClsExa->get_examen_curso($codigo);
	//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
					$codigo = $row["exa_codigo"];
					$respuesta->assign("codigo","value",$codigo);
					$titulo = utf8_decode($row["exa_titulo"]);
					$respuesta->assign("titulo","value",$titulo);
					$desc = utf8_decode($row["exa_descripcion"]);
					$respuesta->assign("desc","value",$desc);
					$tipocalifica = utf8_decode($row["exa_tipo_calificacion"]);
					$respuesta->assign("tipocalifica","value",$tipocalifica);
					///---
					$fecinicio = $row["exa_fecha_inicio"];
					$fecinicio = cambia_fechaHora($fecinicio);
					$fecini = substr($fecinicio,0,10);
					$horini = substr($fecinicio,11,5);
					$respuesta->assign("fecini","value",$fecini);
					$respuesta->assign("horini","value",$horini);
					//--
					$feclimit = $row["exa_fecha_limite"];
					$feclimit = cambia_fechaHora($feclimit);
					$fecfin = substr($feclimit,0,10);
					$horfin = substr($feclimit,11,5);
					$respuesta->assign("fecfin","value",$fecfin);
					$respuesta->assign("horfin","value",$horfin);
					///---
					$tipo = $row["exa_tipo"];
					$respuesta->assign("tipo","value",$tipo);
			}
			$result = $ClsExa->get_pregunta_curso("",$codigo);
			if(is_array($result)){
				$puntos = 0;
				foreach($result as $row){
					$puntos+= $row["pre_puntos"];
				}
			}else{
				$puntos = 0;
			}
			$respuesta->assign("puntos","value","$puntos Punto(s).");
			//--
			$respuesta->script("cerrar();");
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
		}
    return $respuesta;
}


function Modificar_Examen($cod,$tipo,$titulo,$desc,$tipocalifica,$fecini,$horini,$fecfin,$horfin){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	//$respuesta->alert("$cod");
	//--
	$titulo = trim($titulo);
	$desc = trim($desc);
	$tipo = trim($tipo);
	$desc = str_replace(";",".",$desc);
	//--
	$titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	//--
	$titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	//--
   $fecinicio = "$fecini $horini";
	$feclimit = "$fecfin $horfin";
   if($cod != "" && $tipo != "" && $titulo != "" && $desc != "" && $tipocalifica != "" && $fecinicio != "" && $feclimit != ""){
		$sql = $ClsExa->modifica_examen_curso($cod,$tipo,$titulo,$desc,$tipocalifica,$fecinicio,$feclimit);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Evaluacion Modificado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Situacion_Examen($cod){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();

   //$respuesta->alert("$cod");
   if($cod != ""){
		$sql = $ClsExa->cambia_sit_examen_curso($cod,0);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Evaluacion Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Reenviar_Examen_Todos($curso,$examen){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	$ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$examen");
	if($curso != "" && $examen != ""){
		$result = $ClsCur->get_curso_alumno($curso,"");
		$sql = "";
		if(is_array($result)){
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				$sql.= $ClsExa->insert_det_examen_curso($examen,$alumno,0,"",1);
			}
		}
		 
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Ex\u00E1men enviado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
   return $respuesta;
}


function Reenviar_Examen_Alumno($examen,$alumno){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	//$respuesta->alert("$examen,$alumno");
	if($alumno != "" && $examen != ""){
		$sql = $ClsExa->insert_det_examen_curso($examen,$alumno,0,"",1);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Evaluacion enviada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
   return $respuesta;
}


//////////////////---- PREGUNTAS -----/////////////////////////////////////////////

function Grabar_Pregunta($examen,$desc,$tipo,$puntos){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	//--
	$desc = trim($desc);
	$desc = str_replace(";",".",$desc);
	//--
	$desc = utf8_encode($desc);
	//--
	$desc = utf8_decode($desc);
	
	if($examen != "" && $puntos != ""){
		$codigo = $ClsExa->max_pregunta_curso($examen);
		$codigo++;
		$sql = $ClsExa->insert_pregunta_curso($codigo,$examen,$desc,$tipo,$puntos);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Pregunta Grabada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Buscar_Pregunta($codigo,$examen){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
   $result = $ClsExa->get_pregunta_curso($codigo,$examen);
	//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
					$codigo = $row["pre_codigo"];
					$respuesta->assign("codigo","value",$codigo);
					$examen = utf8_decode($row["pre_examen"]);
					$respuesta->assign("examen","value",$examen);
					$desc = utf8_decode($row["pre_descripcion"]);
					$respuesta->assign("pregunta","value",$desc);
					$tipo = $row["pre_tipo"];
					$respuesta->assign("tipo","value",$tipo);
					$puntos = $row["pre_puntos"];
					$respuesta->assign("puntos","value",$puntos);
			}
			//--
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
		}
    return $respuesta;
}


function Modificar_Pregunta($codigo,$examen,$desc,$tipo,$puntos){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	//$respuesta->alert("$cod");
	//--
	$desc = trim($desc);
	$desc = str_replace(";",".",$desc);
	//--
	$desc = utf8_encode($desc);
	//--
	$desc = utf8_decode($desc);
	
	if($codigo != "" && $examen != "" && $puntos != ""){
		$sql = $ClsExa->modifica_pregunta_curso($codigo,$examen,$desc,$tipo,$puntos);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Pregunta Modificada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Situacion_Pregunta($codigo,$examen){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();

    //$respuesta->alert("$cod");
   if($codigo != "" && $examen != ""){
      $sql = $ClsExa->delete_pregunta_curso($codigo,$examen);
      $rs = $ClsExa->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Pregunta Eliminada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


//////////////////---- CLAVES -----/////////////////////////////////////////////

function Grabar_Clave($examen,$pregunta,$tipo,$ponderacion,$texto){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	//--
	$texto = trim($texto);
	$texto = str_replace(";",".",$texto);
	//--
	$texto = utf8_encode($texto);
	//--
	$texto = utf8_decode($texto);
	
	//$respuesta->alert("$examen,$pregunta,$tipo,$ponderacion,$texto");
	if($examen != "" && $pregunta != "" && $tipo != "" && $ponderacion != ""){
		$sql = $ClsExa->insert_clave_curso($examen,$pregunta,$tipo,$ponderacion,$texto);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			return $respuesta;
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


//////////////////---- CALIFICACION -----/////////////////////////////////////////////

function Calificar_Examen($examen,$alumno,$nota,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
   if($examen != "" && $alumno != ""){
	  // $respuesta->alert("tarea,$alumno,$nota,$obs,$fila");
		$sql = $ClsExa->modifica_det_examen_curso($examen,$alumno,$nota,$obs);
		$sql.= $ClsExa->cambiar_sit_det_examen_curso($examen,$alumno,3);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script("window.location.reload();");
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		 
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


////////////////////////// GRABAR ARCHIVO ///////////////////////////////
function Grabar_Archivo($examen,$nombre,$desc,$extension){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
   //$respuesta->alert("$curso,$tema,$nombre,$desc,$extension");
	//-- mayusculas
	$nombre = trim($nombre);
	$desc = trim($desc);
	$extension = strtolower($extension);
	$desc = str_replace(";",".",$desc);
	//-- decodificacion
	$nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
    //--
	$nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	//--
   if($examen != "" && $nombre != "" && $extension != ""){
		$codigo = $ClsExa->max_examen_archivo_curso($examen);
      $codigo++;
      $sql = $ClsExa->insert_examen_archivo_curso($codigo,$examen,$nombre,$desc,$extension);
      $rs = $ClsExa->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->assign("Filecodigo","value",$codigo); ///asigna el codigo de documento
         $respuesta->script('CargaArchivos();'); ///submit al archivo de carga de documento (upload)
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////

function Delete_Archivo($codigo,$examen,$archivo){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	
	if($codigo != "" && $examen != ""){
     	$sql = $ClsExa->delete_examen_archivo_curso($codigo,$examen);
		//$respuesta->alert("$archivo");
      $rs = $ClsExa->exec_sql($sql);
      if($rs == 1){
			unlink("../../CONFIG/DATALMS/TEST/CURSOS/$archivo");
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


//////////////////---- EXAMEN -----//////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Examen");
$xajax->register(XAJAX_FUNCTION, "Buscar_Examen");
$xajax->register(XAJAX_FUNCTION, "Modificar_Examen");
$xajax->register(XAJAX_FUNCTION, "Situacion_Examen");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Examen_Todos");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Examen_Alumno");
//////////////////---- PREGUNTAS -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Situacion_Pregunta");
//////////////////---- CLAVE -----////////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Clave");
//////////////////---- CALIFICAR -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Calificar_Examen");
//////////////////---- ARCHIVOS AUXILIARES O GIAS -----///////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Archivo");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo");

//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  