<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_departamentos.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- Departamentos -----/////////////////////////////////////////////
function Grabar_Departamento($suc,$dct,$dlg){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsDep = new ClsDepartamento();
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
	if($suc != "" && $dct != "" && $dlg != ""){
		$id = $ClsDep->max_departamento();
		$id++;
		$sql = $ClsDep->insert_departamento($id,$dct,$dlg,$suc,1);
		//$respuesta->alert("$sql");
		$rs = $ClsDep->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
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


function Buscar_Departamento($cod){
   $respuesta = new xajaxResponse();
   $ClsDep = new ClsDepartamento();

   //$respuesta->alert("$cod");
		$cont = $ClsDep->count_departamento($cod,"","","","");
		if($cont>0){
			if($cont==1){
				$result = $ClsDep->get_departamento($cod,"","","","");
				foreach($result as $row){
					$cod = $row["dep_id"];
					$respuesta->assign("cod","value",$cod);
					$suc = $row["suc_id"];
					$respuesta->assign("suc","value",$suc);
					$dct = utf8_decode($row["dep_desc_ct"]);
					$respuesta->assign("dct","value",$dct);
					$dlg = utf8_decode($row["dep_desc_lg"]);
					$respuesta->assign("dlg","value",$dlg);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_departamentos($cod,"","","","");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
	   	}	
   return $respuesta;
}

function Modificar_Departamento($cod,$suc,$dct,$dlg){
   $respuesta = new xajaxResponse();
   $ClsDep = new ClsDepartamento();

   //pasa a mayusculas
		$dct = trim($dct);
		$dlg = trim($dlg);
	//--------
	//decodificaciones de tildes y Ñ's
		//decodificaciones de tildes y Ñ's
		$dct = utf8_encode($dct);
		$dlg = utf8_encode($dlg);
		//--
		$dct = utf8_decode($dct);
		$dlg = utf8_decode($dlg);
	//--------
	//--------
	if($cod != ""){
		if($suc != ""&& $dct != "" && $dlg != ""){
			$sql = $ClsDep->modifica_departamento($cod,$dct,$dlg);
			//$respuesta->alert("$sql");
			$rs = $ClsDep->exec_sql($sql);
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
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}



function Eliminar_Departamento($codigo){
   $respuesta = new xajaxResponse();
   $ClsDep = new ClsDepartamento();

   if($codigo != ""){
		$sql = $ClsDep->cambia_sit_departamento($codigo,0);
		//$respuesta->alert("$sql");
		$rs = $ClsDep->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros Eliminado Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
	}
   		
   return $respuesta;
}


//////////////////---- Departamentos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Departamento");
$xajax->register(XAJAX_FUNCTION, "Buscar_Departamento");
$xajax->register(XAJAX_FUNCTION, "Modificar_Departamento");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Departamento");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  