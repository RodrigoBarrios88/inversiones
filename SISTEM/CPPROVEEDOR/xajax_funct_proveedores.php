<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_proveedores.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- EMPRESAS -----/////////////////////////////////////////////
function Grabar_Proveedor($nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$contact = trim($contact);
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
		$id = $ClsProv->max_proveedor();
		$id++; /// Maximo codigo de Empresa
		//$respuesta->alert("$id");
		$sql = $ClsProv->insert_proveedor($id,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc); /// Inserta Empresa
		//$respuesta->alert("$sql");
		$rs = $ClsProv->exec_sql($sql);
		if($rs == 1){
			$contenido = tabla_proveedores("",$nit,$nom,$contact);
			$respuesta->assign("result","innerHTML",$contenido);
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').disabled = false;");
		}
	}
   
   return $respuesta;
}


function Buscar_Proveedor($cod){
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //$respuesta->alert("$cod");
		$cont = $ClsProv->count_proveedor($cod,"","","","");
		if($cont>0){
			if($cont==1){
				$result = $ClsProv->get_proveedor($cod,"","","","");
				foreach($result as $row){
					$cod = $row["prov_id"];
					$respuesta->assign("cod","value",$cod);
					$nit = $row["prov_nit"];
					$respuesta->assign("nit","value",$nit);
					$nom = utf8_decode($row["prov_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$dir = utf8_decode($row["prov_direccion"]);
					$respuesta->assign("direc","value",$dir);
					$tel1 = $row["prov_tel1"];
					$respuesta->assign("tel1","value",$tel1);
					$tel2 = $row["prov_tel2"];
					$respuesta->assign("tel2","value",$tel2);
					$mail = $row["prov_mail"];
					$respuesta->assign("mail","value",$mail);
					$contact = utf8_decode($row["prov_contacto"]);
					$respuesta->assign("contac","value",$contact);
					$telc = $row["prov_cont_tel"];
					$respuesta->assign("telc","value",$telc);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_proveedores($cod,"","","","");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
	   }	
   return $respuesta;
}

function Modificar_Proveedor($cod,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$contact = trim($contact);
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
			$sql = $ClsProv->modifica_proveedor($cod,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc);
			$rs = $ClsProv->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("result","innerHTML",$contenido);
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').disabled = false;");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("cerrar()");
	}
   		
   return $respuesta;
}


//////////////////---- EMPRESAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Modificar_Proveedor");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  