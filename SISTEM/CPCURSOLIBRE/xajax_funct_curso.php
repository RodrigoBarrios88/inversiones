<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_curso.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


function Grabar_Curso($nom,$desc,$clase,$sede,$cupo,$fini,$ffin){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$desc,$anio");
	//-- mayusculas
	$nom = trim($nom);
	$desc = trim($desc);
	//-- decodificacion
	$nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
   //--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
	
   if($nom != "" && $desc != "" && $clase != "" && $sede != "" && $cupo != "" && $fini != "" && $ffin != ""){
      $codigo = $ClsCur->max_curso();
      $codigo++;
      $sql = $ClsCur->insert_curso($codigo,$nom,$desc,$clase,$sede,$cupo,$fini,$ffin);
      
      $rs = $ClsCur->exec_sql($sql);
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


function Buscar_Curso($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$codigo");
		$cont = $ClsCur->count_curso($codigo);
		if($cont>0){
			if($cont==1){
			   $result = $ClsCur->get_curso($codigo);
			   foreach($result as $row){
					$cod = $row["cur_codigo"];
					$respuesta->assign("cod","value",$cod);
					$nom = utf8_decode($row["cur_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$desc = utf8_decode($row["cur_descripcion"]);
					$respuesta->assign("desc","value",$desc);
					$clase = $row["cur_clasificacion"];
					$respuesta->assign("clase","value",$clase);
					$sede = $row["cur_sede"];
					$respuesta->assign("sede","value",$sede);
					$cupo = $row["cur_cupo_max"];
					$respuesta->assign("cupo","value",$cupo);
					$fini = cambia_fecha($row["cur_fecha_inicio"]);
					$respuesta->assign("fini","value",$fini);
					$ffin = cambia_fecha($row["cur_fecha_fin"]);
					$respuesta->assign("ffin","value",$ffin);
			   }
			}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
			
			$contenido = tabla_cursos($codigo,"","","","","","","");;
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
	   	}
    return $respuesta;
}



function Modificar_Curso($cod,$nom,$desc,$clase,$sede,$cupo,$fini,$ffin){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$desc,$anio");
   //-- mayusculas
	$nom = trim($nom);
	$desc = trim($desc);
	//-- decodificacion
	$nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
   //--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
	
   if($cod != "" && $nom != "" && $desc != "" && $clase != "" && $sede != "" && $cupo != "" && $fini != "" && $ffin != ""){
		 $sql = $ClsCur->modifica_curso($cod,$nom,$desc,$clase,$sede,$cupo,$fini,$ffin);
		 
		$rs = $ClsCur->exec_sql($sql);
		 //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}

function Situacion_Curso($cod){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   if($cod != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsCur->cambia_sit_curso($cod);
		$rs = $ClsCur->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


////////////////////////// ASIGNACION DE ALUMNOS A CURSOS LIBRES ///////////////////////////////

function Grabar_Tema($curso,$nom,$desc,$periodos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$desc,$anio");
	//-- mayusculas
	$nom = trim($nom);
	$desc = trim($desc);
	//-- decodificacion
	$nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
   //--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
	
   if($nom != "" && $desc != "" && $curso != "" && $periodos != ""){
		 $codigo = $ClsCur->max_tema($curso);
		 $codigo++;
		 $sql = $ClsCur->insert_tema($codigo,$curso,$nom,$desc,$periodos);
		 
		 $rs = $ClsCur->exec_sql($sql);
		 //$respuesta->alert($sql);
		 if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}



function Buscar_Tema($codigo,$curso){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$codigo");
		$result = $ClsCur->get_tema($codigo,$curso);
		if(is_array($result)){
			foreach($result as $row){
            $codigo = $row["tem_codigo"];
            $respuesta->assign("cod","value",$codigo);
            $curso = $row["tem_curso"];
            $respuesta->assign("curso","value",$curso);
            $nom = utf8_decode($row["tem_nombre"]);
            $respuesta->assign("nom","value",$nom);
            $periodos = trim($row["tem_cantidad_periodos"]);
            $respuesta->assign("periodos","value",$periodos);
            $desc = utf8_decode($row["tem_descripcion"]);
            $respuesta->assign("desc","value",$desc);
			}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
			
			$contenido = tabla_temas($codigo,$codigo);
			$respuesta->assign("result","innerHTML",$contenido);
		}
		$respuesta->script("cerrar();");
		
    return $respuesta;
}



function Modificar_Tema($codigo,$curso,$nom,$desc,$periodos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$desc,$anio");
	//-- mayusculas
	$nom = trim($nom);
	$desc = trim($desc);
	//-- decodificacion
	$nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
   //--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
	
   if($nom != "" && $desc != "" && $curso != "" && $periodos != ""){
		 $sql = $ClsCur->modifica_tema($codigo,$curso,$nom,$desc,$periodos);
		 $rs = $ClsCur->exec_sql($sql);
		 //$respuesta->alert($sql);
		 if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Situacion_Tema($cod,$curso){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   if($cod != "" && $curso != ""){
	   //$respuesta->alert("$cod,$sit");
		$sql = $ClsCur->cambia_sit_tema($cod,$curso);
		$rs = $ClsCur->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros eliminado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}

////////////////////////// GRABAR ARCHIVO ///////////////////////////////
function Grabar_Archivo($curso,$tema,$nombre,$desc,$extension){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
   //$respuesta->alert("$curso,$tema,$nombre,$desc,$extension");
	//-- mayusculas
	$nombre = trim($nombre);
	$desc = trim($desc);
	$extension = strtolower($extension);
	//-- decodificacion
	$nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
    //--
	$nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	//--
	
   if($curso != "" && $tema != "" && $nombre != "" && $desc != "" && $extension != ""){
		$codigo = $ClsCur->max_tema_archivo($curso,$tema);
      $codigo++;
      $sql = $ClsCur->insert_tema_archivo($codigo,$curso,$tema,$nombre,$desc,$extension);
      $rs = $ClsCur->exec_sql($sql);
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


////////////////////////// ASIGNACION DE ALUMNOS A CURSOS LIBRES ///////////////////////////////
function Graba_Alumno_Curso($alumno,$curso){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	
	if($alumno != "" && $curso != ""){
		$sql = $ClsCur->insert_curso_alumno($curso,$alumno);
		//asigna tareas ya creados 
		$result = $ClsTar->get_tarea_curso('',$curso);
		if(is_array($result)){
			foreach($result as $row){
				$tarea = trim($row["tar_codigo"]);
				$sql.= $ClsTar->insert_det_tarea_curso($tarea,$alumno,0,'',1);
			}
		}
		//asigna examenes ya creados
		$result = $ClsExa->get_examen_curso('',$curso);
		if(is_array($result)){
			foreach($result as $row){
				$examen = trim($row["exa_codigo"]);
				$sql.= $ClsExa->insert_det_examen_curso($examen,$alumno,0,'',1);
			}
		}
		//$respuesta->alert("$sql");
      $rs = $ClsCur->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cursos Asignados Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Delete_Alumno_Curso($alumno,$curso){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	
	if($alumno != "" && $curso != ""){
     	$sql = $ClsCur->delete_curso_alumno($curso,$alumno);
		//$respuesta->alert("$sql");
      $rs = $ClsCur->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cursos Desasignados Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////

function Delete_Archivo($codigo,$curso,$tema,$archivo){
   $respuesta = new xajaxResponse();
   $ClsCur = new ClsCursoLibre();
	
	if($codigo != "" && $curso != "" && $tema != ""){
     	$sql = $ClsCur->delete_tema_archivo($codigo,$curso,$tema);
		//$respuesta->alert("$archivo");
      $rs = $ClsCur->exec_sql($sql);
      if($rs == 1){
			unlink("../../CONFIG/DATALMS/TEMAS/CURSOS/$archivo");
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}

//////////////////---- CURSOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Importar_Curso");
$xajax->register(XAJAX_FUNCTION, "Grabar_Curso");
$xajax->register(XAJAX_FUNCTION, "Modificar_Curso");
$xajax->register(XAJAX_FUNCTION, "Buscar_Curso");
$xajax->register(XAJAX_FUNCTION, "Situacion_Curso");
//////////////////---- TEMA -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tema");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tema");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tema");
$xajax->register(XAJAX_FUNCTION, "Situacion_Tema");
//////////////////---- ARCHIVO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Archivo");
////////////////////////// ASIGNACION DE ALUMNOS A CURSOS LIBRES ////////
$xajax->register(XAJAX_FUNCTION, "Graba_Alumno_Curso");
$xajax->register(XAJAX_FUNCTION, "Delete_Alumno_Curso");
//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  