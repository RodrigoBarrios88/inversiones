<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_signup.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

////////////----- PERDIDA DE PASS -------///////////////////////////////////
function Buscar_CUI($cui){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
	$ClsPad = new ClsPadre();
   if($cui != ""){		
		$result = $ClsUsu->get_usuario_tipo_codigo(3,$cui); /// tipo 3 -> Padres
		//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
				$cod = $row["usu_id"];
				$respuesta->assign("cod","value",$cod);
				$mail = $row["usu_mail"];
				$respuesta->assign("mail","value",$mail);
			}
			
			$result = $ClsPad->get_padre($cui,'','',1);
			if(is_array($result)){
				foreach($result as $row){
					$dpi = $row["pad_cui"];
					$respuesta->assign("cui","value",$dpi);
					//nombre
					$nom = utf8_decode($row["pad_nombre"]);
					$respuesta->assign("nom","value",$nom);
					//ape
					$ape = utf8_decode($row["pad_apellido"]);
					$respuesta->assign("ape","value",$ape);
				}	
			}
			
			//desabilita los campo e-mail y empresa
			$respuesta->script("document.getElementById('cui').setAttribute('readonly','readonly');");
			$respuesta->script("document.getElementById('nom').setAttribute('readonly','readonly');");
			$respuesta->script("document.getElementById('ape').setAttribute('readonly','readonly');");
			$respuesta->script('document.getElementById("mod").className = "btn-glow primary signup";');
			$respuesta->script('document.getElementById("new").className = "hidden";');
			//mensaje
			$msj = "Su DPI ya existe registrado en nuestro sistema, por favor corrobore y actualice (si es necesario) su correo elect&oacute;nico y haga click en aceptar.  Si uno o mas datos son incorrectos, podr&aacute; actualizarlos en el sistema.";
			$respuesta->assign("alerta","innerHTML",$msj);
			$respuesta->script('document.getElementById("alerta").className = "alert alert-info text-justify";');
		}else{
			$respuesta->script("document.getElementById('mod').removeAttribute('disabled');");
			$respuesta->script('swal("Usuario No Registrado", "Su usuario no est\u00E1 instcrito en el sistema, por favor contacte al personal administrativo.", "error").then((value)=>{ cerrar(); });');
			
         /*$respuesta->script('document.getElementById("mod").className = "hidden";');
			$respuesta->script('document.getElementById("new").className = "btn-glow primary signup";');
			$respuesta->script("cerrar();");*/
		}
	}
   		
   return $respuesta;
}




function Actualizar($codigo,$cui,$mail){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
	$ClsPad = new ClsPadre();
	
	//$respuesta->alert("$codigo,$cui,$mail");
   if($cui != "" && $codigo != "" && $mail != ""){
		//pasa a minusculas
		$mail = strtolower($mail);
		if(ValidarMail($mail)){
			$sql = $ClsUsu->modifica_mail_usuario($codigo,$mail);
			$sql.= $ClsPad->modificar_mail($cui,$mail);
			$rs = $ClsUsu->exec_sql($sql);
			//$respuesta->alert($sql);
			if($rs == 1){
				$hashkey = $ClsUsu->encrypt($codigo, "clave");
				$respuesta->redirect("../CPVALIDA/FRMactivate.php?hashkey=$hashkey",0);
			}else{
				$respuesta->script("document.getElementById('mod').removeAttribute('disabled');");
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}
		}else{
			$respuesta->script("document.getElementById('mod').removeAttribute('disabled');");
         $respuesta->script('swal("Error", "Formato de e-mail inv\u00E1lido...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
   	$respuesta->script("document.getElementById('mod').removeAttribute('disabled');");
      $respuesta->script('swal("Error", "Uno o mas campos estan vacios...", "error").then((value)=>{ cerrar(); });');
	}
   return $respuesta;
}


function Nuevo_Usuario($dpi,$nom,$ape,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
	$ClsPad = new ClsPadre();
	$respuesta->alert("$dpi,$nom,$ape,$mail");
	//pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
		//--
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$ape = utf8_encode($ape);
		//--
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
   if($dpi != "" && $nom != "" && $ape != "" && $mail != ""){
		//pasa a minusculas
		$mail = strtolower($mail);
		if(ValidarMail($mail)){
			//////// CREA PADRE Y ENLAZA A HIJO O HIJOS
			$sql = $ClsPad->insert_padre($dpi,$nom,$ape,'0',$mail,'',''); /// Inserta
			////////// CREA USUARIO
			$pass = Generador_Contrasena();
			$pass = $ClsUsu->decrypt($pass,$mail);
			$id = $ClsUsu->max_usuario();
			$id++; /// Maximo codigo
			$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,'0',3,$dpi,$mail,$pass,1);
			$rs = $ClsPad->exec_sql($sql);
			//$respuesta->alert($sql);
			if($rs == 1){
				$hashkey = $ClsUsu->encrypt($id, "clave");
				$respuesta->redirect("../CPVALIDA/FRMactivate.php?hashkey=$hashkey",0);
			}else{
				$respuesta->script("document.getElementById('new').removeAttribute('disabled');");
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}else{
			$respuesta->script("document.getElementById('new').removeAttribute('disabled');");
         $respuesta->script('swal("Error", "Formato de e-mail inv\u00E1lido...", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
   	$respuesta->script("document.getElementById('new').removeAttribute('disabled');");
      $respuesta->script('swal("Error", "Uno o mas campos estan vacios...", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}




//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- PERDIDA DE PASS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_CUI");
$xajax->register(XAJAX_FUNCTION, "Actualizar");
$xajax->register(XAJAX_FUNCTION, "Nuevo_Usuario");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  