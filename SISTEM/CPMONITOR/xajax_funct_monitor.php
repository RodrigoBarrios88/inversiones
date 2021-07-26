<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_monitor.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


///////////// Grupos //////////////////////
function Grupos_Monitor($monitor,$area){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$monitor,$area");
   if($monitor != ""){
      $result = $ClsAsi->get_monitor_bus_grupo("",$monitor,1);
      if(is_array($result)){
		 $grupos = "";
		 foreach($result as $row){
			$grupos.= $row["gru_codigo"].",";
		 }
		 $grupos = substr($grupos, 0, strlen($grupos) - 1);
      }
      //$respuesta->alert("$grupos");
      /// Setea listas de puntos
      $contenido = grupos_no_monitor_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      
      $contenido = grupos_monitor_lista_multiple("asignados",$monitor);
      $respuesta->assign("divasignados","innerHTML",$contenido);
      
      $respuesta->script("cerrar();");
   }else{
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}

//////////////////---- Otros Monitores de Buses -----/////////////////////////////////////////////
function Grabar_Monitor($cui,$nom,$ape,$tel,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   $ClsMoni = new ClsMonitorBus();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    
    if($cui !="" && $nom !="" && $ape != "" && $tel != "" && $mail != ""){
		//$respuesta->alert("$id");
		$sql = $ClsMoni->insert_monitores_buses($cui,$nom,$ape,$tel,$mail); /// Inserta
		$pass = Generador_Contrasena();
		$id = $ClsUsu->max_usuario();
		$id++; /// Maximo codigo
		$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,4,$cui,$mail,$pass,1);
		$respuesta->alert("Contrase–a $pass, DPI $cui");
		//$respuesta->alert("$sql");
		$rs = $ClsMoni->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Monitor($cui){
   $respuesta = new xajaxResponse();
   $ClsMoni = new ClsMonitorBus();
   //$respuesta->alert("$cui");
		$cont = $ClsMoni->count_monitores_buses($cui);
		if($cont>0){
			if($cont==1){
				    $result = $ClsMoni->get_monitores_buses($cui);
				    foreach($result as $row){
						$cui = $row["mbus_cui"];
						$respuesta->assign("cui","value",$cui);
				    	$ape = utf8_decode($row["mbus_apellido"]);
						$respuesta->assign("ape","value",$ape);
						$nom = utf8_decode($row["mbus_nombre"]);
						$respuesta->assign("nom","value",$nom);
						$tel = $row["mbus_telefono"];
						$respuesta->assign("tel","value",$tel);
						$mail = $row["mbus_mail"];
						$respuesta->assign("mail","value",$mail);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_monitores_buses($cui,$ape,$nom,$usu,$suc,1);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
	   	}	
   return $respuesta;
}


function Modificar_Monitor($cui,$nom,$ape,$tel,$mail){
   $respuesta = new xajaxResponse();
   $ClsMoni = new ClsMonitorBus();
   //pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cui != ""){
		if($nom !="" && $ape != "" && $tel != "" && $mail != ""){
			$sql = $ClsMoni->modifica_monitores_buses($cui,$nom,$ape,$tel,$mail);
			//$respuesta->alert("$sql");
			$rs = $ClsMoni->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			        $respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').disabled = false;");
				$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
			        $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			        $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
	       $msj = '<h5>Error de Traslaci&oacute;n..., refresque la pagina e intente de nuevo</h5><br><br>';
	       $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
	       $respuesta->assign("lblparrafo","innerHTML",$msj);
	       $respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
	       $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
	       $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Monitor($cui,$sit){
   $respuesta = new xajaxResponse();
   $ClsMoni = new ClsMonitorBus();

	    //$respuesta->alert("$cui,$sit");
	    if($cui != ""){
			if($sit == 2){
				    $sql = $ClsMoni->cambia_sit_monitores_buses($cui,$sit);
				    //$respuesta->alert("$sql");
				    $rs = $ClsMoni->exec_sql($sql);
				    if($rs == 1){
						$msj = '<h5>Monitor inhabilitado Satisfactoriamente!!!</h5><br><br>';
						$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
						$respuesta->assign("lblparrafo","innerHTML",$msj);
				    }else{
						$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
						$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
						$respuesta->assign("lblparrafo","innerHTML",$msj);
				    }	
			}else if($sit == 1){
				    $sql = $ClsMoni->cambia_sit_monitores_buses($cui,$sit);
				    //$respuesta->alert("$sql");
				    $rs = $ClsMoni->exec_sql($sql);
				    if($rs == 1){
					    $msj = '<h5>Monitor Re-Activada Satisfactoriamente!!!</h5><br><br>';
					    $msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					    $respuesta->assign("lblparrafo","innerHTML",$msj);
				    }else{
					    $msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
					    $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					    $respuesta->assign("lblparrafo","innerHTML",$msj);
				    }	
			}
	    }

	return $respuesta;
}


////////////////////////// ASIGNACION DE GRUPOS Y MAESTROS ////////

function Area_Grupos($area,$grupos){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$area,'$grupos'");
      $contenido = grupos_no_monitor_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      $respuesta->script("cerrar();");
	  
   return $respuesta;
}



function Graba_Monitor_Grupos($monitor,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$monitor,$grupos,$filas");
   if($monitor != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
		 $sql.= $ClsAsi->asignacion_monitor_bus_grupo($grupos[$i],$monitor);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
		 $respuesta->script("Busca_Grupos_Monitor($monitor,$area);");
      }else{
		 $msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
		 $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
		 $respuesta->assign("lblparrafo","innerHTML",$msj);
      }
   } 
   
   return $respuesta;
}


function Quitar_Monitor_Grupos($monitor,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   if($monitor != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
	 //$respuesta->alert("$grupos[$i],$monitor");   
	 $sql.= $ClsAsi->desasignacion_monitor_bus_grupo($grupos[$i],$monitor);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
		 $respuesta->script("Busca_Grupos_Monitor($monitor,$area);");
      }else{
		 $msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
		 $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
		 $respuesta->assign("lblparrafo","innerHTML",$msj);
      }
   }   
   
   return $respuesta;
}



//////////////////---- VARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grupos_Monitor");
//////////////////---- VETERINARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Monitor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Monitor");
$xajax->register(XAJAX_FUNCTION, "Modificar_Monitor");
$xajax->register(XAJAX_FUNCTION, "Situacion_Monitor");
////////////////////////// ASIGNACION DE PUNTOS Y TECNICOS ////////
$xajax->register(XAJAX_FUNCTION, "Area_Grupos");
$xajax->register(XAJAX_FUNCTION, "Graba_Monitor_Grupos");
$xajax->register(XAJAX_FUNCTION, "Quitar_Monitor_Grupos");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  