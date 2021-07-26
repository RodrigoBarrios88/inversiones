<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_examen.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- RESPUESTAS -----/////////////////////////////////////////////

function Grabar_Respuesta_Materias($examen,$pregunta,$persona,$tipo,$ponderacion,$texto,$feclimit,$puntos){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();

	if($examen != "" && $pregunta != "" && $persona != "" && $tipo != "" && $ponderacion != "" && $feclimit != ""){
		$feclimit = strtotime($feclimit);
		$fecahora = strtotime(date("Y-m-d H:i:s",time()));
		if(($fecahora < $feclimit)){
			$sql = $ClsExa->insert_respuesta($examen,$pregunta,$persona,$tipo,$ponderacion,$texto,$puntos);
			$rs = $ClsExa->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				return $respuesta;
			}else{
				$respuesta->Script("abrir();");
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}else{
			$respuesta->Script('document.getElementById("btnfin").setAttribute("disabled","disabled");');
			$respuesta->Script("abrir();");
			$msj = '<h5>El tiempo de ex&aacute;men ha finalizado! se presentar&aacute;n las preguntas resueltas hasta el momento...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "FinalizarExamen($jrepetir ,$jacalificar);" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}

	return $respuesta;
}


function Grabar_Respuesta_Cursos($examen,$pregunta,$persona,$tipo,$ponderacion,$texto,$feclimit){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();

	if($examen != "" && $pregunta != "" && $persona != "" && $tipo != "" && $ponderacion != "" && $feclimit != ""){
		$feclimit = strtotime($feclimit);
		$fecahora = strtotime(date("Y-m-d H:i:s",time()));
		if(($fecahora < $feclimit)){
			$sql = $ClsExa->insert_respuesta_curso($examen,$pregunta,$persona,$tipo,$ponderacion,$texto);
			$rs = $ClsExa->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				return $respuesta;
			}else{
				$respuesta->Script("abrir();");
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}else{
			$respuesta->Script('document.getElementById("btnfin").setAttribute("disabled","disabled");');
			$respuesta->Script("abrir();");
			$msj = '<h5>El tiempo de ex&aacute;men ha finalizado! se presentar&aacute;n las preguntas resueltas hasta el momento...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}

	return $respuesta;
}


function Finalizar_Examen_Materias($examen,$persona,$feclimit,$repetir,$acalificar){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
   $puntos_obtenidos = $ClsExa->get_examen_sumatoria_preguntas($examen,$persona);
   $puntos_total = $ClsExa->get_examen_sumatoria_preguntas2($examen);
  // $respuesta->alert("$repetir");
   if($examen != "" && $persona != "" && $feclimit != ""){
		$feclimit = strtotime($feclimit);
		$fecahora = strtotime(date("Y-m-d H:i:s",time()));
		if(($fecahora < $feclimit)){
			$sql = $ClsExa->cambiar_sit_det_examen($examen,$persona,2);
			$sql.= $ClsExa->modifica_det_examen($examen,$persona,$puntos_obtenidos,'');
			$sql.= $ClsExa->fin_examen($examen,$persona);
			$rs = $ClsExa->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
			//	$respuesta->alert("$acalificar");
				if($acalificar == 1 && $repetir == 1){
					$respuesta->script('swal({
						text: "Felicitaciones!, Tu Puntuaci\u00F3n es: '.$puntos_obtenidos.'/ '.$puntos_total.' Puntos!",
						icon: "success",
						buttons: {
							repetir: { text: "Reintentar", value: 1},
							finalizar: { text: "Finalizar", value: 2},
						}
					}).then((value) => {
						switch (value) {
							case 1:
								window.location.reload();
								break;
							case 2:
								alert("Puedes Repetir el Examen!");
								window.location.href="FRMexamen_materias.php";
								break;
							default:
								  return;
						}
					});');
				}elseif($acalificar == 2 && $repetir == 1){
						$respuesta->script('swal({
							text: "Felicitaciones!, Respuesta enviada para calificaci\u00F3n ...",
							icon: "success",
							buttons: {
								repetir: { text: "Reintentar", value: 1},
								finalizar: { text: "Finalizar", value: 2},
							}
						}).then((value) => {
							switch (value) {
								case 1:
									window.location.reload();
									break;
								case 2:
									alert("Puedes Repetir el Examen!");
									window.location.href="FRMexamen_materias.php";
									break;
								default:
									  return;
							}
						});');
				}elseif($acalificar == 1 && $repetir == 2){
					 	$respuesta->script('swal("Felicitaciones!", "Tu Puntuaci\u00F3n es: '.$puntos_obtenidos.'/ '.$puntos_total.' Puntos!", "success").then((value)=>{ window.location.href="FRMexamen_materias.php"; });');
				}else{
					$respuesta->script('swal("Felicitaciones!", "Respuesta enviada para calificaci\u00F3n...", "success").then((value)=>{ window.location.href="FRMexamen_materias.php"; });');
				}
				
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}else{
			$respuesta->Script('document.getElementById("btnfin").setAttribute("disabled","disabled");');
			$respuesta->script('swal("Tiempo Finalizado", "El tiempo de examen ha finalizado! se presentar\u00F3n las preguntas resueltas hasta el momento...", "info").then((value)=>{ window.location.reload(); });');
		}
	}

	return $respuesta;
}


function Finalizar_Examen_Cursos($examen,$persona,$feclimit){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();

   //$respuesta->alert("$cod");
   if($examen != "" && $persona != "" && $feclimit != ""){
		$feclimit = strtotime($feclimit);
		$fecahora = strtotime(date("Y-m-d H:i:s",time()));
		if(($fecahora < $feclimit)){
			$sql = $ClsExa->cambiar_sit_det_examen_curso($examen,$persona,2);
			$rs = $ClsExa->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$respuesta->script('swal("Felicitaciones!", "Respuesta enviada para calificaci\u00F3n...", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}else{
			$respuesta->Script('document.getElementById("btnfin").setAttribute("disabled","disabled");');
			$respuesta->script('swal("Tiempo Finalizado", "El tiempo de examen ha finalizado! se presentar\u00F3n las preguntas resueltas hasta el momento...", "info").then((value)=>{ window.location.reload(); });');
		}
	}

	return $respuesta;
}

function resolucion_examen_materias_1($examen,$alumno){
     $respuesta = new xajaxResponse();
        $ClsExa = new ClsExamen();
     	$sql = $ClsExa->inicio_examen($examen,$alumno);
     	$rs = $ClsExa->exec_sql($sql);
     	$respuesta->alert("$sql");
}


//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////

function Delete_Archivo_Materias($codigo,$examen,$alumno,$archivo){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	if($codigo != "" && $examen != ""){
     	$sql = $ClsExa->delete_resolucion_examen_archivo($codigo,$examen,$alumno);
		$rs = $ClsExa->exec_sql($sql);
      if($rs == 1){
         if(file_exists("../../CONFIG/DATALMSALUMNOS/TEST/MATERIAS/$archivo")){
            unlink("../../CONFIG/DATALMSALUMNOS/TEST/MATERIAS/$archivo");
         }
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   } 
   
   return $respuesta;
}


function Delete_Archivo_Cursos($codigo,$examen,$alumno,$archivo){
   $respuesta = new xajaxResponse();
   $ClsExa = new ClsExamen();
	
	if($codigo != "" && $examen != ""){
     	$sql = $ClsExa->delete_resolucion_examen_archivo_curso($codigo,$examen,$alumno);
		$rs = $ClsExa->exec_sql($sql);
      if($rs == 1){
         if(file_exists("../../CONFIG/DATALMSALUMNOS/TEST/CURSOS/$archivo")){
            unlink("../../CONFIG/DATALMSALUMNOS/TEST/CURSOS/$archivo");
         }
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


//////////////////---- RESPUESTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Respuesta_Materias");
$xajax->register(XAJAX_FUNCTION, "Grabar_Respuesta_Cursos");
$xajax->register(XAJAX_FUNCTION, "Finalizar_Examen_Materias");
$xajax->register(XAJAX_FUNCTION, "Finalizar_Examen_Cursos");

$xajax->register(XAJAX_FUNCTION, "resolucion_examen_materias_1");
//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo_Materias");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo_Cursos");

//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  