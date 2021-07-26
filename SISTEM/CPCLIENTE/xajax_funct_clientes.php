<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_clientes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- EMPRESAS -----/////////////////////////////////////////////
function Grabar_Cliente($nit,$nom,$direc,$tel1,$tel2,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    if($nit != "" && $nom != "" && $direc != ""){
		$id = $ClsCli->max_cliente();
		$id++; /// Maximo codigo de Empresa
		//$respuesta->alert("$id");
		$sql = $ClsCli->insert_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail); /// Inserta Empresa
		//$respuesta->alert("$sql");
		$rs = $ClsCli->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}
   
   return $respuesta;
}


function Buscar_Cliente($cod){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //$respuesta->alert("$cod");
		$cont = $ClsCli->count_cliente($cod,"","");
		if($cont>0){
			if($cont==1){
				$result = $ClsCli->get_cliente($cod,"","");
				foreach($result as $row){
					$cod = $row["cli_id"];
					$respuesta->assign("cod","value",$cod);
					$nit = utf8_decode($row["cli_nit"]);
					$respuesta->assign("nit","value",$nit);
					$nom = utf8_decode($row["cli_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$dir = utf8_decode($row["cli_direccion"]);
					$respuesta->assign("direc","value",$dir);
					$tel1 = $row["cli_tel1"];
					$respuesta->assign("tel1","value",$tel1);
					$tel2 = $row["cli_tel2"];
					$respuesta->assign("tel2","value",$tel2);
					$mail = $row["cli_mail"];
					$respuesta->assign("mail","value",$mail);
				}
			}
			//abilita y desabilita botones
			$contenido = tabla_clientes($cod,"","");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar()");
      }	
   return $respuesta;
}

function Modificar_Cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cod != ""){
		if($nit != "" && $nom != "" && $direc != ""){
			$sql = $ClsCli->modifica_cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail);
			$rs = $ClsCli->exec_sql($sql);
			if($rs == 1){
				$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button>';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


//////////////////---- EMPRESAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  