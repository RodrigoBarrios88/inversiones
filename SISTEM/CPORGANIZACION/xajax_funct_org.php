<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_org.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Departamentos - Empresas /////////
function Empresa_Departamento($suc,$depid,$sdepid){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$suc");
	$contenido = organizacion_departamento_html($depid,$suc,"");
	$respuesta->assign($sdepid,"innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- Plazas -----/////////////////////////////////////////////
function Grabar_Plazas($dct,$dlg,$salario,$horas,$suc,$dep,$jer,$sub,$ind){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsOrg = new ClsOrganizacion();
	//$ClsHor = new ClsHorasLaboradas();
   //$respuesta->alert("$dct,$dlg,$salario,$horas,$suc,$dep,$jer,$sub,$ind");
   //pasa a mayusculas
		$dct = trim($dct);
		$dlg = trim($dlg);
	//--------
	//decodificaciones de tildes y Ñ's
		$dct = utf8_encode($dct);
		$dlg = utf8_encode($dlg);
		//--
		$dct = utf8_decode($dct);
		$dlg = utf8_decode($dlg);
	//--------
	
	if($suc != "" && $dep != "" && $dct != "" && $dlg != "" && $sub != ""){
		$plaza = $ClsOrg->max_plaza();
		$plaza++;
		$sql = $ClsOrg->insert_plaza($plaza,$dct,$dlg,$salario,$horas,$dep,1000,$sub,$ind,1);
		//$sql.= $ClsHor->insert_horas($plaza,$horas);
		//$respuesta->alert("$sql");
		$rs = $ClsOrg->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}


function Buscar_Plazas($cod){
   $respuesta = new xajaxResponse();
   $ClsOrg = new ClsOrganizacion();
   //$respuesta->alert("$cod");
		$cont = $ClsOrg->count_plaza($cod,"","","","","","","","");
		if($cont>0){
			if($cont==1){
				$result = $ClsOrg->get_plaza($cod,"","","","","","","","");
				foreach($result as $row){
					$plaza = $row["plaz_codigo"];
					$respuesta->assign("plaza","value",$plaza);
					$jer = $row["plaz_jerarquia"];
					$respuesta->assign("jer","value",$jer);
					$sub = $row["plaz_subord"];
					$respuesta->assign("sub","value",$sub);
					$descsub = $row["plaz_subord_desc"];
					$respuesta->assign("descsub","innerHTML",$descsub);
					$suc = $row["suc_id"];
					$respuesta->assign("suc","value",$suc);
					$dep = $row["dep_id"];
					$dct = $row["plaz_desc_ct"];
					$respuesta->assign("dct","value",$dct);
					$dlg = $row["plaz_desc_lg"];
					$respuesta->assign("dlg","value",$dlg);
					$salario = $row["plaz_salario_hora"];
					$respuesta->assign("salario","value",$salario);
					$horas = $row["plaz_horas_promedio"];
					$respuesta->assign("horas","value",$horas);
					$sit = $row["plaz_situacion"];
					$respuesta->assign("sit","value",$sit);
					$ind = $row["plaz_independ"];
					if($ind == 1){
						$respuesta->script("document.getElementById('ind').checked = true;");
					}else{
						$respuesta->script("document.getElementById('ind').checked = false;");
					}
				}
				$combo = organizacion_departamento_html("dep",$suc,"");
				$respuesta->assign("divdep","innerHTML",$combo);
				$respuesta->assign("dep","value",$dep);
			}
			$contenido = tabla_plazas("",$dct,$dlg,$suc,$dep,$sit);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
   return $respuesta;
}

function Modificar_Plazas($plaza,$dct,$dlg,$salario,$horas,$suc,$dep,$jer,$sub,$ind){
   $respuesta = new xajaxResponse();
   $ClsOrg = new ClsOrganizacion();
	//$ClsHor = new ClsHorasLaboradas();
   //pasa a mayusculas
		$dct = trim($dct);
		$dlg = trim($dlg);
	//--------
	//decodificaciones de tildes y Ñ's
		$dct = utf8_encode($dct);
		$dlg = utf8_encode($dlg);
		//--
		$dct = utf8_decode($dct);
		$dlg = utf8_decode($dlg);
	//--------
	if($plaza != ""){
		if($suc != "" && $dep != "" && $dct != "" && $dlg != "" && $jer != "" && $sub != ""){
			$sql = $ClsOrg->modifica_plaza($plaza,$dct,$dlg,$salario,$horas,$dep,$jer,$sub,$ind);
			//$sql.= $ClsHor->modifica_horas($plaza,$horas);
			//$respuesta->alert("$sql");
			$rs = $ClsOrg->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


function Eliminar_Plaza($plaza){
   $respuesta = new xajaxResponse();
   $ClsOrg = new ClsOrganizacion();
	//$ClsHor = new ClsHorasLaboradas();
   if($plaza != ""){
		$sql = $ClsOrg->cambia_sit_plaza($plaza,0);
		//$respuesta->alert("$sql");
		$rs = $ClsOrg->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros Eliminado Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
	}
   		
   return $respuesta;
}


function Set_Desc_Plaza($plaza,$destino,$propiedad){
   $respuesta = new xajaxResponse();
   $ClsOrg = new ClsOrganizacion();
   
   $result = $ClsOrg->get_plaza($plaza);
	if(is_array($result)){
		foreach($result as $row){
			$desc = $row["plaz_desc_ct"];
			$respuesta->assign($destino,$propiedad,$desc);
		}
	}else{
		$respuesta->assign("",$propiedad,"");
	}
	$respuesta->script("cerrar();");
	return $respuesta;
}


/////////////////---- Asignacion de Plazas -----/////////////////////////////////////////////
function Buscar_Personal($dpi){
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPersonal();
	
   $result = $ClsPer->get_personal($dpi);
	//$respuesta->alert("$result");
   if(is_array($result)){
		foreach($result as $row){
			$dpi = $row["per_dpi"];
			$respuesta->assign("dpi","value",$dpi);
			$nom = utf8_decode($row["per_nombres"]);
			$respuesta->assign("nom","value",$nom);
			$ape = utf8_decode($row["per_apellidos"]);
			$respuesta->assign("ape","value",$ape);
		}
		$respuesta->script("cerrar();");
   }	
      return $respuesta;
}


function Asignar_Plaza($personal,$plaza){
   $respuesta = new xajaxResponse();
   $ClsOrg = new ClsOrganizacion();
	
   if($plaza != ""){
		if($personal != ""){
			$result = $ClsOrg->get_organizacion('',$plaza,'','','','','','','',1);
			if(!is_array($result)){
				$codigo = $ClsOrg->max_organizacion($personal);
				$codigo++;
				$sql = $ClsOrg->anula_organizacion($personal);
				$sql.= $ClsOrg->insert_organizacion($codigo,$personal,$plaza);
				//$respuesta->alert("$sql");
				$rs = $ClsOrg->exec_sql($sql);
				if($rs == 1){
					$msj = '<h5>Plaza Asignada Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexion...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
					$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
				}
			}else{
				foreach($result as $row){
					$dpi = $row["per_dpi"];
					$nom = utf8_decode($row["per_nombres"]);
					$ape = utf8_decode($row["per_apellidos"]);
					$mensaje = "Esta plaza ya esta ocupada por $nom $ape, identficado con el documento $dpi.  Si desea asignar a otra persona a esta plaza, debe cambiar de plaza al ocupante actual o crear otra plaza similar.";
				}
				$msj = '<h5 class = "text-justify">'.$mensaje.'</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


//////////////////---- Plazas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Plazas");
$xajax->register(XAJAX_FUNCTION, "Buscar_Plazas");
$xajax->register(XAJAX_FUNCTION, "Modificar_Plazas");
$xajax->register(XAJAX_FUNCTION, "Set_Desc_Plaza");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Plaza");
///////////// Departamentos - Empresas /////////
$xajax->register(XAJAX_FUNCTION, "Empresa_Departamento");

/////////////////---- Asignacion de Plazas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Personal");
$xajax->register(XAJAX_FUNCTION, "Asignar_Plaza");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  