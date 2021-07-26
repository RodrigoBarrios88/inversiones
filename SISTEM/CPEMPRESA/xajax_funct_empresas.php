<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_empresas.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- EMPRESAS -----/////////////////////////////////////////////
function Grabar_Empresa($nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsEmp = new ClsEmpresa();
    //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		$contact = utf8_encode($contact);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
		$contact = utf8_decode($contact);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    if($nom != "" && $direc != "" && $tel1 != "" && $contact != ""){
		$id = $ClsEmp->max_sucursal();
		$id++; /// Maximo codigo de Empresa
		//$respuesta->alert("$id");
		$sql = $ClsEmp->insert_sucursal($id,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc); /// Inserta Empresa
		//$respuesta->alert("$sql");
		$rs = $ClsEmp->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Empresa($cod){
   $respuesta = new xajaxResponse();
   $ClsEmp = new ClsEmpresa();
   //$respuesta->alert("$cod");
		$cont = $ClsEmp->count_sucursal($cod,"","","","");
		if($cont>0){
			if($cont==1){
				$result = $ClsEmp->get_sucursal($cod,"","","","");
				foreach($result as $row){
					$cod = $row["suc_id"];
					$respuesta->assign("cod","value",$cod);
					$nom = utf8_decode($row["suc_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$dir = utf8_decode($row["suc_direccion"]);
					$respuesta->assign("direc","value",$dir);
					$tel1 = $row["suc_tel1"];
					$respuesta->assign("tel1","value",$tel1);
					$tel2 = $row["suc_tel2"];
					$respuesta->assign("tel2","value",$tel2);
					$mail = $row["suc_mail"];
					$respuesta->assign("mail","value",$mail);
					$contact = utf8_decode($row["suc_contacto"]);
					$respuesta->assign("contac","value",$contact);
					$telc = $row["suc_cont_tel"];
					$respuesta->assign("telc","value",$telc);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_sucursales($cod,"","","","");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
	   	}	
   return $respuesta;
}

function Modificar_Empresa($cod,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
   $respuesta = new xajaxResponse();
   $ClsEmp = new ClsEmpresa();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		$contact = utf8_encode($contact);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
		$contact = utf8_decode($contact);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cod != ""){
		if($nom != "" && $direc != "" && $tel1 != "" && $contact != ""){
			$sql = $ClsEmp->modifica_sucursal($cod,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc);
			$rs = $ClsEmp->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			        $respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslaci&oacute;n..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


//////////////////---- EMPRESAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Empresa");
$xajax->register(XAJAX_FUNCTION, "Buscar_Empresa");
$xajax->register(XAJAX_FUNCTION, "Modificar_Empresa");

//El objeto xajax tiene que procesar cualquier petici&oacute;n
$xajax->processRequest();

?>  