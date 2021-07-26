<?php 
include_once("html_fns_lms.php");

$request = $_REQUEST["request"]; 
switch($request){
	case "grabarLmsTarea":
		$curso = $_REQUEST["curso"];
		$tema = $_REQUEST["tema"];
		$maestro = $_REQUEST["maestro"];
		$nom = $_REQUEST["nom"];
		$desc = $_REQUEST["desc"];
		$tipo = $_REQUEST["tipo"];
		$pondera = $_REQUEST["pondera"];
		$tipocalifica = $_REQUEST["tipocalifica"];
		$fec = $_REQUEST["fec"];
		$hor = $_REQUEST["hor"];
		$link = $_REQUEST["link"];
		Grabar_Tarea($curso,$tema,$maestro,$nom,$desc,$tipo,$pondera,$tipocalifica,$fec,$hor,$link);
	    break;
	case "tabla":
	    $curso = $_REQUEST["curso"];
		$tema = $_REQUEST["tema"];
		$maestro = $_REQUEST["maestro"];
		get_tabla($curso,$tema,$maestro);
		break;
	case "eliminarLmsTarea":
		$codigo = $_REQUEST["codigo"];
	    Eliminar_Tarea($codigo);
		break;
	case "buscarTarea":
		$codigo = $_REQUEST["codigo"];
		Buscar_Tarea($codigo);
		break;
	case "editarLmsTarea":
		$cod = $_REQUEST["codigo"];
		$nom = $_REQUEST["nom"];
		$desc = $_REQUEST["desc"];
		$tipo = $_REQUEST["tipo"];
		$pondera = $_REQUEST["pondera"];
		$tipocalifica = $_REQUEST["tipocalifica"];
		$fec = $_REQUEST["fec"];
		$hor = $_REQUEST["hor"];
		$link = $_REQUEST["link"];
	    Modificar_Tarea($cod,$nom,$desc,$tipo,$pondera,$tipocalifica,$fec,$hor,$link);
		break;
	case "ReenviarLmsTareaTodos":
		$curso = $_REQUEST["curso"];
		$tarea = $_REQUEST["tarea"];
		Reenviar_Tarea_Todos($curso,$tarea);
    	break;	
    case "ReenviarLmsTarea":
		$alumno = $_REQUEST["alumno"];
		$tarea = $_REQUEST["tarea"];
		Reenviar_Tarea_Alumno($tarea,$alumno);
		break;
	default:
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Seleccione un metodo..."
		);
		//echo json_encode($arr_respuesta);
}


//////////////////---- TAREAS DE CURSOS -----/////////////////////////////////////////////
function Grabar_Tarea($curso,$tema,$maestro,$nom,$desc,$tipo,$pondera,$tipocalifica,$fec,$hor,$link){
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
			
			$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Registro guardado satisfactoriamente...!"
			);
			echo json_encode($arr_respuesta);
		
		 }else{
		
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
		}	
			
	}
   return $respuesta;
}


function Modificar_Tarea($cod,$nom,$desc,$tipo,$pondera,$tipocalifica,$fec,$hor,$link){
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
		$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Registro modificado satisfactoriamente...!"
			);
			echo json_encode($arr_respuesta);
		
		 }else{
		
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
		}	
			
			
	}
   return $respuesta;
}


function Buscar_Tarea($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $ClsTar = new ClsTarea();
   //$respuesta->alert("$codigo");
	$result = $ClsTar->get_tarea_curso($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["tar_codigo"];
         $curso = $row["tar_curso"];
         $tema = $row["tar_tema"];
         $arr_data["codigo"] = $row["tar_codigo"];
         $arr_data["curso"] = $row["tar_curso"];
         $arr_data["tema"] = $row["tar_tema"];
         $arr_data["nombre"] = utf8_decode($row["tar_nombre"]);
         $arr_data["desc"] = utf8_decode($row["tar_descripcion"]);
         $arr_data["tipo"] = trim($row["tar_tipo"]);
         $arr_data["ponderacion"] = trim($row["tar_ponderacion"]);
         $arr_data["tipocalifica"] = trim($row["tar_tipo_calificacion"]);
           $fecha = $row["tar_fecha_entrega"];
         $fec = substr($fecha,0,10);
         $hor = substr($fecha,11,5);
         $fec = cambia_fecha($fec);
         $arr_data["hora"]  = $hor;
         $arr_data["fecha"] = $fec;
         $arr_data["link"] = $row["tar_link"];
      }	
    	$arr_respuesta = array(
    					"status" => true,
    					"data" => $arr_data,
    					"tabla" => tabla_tareas($codigo,$curso,$tema,'','',''),
    					"message" => ""
    				);
    			}else{
    				$arr_respuesta = array(
    					"status" => false,
    					"data" => [],
    					"message" => "Aún no hay datos registrados..."
    				);
    			}
			echo json_encode($arr_respuesta);

}



function Eliminar_Tarea($codigo){
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
			$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Registro eliminado satisfactoriamente...!"
			);
			echo json_encode($arr_respuesta);
		 }else{
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
		}	
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
		    	$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Tarea enviada satisfactoriamente!!!"
			);
			echo json_encode($arr_respuesta);
		 }else{
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
		}	
	}
   return $respuesta;
}


function Reenviar_Tarea_Alumno($tarea,$alumno){
   $ClsTar = new ClsTarea();
	//$respuesta->alert("$tarea,$alumno");
	if($alumno != "" && $tarea != ""){
		$sql = $ClsTar->insert_det_tarea_curso($tarea,$alumno,0,"",1);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Tarea enviada satisfactoriamente!!!"
			);
			echo json_encode($arr_respuesta);
		 }else{
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
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

 ///////////// TABLA /////////
 
 function get_tabla($curso,$tema,$maestro){ 
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea_curso($cod,$curso,$tema,$maestro,$tipo,$desde,$fecha,$sit);
	if(is_array($result)){
		$arr_respuesta = array(
			"status" => true,
			"tabla" => tabla_tareas($cod,$curso,$tema,$maestro,$tipo,$sit),
			"message" => ""
		);
	}else{
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Aún no hay datos registrados..."
		);
	}
	echo json_encode($arr_respuesta);
}



?>  