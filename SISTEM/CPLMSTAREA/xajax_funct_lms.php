<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_lms.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- TAREAS DE CURSOS -----/////////////////////////////////////////////
function Grabar_Tarea($curso,$tema,$maestro,$nom,$desc,$tipo,$pondera,$tipocalifica,$fec,$hor,$link){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	$ClsCur = new ClsCursoLibre();
	//$respuesta->alert("$curso,$tema,$tipo,$maestro,$nom,$desc,$fecha,$link");
	$nom = trim($nom);
	$desc = trim($desc);
	$tipo = trim($tipo);
	$desc = str_replace(";",".",$desc);
	//--
   $nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
	//--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
	//--
	$fecha = "$fec $hor";
   if($nom != "" && $desc != ""){
		 $codigo = $ClsTar->max_tarea_curso();
		 $codigo++;
		 $sql = $ClsTar->insert_tarea_curso($codigo,$curso,$tema,$maestro,$nom,$desc,$tipo,$pondera,$tipocalifica,$fecha,$link);
		 $result = $ClsCur->get_curso_alumno($curso,"");
		 if(is_array($result)){
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				$sql.= $ClsTar->insert_det_tarea_curso($codigo,$alumno,0,"",1);
			}
		 }
		 
		 $rs = $ClsTar->exec_sql($sql);
		 //$respuesta->alert($sql);
		 if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Modificar_Tarea($cod,$nom,$desc,$tipo,$pondera,$tipocalifica,$fec,$hor,$link){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   //$respuesta->alert("$cod,$tipo,$nom,$desc,$fecha,$link");
	$nom = trim($nom);
	$desc = trim($desc);
	$tipo = trim($tipo);
	$desc = str_replace(";",".",$desc);
	//--
   $nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
	//--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
   //--
	$fecha = "$fec $hor";
   if($nom != "" && $desc != "" && $tipo != ""){
		 $sql = $ClsTar->modifica_tarea_curso($cod,$nom,$desc,$tipo,$pondera,$tipocalifica,$fecha,$link);
		 $rs = $ClsTar->exec_sql($sql);
		// $respuesta->alert($sql);
		 if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Buscar_Tarea($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   //$respuesta->alert("$codigo");
	$result = $ClsTar->get_tarea_curso($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["tar_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $curso = $row["tar_curso"];
         $respuesta->assign("curso","value",$curso);
         $tema = $row["tar_tema"];
         $respuesta->assign("tema","value",$tema);
         $nom = utf8_decode($row["tar_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $desc = utf8_decode($row["tar_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $tipo = trim($row["tar_tipo"]);
         $respuesta->assign("tipo","value",$tipo);
         $pondera = trim($row["tar_ponderacion"]);
         $respuesta->assign("pondera","value",$pondera);
         $tipocalifica = trim($row["tar_tipo_calificacion"]);
         $respuesta->assign("tipocalifica","value",$tipocalifica);
         $fecha = $row["tar_fecha_entrega"];
         $fec = substr($fecha,0,10);
         $hor = substr($fecha,11,5);
         $fec = cambia_fecha($fec);
         $respuesta->assign("fec","value",$fec);
         $respuesta->assign("hor","value",$hor);
         $link = $row["tar_link"];
         $respuesta->assign("link","value",$link);
      }	
	}
   //abilita y desabilita botones
   $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
   $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
   
   //$contenido = tabla_tarea_cursos($cod,$curso,$tema,$tipo,$maestro,$desde,$fecha,$sit);
   $respuesta->assign("result","innerHTML",$contenido);
   $respuesta->script("cerrar();");
   
   return $respuesta;
}



function Eliminar_Tarea($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   if($codigo != ""){
	   //// busca y elimina archivos
		$result = $ClsTar->get_tarea_curso_archivo("",$codigo);
		if(is_array($result)){
			foreach($result as $row){
				$archivo = trim($row["arch_codigo"])."_".trim($row["arch_tarea"]).".".trim($row["arch_extencion"]);
				unlink("../../CONFIG/DATALMS/TAREAS/CURSOS/$archivo");
			}
		}	
		//elimina registros de la BD
		$sql = $ClsTar->delete_tarea_curso($codigo);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Tarea Eliminada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


function Calificar_Tarea($tarea,$alumno,$nota,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	//--
	$obs = trim($obs);
	$obs = str_replace(";",".",$obs);
	//--
	$obs = utf8_encode($obs);
	//--
	$obs = utf8_decode($obs);
   if($tarea != "" && $alumno != ""){
	  // $respuesta->alert("tarea,$alumno,$nota,$obs,$fila");
		$sql = $ClsTar->modifica_det_tarea_curso($tarea,$alumno,$nota,$obs);
		$sql.= $ClsTar->cambiar_sit_det_tarea_curso($tarea,$alumno,2);
		$rs = $ClsTar->exec_sql($sql);
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


function Reenviar_Tarea_Todos($curso,$tarea){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	$ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$tarea");
	if($curso != "" && $tarea != ""){
		$result = $ClsCur->get_curso_alumno($curso,"");
		$sql = "";
		if(is_array($result)){
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				$sql.= $ClsTar->insert_det_tarea_curso($tarea,$alumno,0,"",1);
			}
		}
		 
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Tarea enviada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
   return $respuesta;
}


function Reenviar_Tarea_Alumno($tarea,$alumno){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	//$respuesta->alert("$tarea,$alumno");
	if($alumno != "" && $tarea != ""){
		$sql = $ClsTar->insert_det_tarea_curso($tarea,$alumno,0,"",1);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Tarea enviada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
   return $respuesta;
}


////////////////////////// GRABAR ARCHIVO ///////////////////////////////
function Grabar_Archivo($tarea,$nombre,$desc,$extension){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
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
	
   if($tarea != "" && $nombre != "" && $extension != ""){
		$codigo = $ClsTar->max_tarea_curso_archivo($tarea);
      $codigo++;
      $sql = $ClsTar->insert_tarea_curso_archivo($codigo,$tarea,$nombre,$desc,$extension);
      $rs = $ClsTar->exec_sql($sql);
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

function Delete_Archivo($codigo,$tarea,$archivo){
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	
	if($codigo != "" && $tarea != ""){
     	$sql = $ClsTar->delete_tarea_curso_archivo($codigo,$tarea);
		//$respuesta->alert("$archivo");
      $rs = $ClsTar->exec_sql($sql);
      if($rs == 1){
			unlink("../../CONFIG/DATALMS/TAREAS/CURSOS/$archivo");
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- TAREAS DE CURSOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Calificar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Tarea_Todos");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Tarea_Alumno");
//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Archivo");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  