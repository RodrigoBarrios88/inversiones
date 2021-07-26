<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_academico.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- VARIOS -----/////////////////////////////////////////////
function Pensum_Nivel($pensum,$idniv,$idsniv,$accniv){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$idniv,$idsniv,$accniv");
   $contenido = nivel_html($pensum,$idniv,$accniv);
   $respuesta->assign($idsniv,"innerHTML",$contenido);
	
	return $respuesta;
}

function Nivel_Grado($pensum,$nivel,$idgra,$idsgra,$accgra){
   $respuesta = new xajaxResponse();
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
   
	//$respuesta->alert("$pensum,$nivel,$idgra,$tipo_codigo,$tipo_usuario");
	
	if($tipo_usuario == 2){ //// MAESTRO - DIRECTORA
		$result_grados = $ClsAcadem->get_grado_maestro($pensum,$nivel,'',$tipo_codigo);
	}else if($tipo_usuario == 1){
		$result_grados = $ClsAcadem->get_grado_otros_usuarios($pensum,$nivel,'',$tipo_codigo);
	}else if($tipo_usuario == 5){
		$result_grados = $ClsPen->get_grado($pensum,$nivel,'',1);
	}
	
   $contenido = combos_html_onclick($result_grados,$idgra,'gra_codigo','gra_descripcion',$accgra);
	$respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Materia($pensum,$nivel,$grado,$idmat,$idsmat,$accmat){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$idmat,$idsmat,$accmat");
   $contenido = materia_html($pensum,$nivel,$grado,$idmat,$accmat);
   $respuesta->assign($idsmat,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Seccion($pensum,$nivel,$grado,$tipo,$idsec,$idssec,$accsec){
   $respuesta = new xajaxResponse();
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idsec,$idssec,$accsec");
	
	if($tipo_usuario == 2){ //// MAESTRO - DIRECTORA
		$result_secciones = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
	}else if($tipo_usuario == 1){ ////// 
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			$nivel = "";
			$grado = "";
			foreach($result as $row){
				$nivel.= $row["gra_nivel"].",";
				$grado.= $row["gra_codigo"].",";
			}
			$nivel = substr($nivel, 0, -1);
			$grado = substr($grado, 0, -1);
		}
		$result_secciones = $ClsPen->get_seccion_IN($pensum,$nivel,$grado,'','',1);
	}if($tipo_usuario == 5){
		$result_secciones = $ClsPen->get_seccion($pensum,$nivel,$grado,'','',1);
	}else{
		$valida == "";
	}
	
   $contenido = combos_html_onclick($result_secciones,$idsec,'sec_codigo','sec_descripcion',$accsec);
   $respuesta->assign($idssec,"innerHTML",$contenido);
	
	return $respuesta;
}

function Grado_Materia_Seccion($pensum,$nivel,$grado,$tipo,$idmat,$idsmat,$idsec,$idssec,$accmat,$accsec){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idmat,$idsmat,$idsec,$idssec,$accmat,$accsec");
   $contenido1 = seccion_html($pensum,$nivel,$grado,$tipo,$idsec,$accsec);
	$contenido2 = materia_html($pensum,$nivel,$grado,$idmat,$accmat);
   $respuesta->assign($idssec,"innerHTML",$contenido1);
	$respuesta->assign($idsmat,"innerHTML",$contenido2);
	
	return $respuesta;
}


function Materia_Parcial($pensum,$nivel,$grado,$materia,$idpar,$idspar,$accpar){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$materia,$idpar,$idspar,$accpar");
   $contenido = parcial_html($pensum,$nivel,$grado,$materia,$idpar,$accpar);
   $respuesta->assign($idspar,"innerHTML",$contenido);
	
	return $respuesta;
}

function Seccion_Materia_Lista($pensum,$nivel,$grado,$seccion,$idmat,$idsmat,$titulo){
   $respuesta = new xajaxResponse();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	if($tipo_usuario == 2){ //// MAESTRO
		$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'',$tipo_codigo);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'','');
	}if($tipo_usuario == 5){ /// ADMINISTRADOR
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
	}
	
	if(is_array($result_materias)){
		if($tipo_usuario == 2){ //// MAESTRO - DIRECTORA
			$lista_materia = lista_multiple_html($result_materias,$idmat,'secmat_materia','materia_descripcion',$titulo);
		}else if($tipo_usuario == 1){
			$lista_materia = lista_multiple_html($result_materias,$idmat,'mat_codigo','mat_descripcion',$titulo);
		}else if($tipo_usuario == 5){
			$lista_materia = lista_multiple_html($result_materias,$idmat,'mat_codigo','mat_descripcion',$titulo);
		}
	}else{
		$lista_materia = lista_multiple_vacia($idmat,$titulo);
	}
	
	//$respuesta->alert("$pensum,$nivel,$grado,$idmat,$idsmat,$accmat");
   $respuesta->assign($idsmat,"innerHTML",$lista_materia);
	
	return $respuesta;
}

//////////////////---- PENSUM -----/////////////////////////////////////////////
function Importar_Pensum($pensum_viejo,$desc,$anio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
   //--
   $desc = utf8_encode($desc);
   $desc = utf8_decode($desc);
   //--
   if($pensum_viejo != "" && $desc != "" && $anio != ""){
      $pensum_nuevo = $ClsPen->max_pensum();
      $pensum_nuevo++;
      $sql.= $ClsPen->insert_pensum($pensum_nuevo,$desc,$anio);
      
      //---Niveles
      $result = $ClsPen->get_nivel($pensum_viejo,$nivel,$sit);
      if(is_array($result)){
         foreach($result as $row){
            $codigo = $row["niv_codigo"];
            $desc = utf8_decode($row["niv_descripcion"]);
            $sql.= $ClsPen->insert_nivel($pensum_nuevo,$codigo,$desc);
         }	
      }
		 
      //---Grados
      $result = $ClsPen->get_grado($pensum_viejo,'','');
      if(is_array($result)){
         foreach($result as $row){
            $nivel = $row["gra_nivel"];
            $codigo = $row["gra_codigo"];
            $desc = utf8_decode($row["gra_descripcion"]);
            $sql.= $ClsPen->insert_grado($pensum_nuevo,$nivel,$codigo,$desc);
         }
      }
      
     //---Secciones
     $result = $ClsPen->get_seccion($pensum_viejo,'','','','',1);
      if(is_array($result)){
         foreach($result as $row){
            $nivel = $row["sec_nivel"];
            $grado = $row["sec_grado"];
            $codigo = $row["sec_codigo"];
            $tipo = $row["sec_tipo"];
            $desc = utf8_decode($row["sec_descripcion"]);
            $sql.= $ClsPen->insert_seccion($pensum_nuevo,$nivel,$grado,$codigo,$tipo,$desc);
         }
      }
      
      //---Materias
      $result = $ClsPen->get_materia($pensum_viejo,'','','','',1);
      if(is_array($result)){
         foreach($result as $row){
            $nivel = $row["mat_nivel"];
            $grado = $row["mat_grado"];
            $codigo = $row["mat_codigo"];
            $tipo = $row["mat_tipo"];
            $cate = $row["mat_categoria"];
            $orden = $row["mat_orden"];
            $desc = utf8_decode($row["mat_descripcion"]);
            $dct = utf8_decode($row["mat_desc_ct"]);
            $sql.= $ClsPen->insert_materia($pensum_nuevo,$nivel,$grado,$codigo,$tipo,$cate,$orden,$desc,$dct);
         }
      }
		
		$rs = $ClsPen->exec_sql($sql);
		//$respuesta->alert($sql2);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n....", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Grabar_Pensum($desc,$anio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$desc,$anio");
   //--
   $desc = utf8_encode($desc);
   $desc = utf8_decode($desc);
   //--
   if($desc != "" && $anio != ""){
      $codigo = $ClsPen->max_pensum();
      $codigo++;
      $sql = $ClsPen->insert_pensum($codigo,$desc,$anio);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }	
			
	}
   return $respuesta;
}


function Modificar_Pensum($codigo,$desc,$anio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$desc,$anio");
   //--
   $desc = utf8_encode($desc);
   $desc = utf8_decode($desc);
   //--
   if($desc != "" && $anio != ""){
      $sql = $ClsPen->modifica_pensum($codigo,$desc,$anio);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      }	
			
	}
   return $respuesta;
}


function Buscar_Pensum($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$codigo");
   $result = $ClsPen->get_pensum($codigo);
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["pen_codigo"];
         $respuesta->assign("cod","value",$codigo);
         $desc = utf8_decode($row["pen_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $anio = $row["pen_anio"];
         $respuesta->assign("anio","value",$anio);
      }	
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
      
      $contenido = tabla_pensum($codigo,$anio,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Status_Pensum($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
      //$respuesta->alert("$codigo,$sit");
      $sql = $ClsPen->cambia_pensum_activo($codigo);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Pensum activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
      //$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


function CambiaSit_Pensum($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
      //$respuesta->alert("$codigo,$sit");
      $sql = $ClsPen->cambia_sit_pensum($codigo,0);
      $sql.= $ClsPen->cambia_sit_todos_nivel($codigo,0);
      $sql.= $ClsPen->cambia_sit_todos_grado($codigo,0);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Pensum deshabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
      //$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//////////////////---- NIVEL -----/////////////////////////////////////////////
function Grabar_Nivel($pensum,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$desc");
   
   if($desc != ""){
      $codigo = $ClsPen->max_nivel($pensum);
      $codigo++;
      $sql = $ClsPen->insert_nivel($pensum,$codigo,$desc);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }	
	}
   return $respuesta;
}


function Modificar_Nivel($pensum,$codigo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$codigo,$desc");
   if($desc != ""){
      $sql = $ClsPen->modifica_nivel($pensum,$codigo,$desc);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      }	
			
	}
   return $respuesta;
}


function Buscar_Nivel($pensum,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$codigo");
   $result = $ClsPen->get_nivel($pensum,$codigo);
   if(is_array($result)){
      foreach($result as $row){
         $pensum = $row["niv_pensum"];
         $respuesta->assign("pensum","value",$pensum);
         $codigo = $row["niv_codigo"];
         $respuesta->assign("cod","value",$codigo);
         $desc = utf8_decode($row["niv_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }	
      $contenido = nivel_html($pensum,"nivel","");
      $respuesta->assign("divnivel","innerHTML",$contenido);
      $respuesta->assign("nivel","value",$nivel);
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
      
      $contenido = tabla_niveles($pensum,$nivel,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
   }	
    return $respuesta;
}



function CambiaSit_Nivel($pensum,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
	   //$respuesta->alert("$pensum,$codigo");
		$sql.= $ClsPen->cambia_sit_nivel($pensum,$codigo,0);
		$rs = $ClsPen->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Nivel deshabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//////////////////---- GRADO -----/////////////////////////////////////////////
function Grabar_Grado($pensum,$nivel,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$desc");
   
   if($desc != ""){
      $codigo = $ClsPen->max_grado($pensum,$nivel);
      $codigo++;
      $sql = $ClsPen->insert_grado($pensum,$nivel,$codigo,$desc);
      
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }	
	}
   return $respuesta;
}


function Modificar_Grado($pensum,$nivel,$codigo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$codigo,$desc");
   
   if($desc != ""){
      $sql = $ClsPen->modifica_grado($pensum,$nivel,$codigo,$desc);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      }	
			
	}
   return $respuesta;
}


function Buscar_Grado($pensum,$nivel,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$codigo");
   $result = $ClsPen->get_grado($pensum,$nivel,$codigo);
   if(is_array($result)){
      foreach($result as $row){
         $pensum = $row["gra_pensum"];
         $respuesta->assign("pensum","value",$pensum);
         $nivel = $row["gra_nivel"];
         $codigo = $row["gra_codigo"];
         $respuesta->assign("cod","value",$codigo);
         $desc = utf8_decode($row["gra_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }	
      $contenido = nivel_html($pensum,"nivel","");
      $respuesta->assign("divnivel","innerHTML",$contenido);
      $respuesta->assign("nivel","value",$nivel);
      $contenido = grado_html($pensum,$nivel,"grado","");
      $respuesta->assign("divgrado","innerHTML",$contenido);
      $respuesta->assign("grado","value",$grado);
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
      
      $contenido = tabla_grados($pensum,$nivel,$grado,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
   }	
    return $respuesta;
}



function CambiaSit_Grado($pensum,$nivel,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
		$sql.= $ClsPen->cambia_sit_grado($pensum,$nivel,$codigo,0);
		$rs = $ClsPen->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Grado deshabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

//////////////////---- SECCIONES -----/////////////////////////////////////////////
function Grabar_Seccion($pensum,$nivel,$grado,$tipo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$desc");
   
   if($desc != "" && $tipo != ""){
      $codigo = $ClsPen->max_seccion($pensum,$nivel,$grado);
      $codigo++;
      $sql = $ClsPen->insert_seccion($pensum,$nivel,$grado,$codigo,$tipo,$desc);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql); 
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }	
			
	}
   return $respuesta;
}


function Modificar_Seccion($pensum,$nivel,$grado,$codigo,$tipo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$grado,$codigo,$tipo,$desc");
   
   if($desc != "" && $tipo != ""){
      $sql = $ClsPen->modifica_seccion($pensum,$nivel,$grado,$codigo,$tipo,$desc);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      }	
	}
   return $respuesta;
}


function Buscar_Seccion($pensum,$nivel,$grado,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   //$respuesta->alert("$pensum,$nivel,$grado,$codigo");
   $result = $ClsPen->get_seccion($pensum,$nivel,$grado,$codigo);
   if(is_array($result)){
      foreach($result as $row){
         $pensum = $row["sec_pensum"];
         $respuesta->assign("pensum","value",$pensum);
         $grado = $row["sec_grado"];
         $nivel = $row["sec_nivel"];
         $codigo = $row["sec_codigo"];
         $respuesta->assign("cod","value",$codigo);
         $desc = utf8_decode($row["sec_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $tipo = $row["sec_tipo"];
         $respuesta->assign("tipo","value",$tipo);
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
      
      $contenido = tabla_secciones($pensum,$nivel,$grado,$tipo,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
   }	
    return $respuesta;
}



function CambiaSit_Seccion($pensum,$nivel,$grado,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
		$sql.= $ClsPen->cambia_sit_seccion($pensum,$nivel,$grado,$codigo,0);
		$rs = $ClsPen->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Secci\u00F3n deshabilitada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//////////////////---- ASIGNACION DE GRADOS -----/////////////////////////////////////////////

function Grabar_Grado_Alumno($pensum,$nivel,$grado,$alumno,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$grado,$alumno");
   
   if($pensum != "" && $nivel != "" && $grado != "" && $alumno != ""){
      $codigo = $ClsAcad->max_grado_alumno($pensum,$nivel,$grado,$alumno);
      $codigo++;
      $sql = $ClsAcad->delete_grado_alumno($pensum,$nivel,$alumno);
      $sql.= $ClsAcad->insert_grado_alumno($pensum,$nivel,$grado,$codigo,$alumno);
      $rs = $ClsAcad->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
         $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Grado ya Asignada al Alumno';");
         $respuesta->assign("codigo$fila","value",$codigo);
         $respuesta->assign("gradoold$fila","value",$grado);
      }else{
         $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
         $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
         $respuesta->assign("grado$fila","value","");
      }	
	}
   return $respuesta;
}



function Eliminar_Grado_Alumno($pensum,$nivel,$alumno,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$alumno,$fila");
   
   if($pensum != "" && $nivel != "" && $alumno != ""){
      $sql = $ClsAcad->delete_grado_alumno($pensum,$nivel,$alumno);
      $rs = $ClsAcad->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->assign("spancheck$fila","innerHTML",'');
         $respuesta->script("document.getElementById('spancheck$fila').className = '';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Grado ya Asignada al Alumno';");
         $respuesta->assign("codigo$fila","value","");
         $respuesta->assign("gradoold$fila","value","");
      }else{
         $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
         $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la reasignación. Intente de nuevo';");
         $respuesta->assign("grado$fila","value","");
      }	
	}
   return $respuesta;
}



//////////////////---- ASIGNACION DE SECCIONES -----/////////////////////////////////////////////

function Grabar_Seccion_Alumno($pensum,$nivel,$grado,$seccion,$alumno,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$alumno,$fila");
   
   if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $alumno != ""){
      $codigo = $ClsAcad->max_seccion_alumno($pensum,$nivel,$grado,$seccion,$alumno);
      $codigo++;
      $sql = $ClsAcad->delete_seccion_alumno($pensum,$alumno);
      $sql.= $ClsAcad->insert_seccion_alumno($pensum,$nivel,$grado,$seccion,$codigo,$alumno);
      $rs = $ClsAcad->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
         $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Sección ya Asignada al Alumno';");
         $respuesta->assign("codigo$fila","value",$codigo);
         $respuesta->assign("seccionold$fila","value",$seccion);
      }else{
         $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
         $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
         $respuesta->assign("seccion$fila","value","");
      }	
	}
   return $respuesta;
}



function Eliminar_Seccion_Alumno($pensum,$nivel,$grado,$alumno,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$pensum,$nivel,$grado,$alumno,$fila");
   
   if($pensum != "" && $nivel != "" && $grado != "" && $alumno != ""){
      $sql = $ClsAcad->delete_seccion_alumno($pensum,$alumno);
      $rs = $ClsAcad->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->assign("spancheck$fila","innerHTML",'');
         $respuesta->script("document.getElementById('spancheck$fila').className = '';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Secci&oacute;n ya Asignada al Alumno';");
         $respuesta->assign("codigo$fila","value","");
         $respuesta->assign("seccionold$fila","value","");
      }else{
         $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
         $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
         $respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la reasignación. Intente de nuevo';");
         $respuesta->assign("seccion$fila","value","");
      }	
	}
   return $respuesta;
}

//////////////////////visualización notas-----------------------------------
function Status_Nota($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
       $sit = 1;
      //$respuesta->alert("$codigo,$sit");
      $sql = $ClsPen->cambia_sit_notas($codigo,$sit);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Visualizaci\u00F3n de notas activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
      //$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

function quitar_Nota($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPen = new ClsPensum();
   if($codigo != ""){
       $sit = 0;
      //$respuesta->alert("$codigo,$sit");
      $sql = $ClsPen->cambia_sit_notas($codigo,$sit);
      $rs = $ClsPen->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Visualizaci\u00F3n de notas Inhabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
      //$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- VARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia");
$xajax->register(XAJAX_FUNCTION, "Grado_Seccion");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia_Seccion");
$xajax->register(XAJAX_FUNCTION, "Materia_Parcial");
$xajax->register(XAJAX_FUNCTION, "Seccion_Materia_Lista");
//////////////////---- PENSUM -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Importar_Pensum");
$xajax->register(XAJAX_FUNCTION, "Grabar_Pensum");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pensum");
$xajax->register(XAJAX_FUNCTION, "Buscar_Pensum");
$xajax->register(XAJAX_FUNCTION, "Status_Pensum");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Pensum");
//////////////////---- NIVELES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Nivel");
$xajax->register(XAJAX_FUNCTION, "Modificar_Nivel");
$xajax->register(XAJAX_FUNCTION, "Buscar_Nivel");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Nivel");
//////////////////---- GRADO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grado");
$xajax->register(XAJAX_FUNCTION, "Modificar_Grado");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grado");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Grado");
//////////////////---- SECCIONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Seccion");
$xajax->register(XAJAX_FUNCTION, "Modificar_Seccion");
$xajax->register(XAJAX_FUNCTION, "Buscar_Seccion");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Seccion");
//////////////////---- ASIGNACION DE GRADOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grado_Alumno");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Grado_Alumno");
//////////////////---- ASIGNACION DE SECCIONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Seccion_Alumno");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Seccion_Alumno");

//$xajax->register(XAJAX_FUNCTION, "Asignacion_Seccion");
//////////////////----  Visualizacion de notas -----///////////////////////////
$xajax->register(XAJAX_FUNCTION, "Status_Nota");
$xajax->register(XAJAX_FUNCTION, "quitar_Nota");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  