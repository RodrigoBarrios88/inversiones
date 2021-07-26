<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_horario.php");

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
   //$respuesta->alert("$pensum,$idgra,$idsgra,$accgra");
    $contenido = grado_html($pensum,$nivel,$idgra,$accgra);
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
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idsec,$idssec,$accsec");
    $contenido = seccion_html($pensum,$nivel,$grado,$tipo,$idsec,$accsec);
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


function Nivel_Tipo_Periodo($pensum,$nivel,$idtip,$idstip,$acctip){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$pensum,$nivel,$idtip,$idstip,$acctip");
    $contenido = tipo_periodo_html($pensum,$nivel,$idtip,$acctip);
    $respuesta->assign($idstip,"innerHTML",$contenido);
	$respuesta->script("Submit();");
	
	return $respuesta;
}

//////////////////---- Tipo de Periodos -----/////////////////////////////////////////////

function Grabar_Tipo_Periodo($pensum,$nivel,$min,$desc){
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
		$cod = $ClsHor->max_tipo_periodo($pensum,$nivel);
		$cod++;
		$sql = $ClsHor->insert_tipo_periodo($cod,$pensum,$nivel,$min,$desc);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);

		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}	

   return $respuesta;

}


function Buscar_Tipo_Periodo($cod,$pensum,$nivel){
   $respuesta = new xajaxResponse();
  $ClsHor = new ClsHorario();
   //$respuesta->alert("$cod");
	$cont = $ClsHor->count_tipo_periodo($cod,$pensum,$nivel);
		if($cont>0){
			if($cont==1){
				$result = $ClsHor->get_tipo_periodo($cod,$pensum,$nivel);
				foreach($result as $row){
					$cod = $row["tip_codigo"];
					$respuesta->assign("cod","value",$cod);
					$pensum = $row["tip_pensum"];
					$respuesta->assign("pensum","value",$pensum);
					$nivel = $row["tip_nivel"];
					$respuesta->assign("nivel","value",$nivel);
					$desc = utf8_decode($row["tip_descripcion"]);
					$respuesta->assign("desc","value",$desc);
					$min = $row["tip_minutos"];
					$respuesta->assign("min","value",$min);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_tipo_periodo($cod,$pensum,$nivel,$nom,$min);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
	   	}	

   return $respuesta;

}


function Modificar_Tipo_Periodo($cod,$pensum,$nivel,$min,$desc){
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
			$sql = $ClsHor->modifica_tipo_periodo($cod,$pensum,$nivel,$min,$desc);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
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


function Situacion_Tipo_Periodo($cod,$pensum,$nivel){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

    //$respuesta->alert("$diap,$min");
    if($cod != ""){
		$activo = $ClsHor->count_periodos('','',$cod,$pensum,$nivel);
			if($activo > 0){
				$sql = $ClsHor->delete_tipo_periodo($cod,$pensum,$nivel);
				//$respuesta->alert("$sql");
				$rs = $ClsHor->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Tipo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}	
			}else{
				$msj = '<h5>Este Tipo tiene Periodos activos, desactivelos primero antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
	}

	return $respuesta;
}

//////////////////---- Periodos -----/////////////////////////////////////////////

function Grabar_Periodo($dia,$tipo,$pensum,$nivel,$hini,$hfin){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

	if($tipo != "" && $dia != ""){
		 //$respuesta->alert("$dia,$tipo,$horini,$minini,$horfin,$minfin");
		$cod = $ClsHor->max_periodos($dia);  
		$cod++;
		$sql = $ClsHor->insert_periodos($cod,$dia,$tipo,$pensum,$nivel,0,$hini,$hfin);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}

function Modificar_Periodo($cod,$dia,$tipo,$pensum,$nivel,$hini,$hfin){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

	//$respuesta->alert("$cod,$dia,$tipo,$horini,$minini,$horfin,$minfin");
    if($cod != ""){
		if($tipo != "" && $dia != ""){
			$sql = $ClsHor->modifica_periodos($cod,$dia,$tipo,$pensum,$nivel,0,$hini,$hfin);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
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


function Grabar_Periodo_Grado($dia,$tipo,$pensum,$nivel,$grado,$hini,$hfin){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

	if($tipo != "" && $dia != ""){
		 //$respuesta->alert("$dia,$tipo,$horini,$minini,$horfin,$minfin");
		$cod = $ClsHor->max_periodos($dia);  
		$cod++;
		$sql = $ClsHor->insert_periodos($cod,$dia,$tipo,$pensum,$nivel,$grado,$hini,$hfin);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}


function Modificar_Periodo_Grado($cod,$dia,$tipo,$pensum,$nivel,$grado,$hini,$hfin){
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

	//$respuesta->alert("$cod,$dia,$tipo,$horini,$minini,$horfin,$minfin");
    if($cod != ""){
		if($tipo != "" && $dia != ""){
			$sql = $ClsHor->modifica_periodos($cod,$dia,$tipo,$pensum,$nivel,$grado,$hini,$hfin);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
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
	$cont = $ClsHor->count_periodos($cod,$dia);
		if($cont>0){
			if($cont==1){
				$result = $ClsHor->get_periodos($cod,$dia);
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
		$activo = $ClsHor->count_horario("",$cod,$dia);
		//$respuesta->alert("$activo > 0");
			if($activo > 0){
				$msj = '<h5>Este Tipo tiene Periodos organizados en los horarios activos, Elimine el Horario actual primero antes de esta acción...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$sql = $ClsHor->delete_periodos($cod,$dia);
				//$respuesta->alert("$sql");
				$rs = $ClsHor->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Periodo Desactivado Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
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

function Grabar_Horario($periodo,$dia,$hini,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($periodo != "" && $dia != "" && $materia != "" && $maestro != "" && $aula != "" && $fila != ""){
		///-- prepara la hora a comprobar
		$horini = substr($hini, 0, -3);
		
		/////// Valida al Maestro
		$result = $ClsHor->get_horario('','',$dia,'','','','','','','','',$maestro,'');
		if(is_array($result)){
			$contador_maestro = 0;
			foreach($result as $row){
				$hora_ini_maestro = substr($row["per_hini"], 0, -3);
				$hora_fin_maestro = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_maestro) <= strtotime($horini)) && (strtotime($hora_fin_maestro) >= strtotime($horini)))");
				if((strtotime($hora_ini_maestro) <= strtotime($horini)) && (strtotime($hora_fin_maestro) >= strtotime($horini))) {
					$seccion_asig_maestro = $row["sec_descripcion"];
					$grado_asig_maestro = $row["gra_descripcion"];
					$nivel_asig_maestro = $row["niv_descripcion"];
					$tipo_periodo_maestro = $row["tip_descripcion"];
					$min_maestro = $row["tip_minutos"];
					$contador_maestro++;
					//$respuesta->alert("entro en maestros...");
				}
			}
		}
		/////-------------------
		
		/////// Valida al Aula
		$result = $ClsHor->get_horario('','',$dia,'','','',$pensum,$nivel,'','','','',$aula);
		if(is_array($result)){
			$contador_aula = 0;
			foreach($result as $row){
				$hora_ini_aula = substr($row["per_hini"], 0, -3);
				$hora_fin_aula = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_aula) <= strtotime($horini)) && (strtotime($hora_fin_aula) >= strtotime($horini)))");
				if((strtotime($hora_ini_aula) <= strtotime($horini)) && (strtotime($hora_fin_aula) >= strtotime($horini))) {
					$seccion_asig_aula = $row["sec_descripcion"];
					$grado_asig_aula = $row["gra_descripcion"];
					$nivel_asig_aula = $row["niv_descripcion"];
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
				$mensaje.= "ESTE MAESTRO YA ESTA ASIGNADO ESTE DIA AL PERIODO $tipo_periodo_maestro EN LA SECCI&Oacute;N $seccion_asig_maestro DE $grado_asig_maestro EN $nivel_asig_maestro, CON DURACI&Oacute;N DE $min_maestro MINUTOS, INICIANDO A LAS $hora_ini_maestro. NO DEBER&Iacute;A DE SER ASIGNADO, PERO A&Uacute;N ASI DESEA ASIGNARLO?...  ";
				$respuesta->script("document.getElementById('maestro$fila').value = '';");
			}
			if($contador_aula > 0){
				$mensaje.= "ESTA INSTALACI&Oacute;N YA ESTA ASIGNADA ESTE DIA AL PERIODO $tipo_periodo_aula PARA LA SECCI&Oacute;N $seccion_asig_aula DE $grado_asig_aula EN $nivel_asig_aula, CON DURACI&Oacute;N DE $min_aula MINUTOS, INICIANDO A LAS $hora_ini_aula. NO DEBER&Iacute;A DE SER ASIGNADA, PERO A&Uacute;N ASI DESEA ASIGNARLA?...  ";
				$respuesta->script("document.getElementById('aula$fila').value = '';");
			}
			
			$respuesta->script("abrir();");
			$msj = '<label>'.$mensaje.'</label><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "xajax_Grabar_Horario_Forzado('.$periodo.','.$dia.',\''.$hini.'\','.$pensum.','.$nivel.','.$grado.','.$seccion.','.$materia.',\''.$maestro.'\','.$aula.','.$fila.');" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$msj.= '<button type="button" class="btn btn-danger" onclick = "cerrar();" ><span class="fa fa-times"></span> Cancelar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			
		}else{
			$codigo = $ClsHor->max_horario();  
			$codigo++;
			$sql = $ClsHor->insert_horario($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$respuesta->script("window.location.reload();");
				/*$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Horario ya programado';");
				$respuesta->assign("codigo$fila","value",$codigo);
				$respuesta->assign("existe$fila","value","1");*/
			 }else{
				$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
				$respuesta->assign("codigo$fila","value","");
				$respuesta->assign("existe$fila","value","");
				$respuesta->assign("materia$fila","value","");
				$respuesta->assign("maestro$fila","value","");
				$respuesta->assign("aula$fila","value","");
			 }	
		}
   }
   		
   return $respuesta;
}


function Modificar_Horario($codigo,$periodo,$dia,$hini,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($codigo != "" && $periodo != "" && $dia != "" && $materia != "" && $maestro != "" && $aula != "" && $fila != ""){
		///-- prepara la hora a comprobar
		$hini = substr($hini, 0, -3);
		
		/////// Valida al Maestro
		$result = $ClsHor->get_horario('','',$dia,'','','','','','','','',$maestro,'');
		if(is_array($result)){
			$contador_maestro = 0;
			foreach($result as $row){
				$codigo_maestro = $row["hor_codigo"];
				$hora_ini_maestro = substr($row["per_hini"], 0, -3);
				$hora_fin_maestro = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_maestro) <= strtotime($hini)) && (strtotime($hora_fin_maestro) >= strtotime($hini)))");
				if((strtotime($hora_ini_maestro) <= strtotime($hini)) && (strtotime($hora_fin_maestro) >= strtotime($hini)) && ($codigo_maestro != $codigo)) {
					$seccion_asig_maestro = $row["sec_descripcion"];
					$grado_asig_maestro = $row["gra_descripcion"];
					$nivel_asig_maestro = $row["niv_descripcion"];
					$tipo_periodo_maestro = $row["tip_descripcion"];
					$min_maestro = $row["tip_minutos"];
					$contador_maestro++;
					//$respuesta->alert("entro en maestros...");
				}
			}
		}
		/////-------------------
		
		/////// Valida al Aula
		$result = $ClsHor->get_horario('','',$dia,'','','',$pensum,$nivel,'','','','',$aula);
		if(is_array($result)){
			$contador_aula = 0;
			foreach($result as $row){
				$codigo_aula = $row["hor_codigo"];
				$hora_ini_aula = substr($row["per_hini"], 0, -3);
				$hora_fin_aula = substr($row["per_hfin"], 0, -3);
				//$respuesta->alert("((strtotime($hora_ini_aula) <= strtotime($hini)) && (strtotime($hora_fin_aula) >= strtotime($hini)))");
				if((strtotime($hora_ini_aula) <= strtotime($hini)) && (strtotime($hora_fin_aula) >= strtotime($hini)) && ($codigo_aula != $codigo)) {
					$seccion_asig_aula = $row["sec_descripcion"];
					$grado_asig_aula = $row["gra_descripcion"];
					$nivel_asig_aula = $row["niv_descripcion"];
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
				$mensaje.= "ESTE MAESTRO YA ESTA ASIGNADO ESTE DIA AL PERIODO $tipo_periodo_maestro EN LA SECCI&Oacute;N $seccion_asig_maestro DE $grado_asig_maestro EN $nivel_asig_maestro, CON DURACI&Oacute;N DE $min_maestro MINUTOS, INICIANDO A LAS $hora_ini_maestro. NO DEBER&Iacute;A DE SER ASIGNADO, PERO A&Uacute;N ASI DESEA ASIGNARLO?...  ";
				$respuesta->script("document.getElementById('maestro$fila').value = '';");
			}
			if($contador_aula > 0){
				$mensaje.= "ESTA INSTALACI&Oacute;N YA ESTA ASIGNADA ESTE DIA AL PERIODO $tipo_periodo_aula PARA LA SECCI&Oacute;N $seccion_asig_aula DE $grado_asig_aula EN $nivel_asig_aula, CON DURACI&Oacute;N DE $min_aula MINUTOS, INICIANDO A LAS $hora_ini_aula. NO DEBER&Iacute;A DE SER ASIGNADA, PERO A&Uacute;N ASI DESEA ASIGNARLA?...  ";
				$respuesta->script("document.getElementById('aula$fila').value = '';");
			}
			
			$respuesta->script("abrir();");
			$msj = '<label>'.$mensaje.'</label><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "xajax_Modificar_Horario_Forzado('.$codigo.','.$periodo.','.$dia.',\''.$hini.'\','.$pensum.','.$nivel.','.$grado.','.$seccion.','.$materia.',\''.$maestro.'\','.$aula.','.$fila.');" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$msj.= '<button type="button" class="btn btn-danger" onclick = "cerrar();" ><span class="fa fa-times"></span> Cancelar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			
		}else{
			$sql = $ClsHor->modifica_horario($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula);
			//$respuesta->alert("$sql");
			$rs = $ClsHor->exec_sql($sql);
			if($rs == 1){
				$respuesta->script("window.location.reload();");
				/*$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Horario ya programado';");
				$respuesta->assign("existe$fila","value","1");
				$respuesta->assign("codigo$fila","value","$codigo");*/
			 }else{
				$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
				$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
				$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
				$respuesta->assign("materia$fila","value","");
				$respuesta->assign("maestro$fila","value","");
				$respuesta->assign("aula$fila","value","");
			 }
		}
   }
   		
   return $respuesta;
}





function Grabar_Horario_Forzado($periodo,$dia,$hini,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($periodo != "" && $dia != "" && $materia != "" && $maestro != "" && $aula != "" && $fila != ""){
		$codigo = $ClsHor->max_horario();  
		$codigo++;
		$sql = $ClsHor->insert_horario($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->script("window.location.reload();");
			/*$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Horario ya programado';");
			$respuesta->assign("codigo$fila","value",$codigo);
			$respuesta->assign("existe$fila","value","1");
			$respuesta->assign("maestro$fila","value",$maestro);
			$respuesta->assign("aula$fila","value",$aula);
			$respuesta->script("cerrar();");*/
		}else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
			$respuesta->assign("codigo$fila","value","");
			$respuesta->assign("existe$fila","value","");
			$respuesta->assign("materia$fila","value","");
			$respuesta->assign("maestro$fila","value","");
			$respuesta->assign("aula$fila","value","");
		}	
   }
   		
   return $respuesta;
}


function Modificar_Horario_Forzado($codigo,$periodo,$dia,$hini,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsHor = new ClsHorario();

   if($codigo != "" && $periodo != "" && $dia != "" && $materia != "" && $maestro != "" && $aula != "" && $fila != ""){
		$sql = $ClsHor->modifica_horario($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula);
		//$respuesta->alert("$sql");
		$rs = $ClsHor->exec_sql($sql);
		if($rs == 1){
			$respuesta->script("window.location.reload();");
			/*$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-check-circle-o"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-success btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Horario ya programado';");
			$respuesta->assign("existe$fila","value","1");
			$respuesta->assign("codigo$fila","value","$codigo");
			$respuesta->assign("maestro$fila","value",$maestro);
			$respuesta->assign("aula$fila","value",$aula);
			$respuesta->script("cerrar();");*/
		}else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-ban"></span>');
			$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
			$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
			$respuesta->assign("materia$fila","value","");
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
	 
		$sql = $ClsHor->delete_horario($codigo);
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
			$respuesta->assign("materia$fila","value","");
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
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia");
$xajax->register(XAJAX_FUNCTION, "Grado_Seccion");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia_Seccion");
$xajax->register(XAJAX_FUNCTION, "Nivel_Tipo_Periodo");
//////////////////---- Tipo de Periodos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tipo_Periodo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tipo_Periodo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tipo_Periodo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Tipo_Periodo");
//////////////////---- Periodos -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Grabar_Periodo_Grado");
$xajax->register(XAJAX_FUNCTION, "Modificar_Periodo_Grado");
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