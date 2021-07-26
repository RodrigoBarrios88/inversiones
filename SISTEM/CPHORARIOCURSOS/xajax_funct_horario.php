<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_horario.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- VARIOS -----/////////////////////////////////////////////

//////////////////---- Tipo de Periodos -----/////////////////////////////////////////////

function Grabar_Tipo_Periodo($curso,$min,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$min,$desc");
	if($desc != ""){
		$cod = $ClsHor->max_tipo_periodo_cursos($curso);
		$cod++;
		$sql = $ClsHor->insert_tipo_periodo_cursos($cod,$curso,$min,$desc);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);

		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}	

   return $respuesta;

}


function Buscar_Tipo_Periodo($cod,$curso){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();
   $cont = $ClsHor->count_tipo_periodo_cursos($cod,$curso);
	//$respuesta->alert("$cod,$curso");
	if($cont>0){
		if($cont==1){
			$result = $ClsHor->get_tipo_periodo_cursos($cod,$curso);
			foreach($result as $row){
				$cod = $row["tip_codigo"];
				$respuesta->assign("cod","value",$cod);
				$curso = $row["tip_curso"];
				$respuesta->assign("curso","value",$curso);
				$desc = utf8_decode($row["tip_descripcion"]);
				$respuesta->assign("desc","value",$desc);
				$min = $row["tip_minutos"];
				$respuesta->assign("min","value",$min);
			}
		}
		//abilita y desabilita botones
		$contenido = tabla_tipo_periodo($cod,$curso,$nom,$min);
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar();");
	}

   return $respuesta;

}


function Modificar_Tipo_Periodo($cod,$curso,$min,$desc){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   //pasa a mayusculas
		$desc = trim($desc);
	//--------

	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$cod,$dia,$desc,$desc,$marca");
    if($cod != ""){
		if($desc != ""){
			$sql = $ClsHor->modifica_tipo_periodo_cursos($cod,$curso,$min,$desc);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


function Situacion_Tipo_Periodo($cod,$curso){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

    //$respuesta->alert("$diap,$min");
    if($cod != ""){
		$activo = $ClsHor->count_periodos_cursos('','',$cod,$curso);
			if($activo > 0){
				$sql = $ClsHor->delete_tipo_periodo_cursos($cod,$curso);
				//$respuesta->alert("$sql");
				$rs = $ClsHor->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Tipo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
			}else{
				$msj = '<h5>Este Tipo tiene Periodos activos, desactivelos primero antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
	}

	return $respuesta;
}

//////////////////---- Periodos -----/////////////////////////////////////////////

function Grabar_Periodo($dia,$tipo,$curso,$hini,$hfin){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

	if($tipo != "" && $dia != ""){
		//$respuesta->alert("$dia,$tipo,$horini,$minini,$horfin,$minfin");
		$cod = $ClsHor->max_periodos_cursos($dia);  
		$cod++;
		$sql = $ClsHor->insert_periodos_cursos($cod,$dia,$tipo,$curso,$hini,$hfin);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}

function Modificar_Periodo($cod,$dia,$tipo,$curso,$hini,$hfin){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

	//$respuesta->alert("$cod,$dia,$tipo,$horini,$minini,$horfin,$minfin");
    if($cod != ""){
		if($tipo != "" && $dia != ""){
			$sql = $ClsHor->modifica_periodos_cursos($cod,$dia,$tipo,$curso,$hini,$hfin);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


function Buscar_Periodo($cod,$dia){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   //$respuesta->alert("$cod");
	$cont = $ClsHor->count_periodos_cursos($cod,$dia);
		if($cont>0){
			if($cont==1){
				$result = $ClsHor->get_periodos_cursos($cod,$dia);
				foreach($result as $row){
					$cod = $row["per_codigo"];
					$respuesta->assign("cod","value",$cod);
					$dia = $row["per_dia"];
					$respuesta->assign("dia","value",$dia);
					$tipo = $row["per_tipo"];
					$respuesta->assign("tipo","value",$tipo);
					$hini = $row["per_hini"];
					$ini = explode(":",$hini);
					$horini = $ini[0];
					$minini = $ini[1];
					$respuesta->assign("ini","value","$horini:$minini");
					$hfin = $row["per_hfin"];
					$fin = explode(":",$hfin);
					$horfin = $fin[0];
					$minfin = $fin[1];
					$respuesta->assign("fin","value","$horfin:$minfin");
				}
			}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
	   	}	
   return $respuesta;
}


function Situacion_Periodo($cod,$dia){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

    //$respuesta->alert("$cod,$dia");
    if($cod != ""){
		$activo = $ClsHor->count_horario_cursos("",$cod,$dia);
		//$respuesta->alert("$activo > 0");
			if($activo > 0){
				$msj = '<h5>Este Tipo tiene Periodos organizados en los horarios activos, Elimine el Horario actual primero antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$sql = $ClsHor->delete_periodos_cursos($cod,$dia);
				//$respuesta->alert("$sql");
				$rs = $ClsHor->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Periodo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
			}
	}

	return $respuesta;
}


function Combo_Tipo_Periodo($dia,$id,$sid,$acc){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$clase");
	$contenido = periodo_html($dia,$id,$acc);
	$respuesta->assign($sid,"innerHTML",$contenido);
	
	return $respuesta;
}



//////////////////---- HORARIO -----/////////////////////////////////////////////

function Grabar_Horario($periodo,$dia,$hini,$curso,$maestro,$aula,$cupo,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($periodo != "" && $dia != "" && $maestro != "" && $aula != "" && $cupo != "" && $fila != ""){
		///-- prepara la hora a comprobar
		$horini = substr($hini, 0, -3);
		
		/////// Valida al Maestro
		$result = $ClsHor->get_horario_cursos('','',$dia,'','','','',$maestro,'');
		if(is_array($result)){
			$contador_maestro = 0;
			foreach($result as $row){
				$hora_ini_maestro = substr($row["per_hini"], 0, -3);
				$hora_fin_maestro = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_maestro) <= strtotime($horini)) && (strtotime($hora_fin_maestro) >= strtotime($horini)))");
				if((strtotime($hora_ini_maestro) <= strtotime($horini)) && (strtotime($hora_fin_maestro) >= strtotime($horini))) {
					$curso_asig_maestro = $row["cur_nombre"];
					$tipo_periodo_maestro = $row["tip_descripcion"];
					$min_maestro = $row["tip_minutos"];
					$contador_maestro++;
					//$respuesta->alert("entro en maestros...");
				}
			}
		}
		/////-------------------
		
		/////// Valida al Aula
		$result = $ClsHor->get_horario_cursos('','',$dia,'','','',$curso,'',$aula);
		if(is_array($result)){
			$contador_aula = 0;
			foreach($result as $row){
				$hora_ini_aula = substr($row["per_hini"], 0, -3);
				$hora_fin_aula = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_aula) <= strtotime($horini)) && (strtotime($hora_fin_aula) >= strtotime($horini)))");
				if((strtotime($hora_ini_aula) <= strtotime($horini)) && (strtotime($hora_fin_aula) >= strtotime($horini))) {
					$curso_asig_aula = $row["cur_nombre"];
					$tipo_periodo_aula = $row["tip_descripcion"];
					$min_aula = $row["tip_minutos"];
					$contador_aula++;
					//$respuesta->alert("entro en aula...");
				}
			}
		}
		/////-------------------
		if(($contador_maestro > 0) || ($contador_aula > 0)){
			$mensaje = "";
			if($contador_maestro > 0){
				$mensaje.= "ESTE MAESTRO YA ESTA ASIGNADO ESTE DIA AL PERIODO $tipo_periodo_maestro EN EL CURSO $curso_asig_maestro, CON DURACI&Oacute;N DE $min_maestro MINUTOS, INICIANDO A LAS $hora_ini_maestro. NO DEBER&Iacute;A DE SER ASIGNADO, PERO A&Uacute;N ASI DESEA ASIGNARLO?...  ";
				$respuesta->script("document.getElementById('maestro$fila').value = '';");
			}
			if($contador_aula > 0){
				$mensaje.= "ESTA INSTALACI&Oacute;N YA ESTA ASIGNADA ESTE DIA AL PERIODO $tipo_periodo_aula PARA EL CURSO $curso_asig_aula, CON DURACI&Oacute;N DE $min_aula MINUTOS, INICIANDO A LAS $hora_ini_aula. NO DEBER&Iacute;A DE SER ASIGNADA, PERO A&Uacute;N ASI DESEA ASIGNARLA?...  ";
				$respuesta->script("document.getElementById('aula$fila').value = '';");
			}
			$respuesta->script("abrir();");
			$msj = '<label>'.$mensaje.'</label><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "xajax_Grabar_Horario_Forzado('.$periodo.','.$dia.',\''.$hini.'\','.$curso.',\''.$maestro.'\','.$aula.','.$fila.');" ><span class="fa fa-check"></span> Aceptar</button> ';
			$msj.= '<button type="button" class="btn btn-danger" onclick = "cerrar();" ><span class="fa fa-times"></span> Cancelar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			
		}else{
			$codigo = $ClsHor->max_horario_cursos();  
			$codigo++;
			$sql = $ClsHor->insert_horario_cursos($codigo,$periodo,$dia,$curso,$maestro,$aula,$cupo);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$respuesta->script("window.location.reload();");
			}else{
				$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
				$respuesta->assign("codigo$fila","value","");
				$respuesta->assign("existe$fila","value","");
				$respuesta->assign("maestro$fila","value","");
				$respuesta->assign("aula$fila","value","");
			 }	
		}
   }
   		
   return $respuesta;
}


function Modificar_Horario($codigo,$periodo,$dia,$hini,$curso,$maestro,$aula,$cupo,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($codigo != "" && $periodo != "" && $dia != "" && $maestro != "" && $aula != "" && $cupo != "" && $fila != ""){
		///-- prepara la hora a comprobar
		$hini = substr($hini, 0, -3);
		
		/////// Valida al Maestro
		$result = $ClsHor->get_horario_cursos('','',$dia,'','','','',$maestro,'');
		if(is_array($result)){
			$contador_maestro = 0;
			foreach($result as $row){
				$codigo_maestro = $row["hor_codigo"];
				$hora_ini_maestro = substr($row["per_hini"], 0, -3);
				$hora_fin_maestro = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_maestro) <= strtotime($hini)) && (strtotime($hora_fin_maestro) >= strtotime($hini)))");
				if((strtotime($hora_ini_maestro) <= strtotime($hini)) && (strtotime($hora_fin_maestro) >= strtotime($hini)) && ($codigo_maestro != $codigo)) {
					$curso_asig_maestro = $row["cur_nombre"];
					$tipo_periodo_maestro = $row["tip_descripcion"];
					$min_maestro = $row["tip_minutos"];
					$contador_maestro++;
					//$respuesta->alert("entro en maestros...");
				}
			}
		}
		/////-------------------
		
		/////// Valida al Aula
		$result = $ClsHor->get_horario_cursos('','',$dia,'','','',$curso,'',$aula);
		if(is_array($result)){
			$contador_aula = 0;
			foreach($result as $row){
				$codigo_aula = $row["hor_codigo"];
				$hora_ini_aula = substr($row["per_hini"], 0, -3);
				$hora_fin_aula = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_aula) <= strtotime($hini)) && (strtotime($hora_fin_aula) >= strtotime($hini)))");
				if((strtotime($hora_ini_aula) <= strtotime($hini)) && (strtotime($hora_fin_aula) >= strtotime($hini)) && ($codigo_aula != $codigo)) {
					$curso_asig_aula = $row["cur_nombre"];
					$tipo_periodo_aula = $row["tip_descripcion"];
					$min_aula = $row["tip_minutos"];
					$contador_aula++;
					//$respuesta->alert("entro en aula...");
				}
			}
		}
		/////-------------------
		if(($contador_maestro > 0) || ($contador_aula > 0)){
			$mensaje = "";
			if($contador_maestro > 0){
				$mensaje.= "ESTE MAESTRO YA ESTA ASIGNADO ESTE DIA AL PERIODO $tipo_periodo_maestro EN EL CURSO $curso_asig_maestro, CON DURACI&Oacute;N DE $min_maestro MINUTOS, INICIANDO A LAS $hora_ini_maestro. NO DEBER&Iacute;A DE SER ASIGNADO, PERO A&Uacute;N ASI DESEA ASIGNARLO?...  ";
				$respuesta->script("document.getElementById('maestro$fila').value = '';");
			}
			if($contador_aula > 0){
				$mensaje.= "ESTA INSTALACI&Oacute;N YA ESTA ASIGNADA ESTE DIA AL PERIODO $tipo_periodo_aula PARA EL CURSO $curso_asig_aula, CON DURACI&Oacute;N DE $min_aula MINUTOS, INICIANDO A LAS $hora_ini_aula. NO DEBER&Iacute;A DE SER ASIGNADA, PERO A&Uacute;N ASI DESEA ASIGNARLA?...  ";
				$respuesta->script("document.getElementById('aula$fila').value = '';");
			}
			
			$respuesta->script("abrir();");
			$msj = '<label>'.$mensaje.'</label><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "xajax_Modificar_Horario_Forzado('.$codigo.','.$periodo.','.$dia.',\''.$hini.'\','.$curso.',\''.$maestro.'\','.$aula.','.$fila.');" ><span class="fa fa-check"></span> Aceptar</button> ';
			$msj.= '<button type="button" class="btn btn-danger" onclick = "cerrar();" ><span class="fa fa-times"></span> Cancelar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			
		}else{
			$sql = $ClsHor->modifica_horario_cursos($codigo,$periodo,$dia,$curso,$maestro,$aula,$cupo);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$respuesta->script("window.location.reload();");
			}else{
				$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
				$respuesta->assign("maestro$fila","value","");
				$respuesta->assign("aula$fila","value","");
			 }
		}
   }
   		
   return $respuesta;
}





function Grabar_Horario_Forzado($periodo,$dia,$hini,$curso,$maestro,$aula,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($periodo != "" && $dia != "" && $maestro != "" && $aula != "" && $fila != ""){
		$codigo = $ClsHor->max_horario_cursos();  
		$codigo++;
		$sql = $ClsHor->insert_horario_cursos($codigo,$periodo,$dia,$curso,$maestro,$aula);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->script("window.location.reload();");
		}else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
			$respuesta->assign("codigo$fila","value","");
			$respuesta->assign("existe$fila","value","");
			$respuesta->assign("maestro$fila","value","");
			$respuesta->assign("aula$fila","value","");
		}	
   }
   		
   return $respuesta;
}


function Modificar_Horario_Forzado($codigo,$periodo,$dia,$hini,$curso,$maestro,$aula,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($codigo != "" && $periodo != "" && $dia != "" && $maestro != "" && $aula != "" && $fila != ""){
		$sql = $ClsHor->modifica_horario_cursos($codigo,$periodo,$dia,$curso,$maestro,$aula);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->script("window.location.reload();");
		}else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
			$respuesta->assign("maestro$fila","value","");
			$respuesta->assign("aula$fila","value","");
		}
	}
	
   return $respuesta;
}



function Eliminar_Horario($codigo,$fila){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();
	 //$respuesta->alert("$codigo,$fila");
	 
		$sql = $ClsHor->delete_horario_cursos($codigo);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			//oculta la alerta verde
			$respuesta->assign("spancheck$fila","innerHTML",'');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-default btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Horario ya programado';");
			//limpia campos
			$respuesta->assign("existe$fila","value","0");
			$respuesta->assign("codigo$fila","value","");
			$respuesta->assign("maestro$fila","value","");
			$respuesta->assign("aula$fila","value","");
		}else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
		}
		
		$respuesta->script("cerrar();");
		
	return $respuesta;
}

//////////////////---- VARIOS -----/////////////////////////////////////////////

//////////////////---- Tipo de Periodos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tipo_Periodo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tipo_Periodo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tipo_Periodo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Tipo_Periodo");
//////////////////---- Periodos -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Periodo");
$xajax->register(XAJAX_FUNCTION, "Combo_Tipo_Periodo");
//////////////////---- HORAIRO -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Horario");
$xajax->register(XAJAX_FUNCTION, "Modificar_Horario");
$xajax->register(XAJAX_FUNCTION, "Grabar_Horario_Forzado");
$xajax->register(XAJAX_FUNCTION, "Modificar_Horario_Forzado");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Horario");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  