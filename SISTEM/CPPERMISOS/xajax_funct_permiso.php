<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_permiso.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- GRUPO -----/////////////////////////////////////////////
function Grabar_Grupo($desc,$clv){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPerm = new ClsPermiso();
    //pasa a mayusculas
		$desc = trim($desc);
    	$clv = trim($clv);
    //--		
    //decodificaciones de tildes y �'s
		$desc = utf8_encode($desc);
    	$clv = utf8_encode($clv);
		//--
		$desc = utf8_decode($desc);
    	$clv = utf8_decode($clv);
    //--------
    if($desc != ""){
		$id = $ClsPerm->max_grupo();
		$id++;
		$sql = $ClsPerm->insert_grupo($id,$desc,$clv);
		$rs = $ClsPerm->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMgrupo.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}



function Buscar_Grupo($cod){
   $respuesta = new xajaxResponse();
   $ClsPerm = new ClsPermiso();
   //$respuesta->alert("$cod");
	$cont = $ClsPerm->count_grupo($cod,$desc);
		if($cont>0){
			if($cont==1){
				$result = $ClsPerm->get_grupo($cod,$desc);
				foreach($result as $row){
					$cod = $row["gperm_id"];
					$respuesta->assign("cod","value",$cod);
					$desc = utf8_decode($row["gperm_desc"]);
					$respuesta->assign("desc","value",$desc);
					$clv = utf8_decode($row["gperm_clave"]);
					$respuesta->assign("clv","value",$clv);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_grupos($cod,$desc,$clv);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
	   	}	
   return $respuesta;
}

function Modificar_Grupo($cod,$desc,$clv){
   $respuesta = new xajaxResponse();
   $ClsPerm = new ClsPermiso();
   //pasa a mayusculas
		$desc = trim($desc);
    	$clv = trim($clv);
    //--		
    //decodificaciones de tildes y �'s
		$desc = utf8_encode($desc);
    	$clv = utf8_encode($clv);
		//--
		$desc = utf8_decode($desc);
    	$clv = utf8_decode($clv);
    //--------
	if($cod != ""){
		if($desc != ""){
			$sql = $ClsPerm->modifica_grupo($cod,$desc,$clv);
			$rs = $ClsPerm->exec_sql($sql);
			//$respuesta->alert("$sql");
    		if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMgrupo.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			   $respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').disabled = false;");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslaci�n..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("cerrar();");
	}
	
   return $respuesta;
}

//////////////////---- PERMISOS -----/////////////////////////////////////////////
function Grabar_Permiso($gru,$desc,$clv){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPerm = new ClsPermiso();
    //pasa a mayusculas
		$desc = trim($desc);
    	$clv = trim($clv);
    //--		
    //decodificaciones de tildes y �'s
		$desc = utf8_encode($desc);
    	$clv = utf8_encode($clv);
		//--
		$desc = utf8_decode($desc);
    	$clv = utf8_decode($clv);
    //--------
    if($gru != "" && $desc != "" && $clv != ""){
		$id = $ClsPerm->max_permiso($gru);
		$id++;
		$sql = $ClsPerm->insert_permisos($id,$gru,$desc,$clv);
		$rs = $ClsPerm->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMpermiso.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}


function Buscar_Permiso($cod,$gru){
   $respuesta = new xajaxResponse();
   $ClsPerm = new ClsPermiso();
	$cont = $ClsPerm->count_permisos($cod,$gru,$desc,$clv);
		if($cont>0){
			if($cont==1){
				$result = $ClsPerm->get_permisos($cod,$gru,$desc,$clv);
				foreach($result as $row){
					$cod = $row["perm_id"];
					$respuesta->assign("cod","value",$cod);
					$gru = $row["perm_grupo"];
					$respuesta->assign("gru","value",$gru);
					$respuesta->script("document.getElementById('gru').setAttribute('disabled','disabled');");
					$desc = utf8_decode($row["perm_desc"]);
					$respuesta->assign("desc","value",$desc);
					$clv = utf8_decode($row["perm_clave"]);
					$respuesta->assign("clv","value",$clv);
				}
			}
			$contenido = tabla_permisos($cod,$gru,$desc,$clv);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
   return $respuesta;
}

function Modificar_Permiso($cod,$gru,$desc,$clv){
    $respuesta = new xajaxResponse();
    $ClsPerm = new ClsPermiso();
    //pasa a mayusculas
	   $desc = trim($desc);
    	$clv = trim($clv);
    //--		
    //decodificaciones de tildes y �'s
	   $desc = utf8_encode($desc);
    	$clv = utf8_encode($clv);
		//--
		$desc = utf8_decode($desc);
    	$clv = utf8_decode($clv);
		
    //--------
    if($cod != ""){
		if($gru != "" && $desc != "" && $clv != ""){
			$sql = $ClsPerm->modifica_permisos($cod,$gru,$desc,$clv);
			//$respuesta->alert("$sql");
			$rs = $ClsPerm->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMpermiso.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			   $respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('gru').className = 'btn btn-primary';");
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslaci�n..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


//////////////////---- ROLES -----/////////////////////////////////////////////
function Grabar_Rol($nom,$desc,$arrperm,$arrgru,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsRoll = new ClsRoll();
    //pasa a mayusculas
		$desc = trim($desc);
    	$nom = trim($nom);
    //--		
    //decodificaciones de tildes y �'s
		$desc = utf8_encode($desc);
		$nom = utf8_encode($nom);
		//--
	   $desc = utf8_decode($desc);
    	$nom = utf8_decode($nom);
    //--------
    if($desc != "" && $nom != "" && $cant != ""){
		$id = $ClsRoll->max_roll();
		$id++;
		$sql = $ClsRoll->insert_roll($id,$nom,$desc);
		for($i = 1; $i <= $cant; $i++){
			$perm = $arrperm[$i];
			$grupo = $arrgru[$i];
			$sql.= $ClsRoll->insert_det_roll($perm,$grupo,$id);
		}
		//$respuesta->alert($sql);
		$rs = $ClsRoll->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMroll.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}


function Cuadro_Actualizar_roles($roll){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsRoll = new ClsRoll();
    if($roll != ""){
		$cont = $ClsRoll->count_roll($roll);
		//$respuesta->alert($cont);
		if($cont>0){
			$result = $ClsRoll->get_roll($roll);
			foreach($result as $row){
				$cod = $row["roll_id"];
				$nom = utf8_decode($row["roll_nombre"]);
				$desc = utf8_decode($row["roll_desc"]);
			}
			$contenido = tabla_editar_datosroll($cod,$nom,$desc);
			$contenido.= tabla_permisos_editar($roll);
			$contenido.= tabla_botones_actualizar();
			$respuesta->assign("result","innerHTML",$contenido);
		}
	}
	$respuesta->script("cerrar();");
   		
   return $respuesta;
}


function Actualizar_Rol($cod,$nom,$desc,$arrperm,$arrgru,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsRoll = new ClsRoll();
    //pasa a mayusculas
		$desc = trim($desc);
    	$nom = trim($nom);
    //--		
    //decodificaciones de tildes y �'s
		$desc = utf8_encode($desc);
		$nom = utf8_encode($nom);
		//--
	   $desc = utf8_decode($desc);
    	$nom = utf8_decode($nom);
    //--------
    if($cod != "" && $desc != "" && $nom != "" && $cant != ""){
		$sql = $ClsRoll->modifica_roll($cod,$nom,$desc);
		$sql.= $ClsRoll->delet_det_roll_grupo($cod);
		for($i = 1; $i <= $cant; $i++){
			$perm = $arrperm[$i];
			$grupo = $arrgru[$i];
			$sql.= $ClsRoll->insert_det_roll($perm,$grupo,$cod);
		}
		//$respuesta->alert($sql);
		$rs = $ClsRoll->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros Actualizados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMrollmod.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   		
   return $respuesta;
}


function Ver_Roles($roll){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
  		$contenido = tabla_visualiza_permisos($roll);
		$respuesta->assign("divroll$roll","innerHTML",$contenido);
		$respuesta->script("cerrar();");
   		
   return $respuesta;
}


function CambiaSit_Roles($cod,$sit){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsRoll = new ClsRoll();
   if($cod != ""){
		$sql = $ClsRoll->cambia_sit_roll($cod,$sit);
		$rs = $ClsRoll->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros Deshabilitado Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMrolldel.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
		$respuesta->script("cerrarPromt()");
	}
   		
   return $respuesta;
}

//////////////////---- GRUPOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grupo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grupo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grupo2");
$xajax->register(XAJAX_FUNCTION, "Modificar_Grupo");
//////////////////---- PERMISOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Permiso");
$xajax->register(XAJAX_FUNCTION, "Buscar_Permiso");
$xajax->register(XAJAX_FUNCTION, "Buscar_Permiso2");
$xajax->register(XAJAX_FUNCTION, "Modificar_Permiso");
//////////////////---- Roles -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Rol");
$xajax->register(XAJAX_FUNCTION, "Cuadro_Actualizar_roles");
$xajax->register(XAJAX_FUNCTION, "Actualizar_Rol");
$xajax->register(XAJAX_FUNCTION, "Ver_Roles");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Roles");

//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  