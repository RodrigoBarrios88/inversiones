<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_examen.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- ENCUESTA -----/////////////////////////////////////////////

function Grabar_Examen($pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecini,$horini,$fecfin,$horfin,$repetir,$acalificar){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	$ClsAcad = new ClsAcademico();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecini,$horini,$fecfin,$horfin");
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
	$tema = ($tema == "")?0:$tema;
    if($materia != "" && $unidad != "" && $tipo != "" && $titulo != "" && $desc != "" && $tipocalifica != "" && $fecinicio != "" && $feclimit != "" && $repetir != "" && $acalificar != ""){
		$codigo = $ClsExa->max_examen();
		$codigo++;
		$sql = $ClsExa->insert_examen($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecinicio,$feclimit,$repetir,$acalificar);
		$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
		if(is_array($result)){
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				$sql.= $ClsExa->insert_det_examen($codigo,$alumno,0,"",1);
			}
		}
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs = 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsExa->encrypt($codigo, $usu);
			if($tipo == "OL"){
			$respuesta->redirect("FRMpreguntas.php?hashkey=$hashkey",0);
			}else{
			$respuesta->script('swal("Excelente!", "Examen Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}
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
   $result = $ClsExa->get_examen($codigo);
	//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
					$pensum = $row["exa_pensum"];
					$nivel = $row["exa_nivel"];
					$grado = $row["exa_grado"];
					$seccion = $row["exa_seccion"];
					$materia = $row["exa_materia"];
					
					$unidad = $row["exa_unidad"];
					$respuesta->assign("unidad","value",$unidad);
					$combo_tema = tema_html($pensum,$nivel,$grado,$seccion,$materia,$unidad,"tema","Submit();");
					$respuesta->assign("divtema","innerHTML",$combo_tema);
					$tema = $row["exa_tema"];
					$respuesta->assign("tema","value",$tema);
					
					$respuesta->script("document.getElementById('unidad').setAttribute('disabled','disabled');");
					$respuesta->script("document.getElementById('tema').setAttribute('disabled','disabled');");
					//--
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
					///---
					$repetir = $row["exa_repetir"];
					$respuesta->assign("repetir","value",$repetir);
					///---
					$acalificar = $row["exa_calificar"];
					$respuesta->assign("acalificar","value",$acalificar);
			}
			$result = $ClsExa->get_pregunta("",$codigo);
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


function Modificar_Examen($cod,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecini,$horini,$fecfin,$horfin,$repetir,$acalificar){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
   //var_dump($respuestas);
	//$respuesta->alert("$cod,$tipo,$titulo,$desc,$tipocalifica,$fecini,$horini,$fecfin,$horfin,$repetir,$calificar");
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
	$tema = ($tema == "")?0:$tema;
   if($cod != "" && $tipo != "" && $titulo != "" && $desc != "" && $tipocalifica != "" && $fecinicio != "" && $feclimit != "" && $repetir != "" && $acalificar != ""){
		$sql = $ClsExa->modifica_examen($cod,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fecinicio,$feclimit,$repetir,$acalificar);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Examen Modificado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
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
		$sql = $ClsExa->cambia_sit_examen($cod,0);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Examen Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}


function Reenviar_Examen_Todos($pensum,$nivel,$grado,$seccion,$examen){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	$ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$examen");
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $examen != ""){
		$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
		$sql = "";
		if(is_array($result)){
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				$sql.= $ClsExa->insert_det_examen($examen,$alumno,0,"",1);
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
		$sql = $ClsExa->insert_det_examen($examen,$alumno,0,"",1);
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
		$codigo = $ClsExa->max_pregunta($examen);
		$codigo++;
		$sql = $ClsExa->insert_pregunta($codigo,$examen,$desc,$tipo,$puntos);
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


function Grabar_Pregunta_Respuestas($examen,$desc,$tipo,$puntos,$arr_respuestas){
	$respuesta = new xajaxResponse();
	$ClsExa = new ClsExamen();
   
	$desc = trim($desc);
   $desc = str_replace(";",".",$desc);
   //--
   $desc = utf8_encode($desc);
   //--
   $desc = utf8_decode($desc);
   //--
   if($examen != "" && $puntos != ""){
      $codigo = $ClsExa->max_pregunta($examen);
      $codigo++;
      $sql = $ClsExa->insert_pregunta($codigo,$examen,$desc,$tipo,$puntos);
      if(is_array($arr_respuestas)){
         $numero = $ClsExa->max_Opregunta($examen,$codigo);
         $numero++;
         foreach($arr_respuestas as $row){
            $sql.= $ClsExa->insert_multiple($numero,$codigo,$examen,$row,$puntos,$tipo);
            $numero++;
         }
      }
      $rs = $ClsExa->exec_sql($sql);
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
   $result = $ClsExa->get_pregunta($codigo,$examen);
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["pre_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $examen = utf8_decode($row["pre_examen"]);
         $respuesta->assign("examen","value",$examen);
         $desc = utf8_decode($row["pre_descripcion"]);
         $respuesta->assign("pregunta","value",$desc);
         $tipo = trim($row["pre_tipo"]);
         $respuesta->assign("tipo","value",$tipo);
         $puntos = $row["pre_puntos"];
         $respuesta->assign("puntos","value",$puntos);
      }
      if($tipo == 1){
         $respuesta->assign("field_wrapper","className","");
         $cantidad_preguntas = $ClsExa->count_multiple($codigo,$examen);
         $result = $ClsExa->get_multiple($codigo,$examen);
         if(is_array($result)){
            $i = 1;
            foreach($result as $row){
               $descripcion = $row["mult_descripcion"];
               $respuesta->assign("field_name_$i","value",utf8_decode($descripcion));
               if($i < $cantidad_preguntas){
                  $respuesta->script("addPregunta();");
               }
               $i++;
            }
         }
      }
      //--
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
      $respuesta->script("removeTabla();");
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
		$sql = $ClsExa->modifica_pregunta($codigo,$examen,$desc,$tipo,$puntos);
		$sql.= $ClsExa->delete_pregunta_multiple($codigo,$examen);
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

function Modificar_Pregunta_Respuesta($codigo,$examen,$desc,$tipo,$puntos,$arr_respuestas){
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
	 $sql1= $ClsExa->delete_pregunta_multiple($codigo,$examen);
	 $sql1 = $ClsExa->exec_sql($sql1);
	 if($codigo != "" && $examen != "" && $puntos != ""){
		 $sql = $ClsExa->modifica_pregunta($codigo,$examen,$desc,$tipo,$puntos);
		 
		 if(is_array($arr_respuestas)){
			$numero = $ClsExa->max_Opregunta($examen,$codigo);
			$numero++;
			foreach($arr_respuestas as $row){
			   $sql.= $ClsExa->insert_multiple($numero,$codigo,$examen,$row,$puntos,$tipo);
			   $numero++;
			  // $rt = $ClsExa->exec_sql($sql1);
			}
		 }
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
	  $sql = $ClsExa->delete_pregunta($codigo,$examen);
	  $sql.= $ClsExa->delete_pregunta_multiple($codigo,$examen);
	  $rs = $ClsExa->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1 ){
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
		$sql = $ClsExa->insert_clave($examen,$pregunta,$tipo,$ponderacion,$texto);
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
		$sql = $ClsExa->modifica_det_examen($examen,$alumno,$nota,$obs);
		$sql.= $ClsExa->cambiar_sit_det_examen($examen,$alumno,3);
		$rs = $ClsExa->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Examen Calificado Satisfactoriamente!!!", "success").then((value)=>{ window.history.back() });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////

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
		$codigo = $ClsExa->max_examen_archivo($examen);
      $codigo++;
      $sql = $ClsExa->insert_examen_archivo($codigo,$examen,$nombre,$desc,$extension);
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


function Delete_Archivo($codigo,$examen,$archivo){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	
	if($codigo != "" && $examen != ""){
     	$sql = $ClsExa->delete_examen_archivo($codigo,$examen);
		//$respuesta->alert("$sql");
      $rs = $ClsExa->exec_sql($sql);
      if($rs == 1){
			unlink("../../CONFIG/DATALMS/TEST/MATERIAS/$archivo");
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}



//////////////////---- ENCUESTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Examen");
$xajax->register(XAJAX_FUNCTION, "Buscar_Examen");
$xajax->register(XAJAX_FUNCTION, "Modificar_Examen");
$xajax->register(XAJAX_FUNCTION, "Situacion_Examen");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Examen");
$xajax->register(XAJAX_FUNCTION, "Examen");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Examen_Todos");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Examen_Alumno");
//////////////////---- PREGUNTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Grabar_Pregunta_Respuestas");
$xajax->register(XAJAX_FUNCTION, "Buscar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pregunta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pregunta_Respuesta");
$xajax->register(XAJAX_FUNCTION, "Situacion_Pregunta");
//////////////////---- CLAVE -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Clave");
//////////////////---- CALIFICAR -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Calificar_Examen");
//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Archivo");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo");
//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  