<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_notas.php");

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
							  
	//$respuesta->alert("$result_grados");
   
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

//////////////////---- ASIGNACION DE NOTAS DE AlumnoS -----/////////////////////////////////////////////

function Asignar_Nota_Alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad,$zona,$nota,$seccion,$tipo_calificacion,$fila,$cantidadtotal){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   //$respuesta->alert("$zona,$nota,$fila");
   
   if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $unidad != "" && $alumno != ""){
		if($zona != "" || $nota != ""){
			$zona = ($zona == "")?0:$zona;
			$nota = ($nota == "")?0:$nota;
         $sql = $ClsNot->insert_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad,$zona,$nota,$seccion,$tipo_calificacion,$cantidadtotal);
		}else{
			$sql = $ClsNot->delete_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad);
			$bandera = true;
		}	
		 
		$rs = $ClsNot->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         if($bandera == false){
            $totalporcen = ($zona + $nota);
            $totalp = 100 * $totalporcen / $cantidadtotal ;
            $total = round($totalp);
            $respuesta->assign("total$fila","value",$total);
            $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
            $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
            $respuesta->script("document.getElementById('spancheck$fila').title = 'Nota Asignada...';");
         }else{
            $respuesta->assign("spancheck$fila","innerHTML",'');
            $respuesta->script("document.getElementById('spancheck$fila').className = '';");
            $respuesta->script("document.getElementById('spancheck$fila').title = '...';");
         }
      }else{
        $respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
        $respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
        $respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
        $respuesta->assign("nota$fila","value","");
      }	
			
	}
   return $respuesta;
}


function Modificar_Nota_Alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad,$zonaold,$notaold,$totalold,$zona,$nota,$justificacion){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   //$respuesta->alert("$zona,$nota,$fila");
   $justificacion = trim($justificacion);
   $justificacion = utf8_encode($justificacion);
   $justificacion = utf8_decode($justificacion);
   
   if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $unidad != "" && $alumno != ""){
      $modificacion = $ClsNot->max_modificacion();
      $modificacion++;
		if($zona != "" || $nota != ""){
			$zona = ($zona == "")?0:$zona;
			$nota = ($nota == "")?0:$nota;
			$sql = $ClsNot->modifica_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad,$zona,$nota);
			$sql.= $ClsNot->insert_modificacion_nota($modificacion,$alumno,$pensum,$nivel,$grado,$materia,$unidad,$zonaold,$notaold,$totalold,$justificacion);
		}else{
			$sql = $ClsNot->delete_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad);
         $sql.= $ClsNot->insert_modificacion_nota($modificacion,$alumno,$pensum,$nivel,$grado,$materia,$unidad,$zonaold,$notaold,$totalold,$justificacion);
			$bandera = true;
		}	
		 
		$rs = $ClsNot->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         if($bandera == false){
            $total = ($zona + $nota);
            $respuesta->script('swal("Excelente!", "Modificaci\u00F3n de notas realizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Excelente!", "Modificaci\u00F3n de notas realizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }
      }else{
        $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
			
	}
   return $respuesta;
}


function Certificar_Nota_Alumno($pensum,$nivel,$grado,$seccion,$materia,$unidad){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   //$respuesta->alert("$zona,$nota,$fila");
   
   if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $unidad != "" && $seccion != ""){
		$sql = $ClsNot->certificar_notas_alumno($pensum,$nivel,$grado,$seccion,$materia,$unidad);
		$rs = $ClsNot->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Certificaci\u00F3n de notas realizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   return $respuesta;
}

//////////////////---- ASIGNACION DE NOTAS DE RECUPERACION A AlumnoS -----/////////////////////////////////////////////


function Asignar_Nota_Alumno_Recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion,$zona,$nota,$seccion,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcad = new ClsAcademico();
   //$respuesta->alert("$alumno,$pensum,$nivel,$grado,$materia,$unidad,$nota,$seccion,$fila");
   
   if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $recuperacion != "" && $alumno != ""){
		if($nota != ""){
			$result_nota_alumno = $ClsAcad->comprueba_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$recuperacion);  ////// este array se coloca en la columna de combos
			if(is_array($result_nota_alumno)){
				$sql = $ClsAcad->modifica_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion,$zona,$nota);
			}else{
				$sql = $ClsAcad->insert_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion,$zona,$nota,$seccion);		
			}
		}else{
			$sql = $ClsAcad->delete_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion);
			$bandera = true;
		}	
		 
		 $rs = $ClsAcad->exec_sql($sql);
		 //$respuesta->alert($sql);
		 if($rs == 1){
			if($bandera == false){
				$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Nota Asignada...';");
			}else{
				$respuesta->assign("spancheck$fila","innerHTML",'');
				$respuesta->script("document.getElementById('spancheck$fila').className = '';");
				$respuesta->script("document.getElementById('spancheck$fila').title = '...';");
			}
		 }else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
		 	$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
		 	$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
			$respuesta->assign("nota$fila","value","");
		 }	
			
	}
   return $respuesta;
}


//////////////////---- PUBLICAR NOMINAS -----/////////////////////////////////////////////

function Grado_Nomina_Lista($pensum,$nivel,$grado,$tipo,$sit,$idnom,$idsnom){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$sit,$idnom,$idsnom");
    $contenido = nomina_lista_html($pensum,$nivel,$grado,$tipo,$sit,$idnom,"");
    $respuesta->assign($idsnom,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Nomina_Recuperacion_Lista($pensum,$nivel,$grado,$recuperacion,$sit,$idnom,$idsnom){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idnom,$idsnom");
    $contenido = nomina_lista_recuperacion_html($pensum,$nivel,$grado,$recuperacion,$sit,$idnom,"");
    $respuesta->assign($idsnom,"innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- UNIDADES -----/////////////////////////////////////////////
function Grabar_Unidad($pensum,$nivel,$descripcion,$porcent){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   //$respuesta->alert("$pensum,$nivel,$desc");
   
   if($descripcion != "" && $porcent != ""){
      $codigo = $ClsNot->max_unidades($pensum,$nivel);
      $codigo++;
      $sql = $ClsNot->insert_unidades($pensum,$nivel,$codigo,$descripcion,$porcent);
      
      $rs = $ClsNot->exec_sql($sql);
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


function Modificar_Unidad($pensum,$nivel,$unidad,$descripcion,$porcent){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   //$respuesta->alert("$pensum,$nivel,$codigo,$desc");
   
   if($descripcion != "" && $porcent != ""){
		$sql = $ClsNot->modifica_unidades($pensum,$nivel,$unidad,$descripcion,$porcent);
		$rs = $ClsNot->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Actualizado guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Buscar_Unidad($pensum,$nivel,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   //$respuesta->alert("$pensum,$nivel,$codigo");
	$result = $ClsNot->get_unidades($pensum,$nivel,$codigo);
	if(is_array($result)){
      foreach($result as $row){
         $pensum = $row["uni_pensum"];
         $respuesta->assign("pensum","value",$pensum);
         $nivel = $row["uni_nivel"];
         $unidad = $row["uni_unidad"];
         $respuesta->assign("cod","value",$unidad);
         $desc = utf8_decode($row["uni_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $porcent = utf8_decode($row["uni_porcentaje"]);
         $respuesta->assign("porcent","value",$porcent);
      }	
      $contenido = nivel_html($pensum,"nivel","");
      $respuesta->assign("divnivel","innerHTML",$contenido);
      $respuesta->assign("nivel","value",$nivel);
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
      
      $contenido = tabla_unidades($pensum,$nivel,$unidad);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
	}
    return $respuesta;
}



function CambiaSit_Unidad($pensum,$nivel,$codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   if($codigo != ""){
	   //$respuesta->alert("$codigo,$sit");
		$sql.= $ClsNot->delete_unidades($pensum,$nivel,$codigo);
		$rs = $ClsNot->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Unidad eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

////////////// COMENTARIO DE NOTAS DE ALUMNOS ////////////

function Grabar_Comentario_Alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial,$comentario){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsNot = new ClsNotas();
   
   if($alumno != "" && $pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $parcial != ""){
		$sql = $ClsNot->insert_comentario_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial,$comentario);
		$rs = $ClsNot->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Comentario registrado satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
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
//////////////////---- ASIGNACION DE NOTAS A ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Asignar_Nota_Alumno");
$xajax->register(XAJAX_FUNCTION, "Modificar_Nota_Alumno");
$xajax->register(XAJAX_FUNCTION, "Certificar_Nota_Alumno");
//////////////////---- ASIGNACION DE NOTAS DE RECUPERACION A ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Nota_Alumno_Recuperacion");
//////////////////---- PUBLICAR NOMINAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grado_Nomina_Lista");
$xajax->register(XAJAX_FUNCTION, "Grado_Nomina_Recuperacion_Lista");
//////////////////---- UNIDADES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Unidad");
$xajax->register(XAJAX_FUNCTION, "Modificar_Unidad");
$xajax->register(XAJAX_FUNCTION, "Buscar_Unidad");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Unidad");
////////////// COMENTARIO DE NOTAS DE ALUMNOS ////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Comentario_Alumno");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  