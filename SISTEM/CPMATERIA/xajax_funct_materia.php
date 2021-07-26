<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_materia.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- MATERIAS -----/////////////////////////////////////////////
function Grabar_Materia($pensum,$nivel,$grado,$tipo,$cate,$orden,$desc,$dct){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$desc,$cate,$orden");
   
   if($desc != "" && $tipo != ""){
		$materia = $ClsPen->max_materia($pensum,$nivel,$grado);
		$materia++;
		$sql = $ClsPen->insert_materia($pensum,$nivel,$grado,$materia,$tipo,$cate,$orden,$desc,$dct);
		$rs = $ClsPen->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('cerrar();');
			$respuesta->script('swal("Excelente!", "Resgistro guardado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('cerrar();');
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}


function Modificar_Materia($pensum,$nivel,$grado,$codigo,$tipo,$cate,$orden,$desc,$dct){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("modifica_materia($pensum,$nivel,$grado,$codigo,$tipo,$desc,$dct,$cate,$orden)");
   
   if($desc != "" && $tipo != ""){
		 $sql = $ClsPen->modifica_materia($pensum,$nivel,$grado,$codigo,$tipo,$cate,$orden,$desc,$dct);
		 $rs = $ClsPen->exec_sql($sql);
		 //$respuesta->alert($sql);
		 if($rs == 1){
			$respuesta->script('cerrar();');
			$respuesta->script('swal("Excelente!", "Resgistro actualizado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script('cerrar();');
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
			
	}
   return $respuesta;
}


function Buscar_Materia($pensum,$nivel,$grado,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$grado,$codigo");
	$result = $ClsPen->get_materia($pensum,$nivel,$grado,$codigo);
	if(is_array($result)){
		foreach($result as $row){
			$pensum = $row["mat_pensum"];
			$respuesta->assign("pensum","value",$pensum);
			$grado = $row["mat_grado"];
			$nivel = $row["mat_nivel"];
			$cod = $row["mat_codigo"];
			$respuesta->assign("cod","value",$cod);
			$desc = utf8_decode($row["mat_descripcion"]);
			$respuesta->assign("desc","value",$desc);
			$dct = utf8_decode($row["mat_desc_ct"]);
			$respuesta->assign("dct","value",$dct);
			$tipo = $row["mat_tipo"];
			$respuesta->assign("tipo","value",$tipo);
			$cate = $row["mat_categoria"];
			$respuesta->assign("cate","value",$cate);
			$orden = $row["mat_orden"];
			$respuesta->assign("orden","value",$orden);
		}	
	}
	$contenido = nivel_html($pensum,"nivel","Combo_Nivel_Grado();");
	$respuesta->assign("divnivel","innerHTML",$contenido);
	$respuesta->assign("nivel","value",$nivel);
	$contenido = grado_html($pensum,$nivel,"grado","");
	$respuesta->assign("divgrado","innerHTML",$contenido);
	$respuesta->assign("grado","value",$grado);
	//abilita y desabilita botones
	$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
	$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
	//--		
	$contenido = tabla_materias($pensum,$nivel,$grado,$tipo,$sit);
	$respuesta->assign("result","innerHTML",$contenido);
	$respuesta->script("cerrar();");
	
   return $respuesta;
}



function CambiaSit_Materia($pensum,$nivel,$grado,$cod){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($cod != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql.= $ClsPen->cambia_sit_materia($pensum,$nivel,$grado,$cod,0);
		$rs = $ClsPen->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('cerrar();');
			$respuesta->script('swal("Excelente!", "Materia Deshabilitada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('cerrar();');
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//////////////////---- MATERIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Materia");
$xajax->register(XAJAX_FUNCTION, "Modificar_Materia");
$xajax->register(XAJAX_FUNCTION, "Buscar_Materia");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Materia");

//El objeto xajax tiene que procesar cualquier petici&oacute;n
$xajax->processRequest();

?>  