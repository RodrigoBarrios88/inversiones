<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_tema.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- TEMAS -----/////////////////////////////////////////////
function Grabar_Tema($pensum,$nivel,$grado,$seccion,$materia,$unidad,$nombre,$desc,$periodos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$materia,$maestro,$nom,$desc,$fecha,$link");
	$nombre = trim($nombre);
	$desc = trim($desc);
	$desc = str_replace(";",".",$desc);
	//decodifica
   $nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
	//--
	$nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	
   if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != "" && $unidad != "" && $periodos != ""){
		$codigo = $ClsAcad->max_tema();
		$codigo++;
		$sql = $ClsAcad->insert_tema($codigo,$pensum,$nivel,$grado,$seccion,$materia,$unidad,$nombre,$desc,$periodos);
		$rs = $ClsAcad->exec_sql($sql);
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


function Modificar_Tema($codigo,$materia,$unidad,$nombre,$desc,$periodos){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$cod,$materia,$nom,$desc,$fecha,$link");
	$nombre = trim($nombre);
	$desc = trim($desc);
	$desc = str_replace(";",".",$desc);
	//decodifica
   $nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
	//--
	$nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
   
   if($codigo != "" && $materia != "" && $unidad != "" && $periodos != ""){
		$sql = $ClsAcad->modifica_tema($codigo,$materia,$unidad,$nombre,$desc,$periodos);
		$rs = $ClsAcad->exec_sql($sql);
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


function Buscar_Tema($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$codigo");
	$result = $ClsAcad->get_tema($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["tem_codigo"];
			$respuesta->assign("codigo","value",$codigo);
			$pensum = $row["tem_pensum"];
			$respuesta->assign("pensum","value",$pensum);
			$nivel = $row["tem_nivel"];
			$respuesta->assign("nivel","value",$nivel);
			$grado = $row["tem_grado"];
			$respuesta->assign("grado","value",$grado);
			$seccion = $row["tem_seccion"];
			$respuesta->assign("grado","value",$seccion);
			$materia = $row["tem_materia"];
			$respuesta->assign("materia","value",$materia);
			$desc = utf8_decode($row["tem_descripcion"]);
			$respuesta->assign("desc","value",$desc);
			$nom = utf8_decode($row["tem_nombre"]);
			$respuesta->assign("nom","value",$nom);
			$periodos = $row["tem_cantidad_periodos"];
			$respuesta->assign("periodos","value",$periodos);
		}	
	}
	//abilita y desabilita botones
	$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
	$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
			
	//$contenido = tabla_tareas($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$desde,$fecha,$sit);
	$respuesta->assign("result","innerHTML",$contenido);
	$respuesta->script("cerrar();");
   return $respuesta;
}



function Eliminar_Tema($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   if($codigo != ""){
	   //$respuesta->alert("$cod,$sit");
		$sql = $ClsAcad->cambia_sit_tema($codigo,0);
		$rs = $ClsAcad->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros eliminado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
function Grabar_Archivo($tema,$nombre,$desc,$extension){
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
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
	if($nombre != "" && $tema != ""){
     	$codigo = $ClsAcad->max_tema_archivo($tema);
		$codigo++;
		$sql = $ClsAcad->insert_tema_archivo($codigo,$tema,$nombre,$desc,$extension);
		//$respuesta->alert("$sql");
      $rs = $ClsAcad->exec_sql($sql);
      if($rs == 1){
			$respuesta->assign("Filecodigo","value",$codigo);
			$respuesta->script('CargaArchivos();');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Delete_Archivo($codigo,$tema,$archivo){
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
	
	if($codigo != "" && $tema != ""){
     	$sql = $ClsAcad->delete_tema_archivo($codigo,$tema);
		//$respuesta->alert("$archivo");
      $rs = $ClsAcad->exec_sql($sql);
      if($rs == 1){
			unlink("../../CONFIG/DATALMS/TEMAS/MATERIAS/$archivo");
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- TEMAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tema");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tema");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tema");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Tema");
//////////////////---- ARCHIVOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Archivo");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  