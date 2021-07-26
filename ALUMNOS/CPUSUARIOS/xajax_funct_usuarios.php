<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_usuarios.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

////////////----- PERDIDA DE PASS -------///////////////////////////////////
function Buscar_Pregunta_C($mail){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
	//$respuesta->alert("$tipo,$mail");
    if($mail != ""){
		$mc = comprobar_email($mail);
		if($mc > 0){
			$result = $ClsUsu->get_usuario('','',$mail,3,'',1,''); /// tipo 3 -> Padres
			//$respuesta->alert("$result");
			if(is_array($result)){
					foreach($result as $row){
						$cod = $row["usu_id"];
						$respuesta->assign("cod","value",$cod);
						$usu = $row["usu_usuario"];
						$respuesta->assign("usu","value",$usu);
						$preg = utf8_decode($row["usu_pregunta"]);
						$respuesta->assign("preg","value",$preg);
						$respuesta->Script("document.getElementById('preg1').style.display = 'block';");
						$respuesta->Script("document.getElementById('preg2').style.display = 'block';");
						$respuesta->Script("document.getElementById('resp1').style.display = 'block';");
						$respuesta->Script("document.getElementById('resp2').style.display = 'block';");
						$respuesta->Script("document.getElementById('bot1').className = 'btn btn-primary hidden';");
						$respuesta->Script("document.getElementById('bot2').className = 'btn btn-success';");
						//desabilita los campo e-mail y empresa
						$respuesta->Script("document.getElementById('mail').setAttribute('disabled','disabled');");
						$respuesta->Script("document.getElementById('suc').setAttribute('disabled','disabled');");
					}
					$respuesta->Script("cerrar()");
			}else{
				$msj = '<h5>No se registran Usuarios con estos criterios de busqueda!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<h5>Formato de e-mail incorrecto...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("mail","style.borderColor","red");
			$respuesta->assign("mail","style.backgroundColor","#F8E0E0");
		}
	}
   		
   return $respuesta;
}


function Activa_Usuario($codigo,$nombre_pantalla,$mail,$tel,$usu,$pass,$preg,$resp){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
		//$respuesta->alert("$id,$tipo,$nom,$mail,$tel,$niv,$sit,$usu,$pass,$avi,$seg");
	    //--------
	if($codigo != ""){
		$sql = "";
      $sql.= $ClsUsu->modifica_pass($codigo,$usu,$pass);
      $sql.= $ClsUsu->modifica_perfil($codigo,$nombre_pantalla,$mail,$tel);
      $sql.= $ClsUsu->cambia_usu_avilita($codigo,1);
      //echo $sql;
      if($preg != "" && $resp != ""){
         $sql.=$ClsUsu->cambia_pregunta($codigo,$usu,$preg,$resp);	//modifica solo si el usuario prefiere cambiar su pregunta clave
      }
      $rs = $ClsUsu->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Contrase\u00F1a actualizada satisfactoriamente!", "success").then((value)=>{ window.location.href="../menu.php"; });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
	}else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}

//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- PERDIDA DE PASS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Pregunta_C");
$xajax->register(XAJAX_FUNCTION, "Activa_Usuario");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  