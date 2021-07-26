<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_chat.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- Usuarios -----/////////////////////////////////////////////
function Grabar_Usuario($usuario,$cui,$nombre,$titulo,$mail,$hini,$hfin,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   $ClsChat = new ClsChat();
   //pasa a mayusculas
		$nombre = trim($nombre);
		$titulo = trim($titulo);
		$hini = trim($hini);
      $hfin = trim($hfin);
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
      $titulo = utf8_encode($titulo);
		//--
		$nombre = utf8_decode($nombre);
      $titulo = utf8_decode($titulo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    
   if($cui !="" && $nombre !="" && $titulo != "" && $mail != ""){
      $count = $ClsChat->count_cm($cui);
      if($count == 0){
         //$respuesta->alert("$id");
         $sql = $ClsChat->insert_cm($cui,$nombre,$titulo,$mail,$hini,$hfin,$obs); /// Inserta
         $sql.= $ClsUsu->modificar_campo($usuario,"usu_nombre_pantalla",$nombre);
         //$respuesta->alert("$sql");
         $rs = $ClsChat->exec_sql($sql);
         if($rs == 1){
            $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMusuario.php" });');
         }else{
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
            $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
            $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
         }
      }else{
         $respuesta->script('swal("Alto", "Ya existe un usuario de Chat con este CUI, por favor edite datos en lugar de crear uno nuevo...", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }
	}
   
   return $respuesta;
}


function Buscar_Usuario($cui){
   $respuesta = new xajaxResponse();
   $ClsChat = new ClsChat();
   //$respuesta->alert("$cui");
   $result = $ClsChat->get_cm($cui);
   if(is_array($result)){
      foreach($result as $row){
         $usuario = $row["usu_id"];
         $respuesta->assign("usuario","value",$usuario);
         $usunombre = utf8_decode($row["usu_nombre"]);
         $respuesta->assign("usunombre","value",$usunombre);
         //--
         $cui = $row["cm_cui"];
         $respuesta->assign("cui","value",$cui);
         $nombre = utf8_decode($row["cm_nombre"]);
         $respuesta->assign("nombre","value",$nombre);
         $titulo = utf8_decode($row["cm_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $mail = $row["cm_mail"];
         $respuesta->assign("mail","value",$mail);
         $hini = utf8_decode($row["cm_hora_ini"]);
         $respuesta->assign("hini","value",$hini);
         $hfin = $row["cm_hora_fin"];
         $respuesta->assign("hfin","value",$hfin);
         $obs = utf8_decode($row["cm_observaciones"]);
         $respuesta->assign("obs","value",$obs);
      }
      //abilita y desabilita botones
      $contenido = tabla_usuarios($cui,'',1);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Usuario($usuario,$cui,$nombre,$titulo,$mail,$hini,$hfin,$obs){
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   $ClsChat = new ClsChat();
   //pasa a mayusculas
		$nombre = trim($nombre);
		$titulo = trim($titulo);
		$hini = trim($hini);
      $hfin = trim($hfin);
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
      $titulo = utf8_encode($titulo);
		//--
		$nombre = utf8_decode($nombre);
      $titulo = utf8_decode($titulo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cui != ""){
		if($nombre !="" && $titulo != "" && $mail != ""){
			$sql = $ClsChat->modifica_cm($cui,$nombre,$titulo,$mail,$hini,$hfin,$obs);
         $sql.= $ClsUsu->modificar_campo($usuario,"usu_nombre_pantalla",$nombre);
			//$respuesta->alert("$sql");
			$rs = $ClsChat->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMusuario.php" });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			   $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			   $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
	   $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Usuario($cui,$situacion){
   $respuesta = new xajaxResponse();
   $ClsChat = new ClsChat();

   if($cui != ""){
      $sql = $ClsChat->cambia_situacion_cm($cui,$situacion);
      //$respuesta->alert("$sql");
      $rs = $ClsChat->exec_sql($sql);
      if($rs == 1){
         if($sit == 0){
            $respuesta->script('swal("Ok", "Usuario inhabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Excelente!", "Usuario re-activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }	
   }

	return $respuesta;
}


////////////////////////// ASIGNACION DE GRADOS ////////

function Graba_Usuario_Grado($usuario,$pensum,$nivel,$arrcodigos){
   $respuesta = new xajaxResponse();
   $ClsChat = new ClsChat();
   if($usuario != ""){
	   $sql = "";
      $sql.= $ClsChat->delete_grado_usuarios($pensum,$nivel,$usuario);
      if(is_array($arrcodigos)){
         $count = count($arrcodigos); //cuenta cuantas vienen en el array
         for($i = 0; $i < $count; $i++){
            /////////---------------
            $codigo = $arrcodigos[$i];
            //--
            $separa = explode("|",$codigo);
            $nivel = $separa[0];
            $grado = $separa[1];
            $sql.= $ClsChat->insert_grado_usuarios($pensum,$nivel,$grado,$usuario);
         }
      }
      //$respuesta->alert("$sql");
      $rs = $ClsChat->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Secciones asignadas satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}



//////////////////---- MAESTROS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Usuario");
$xajax->register(XAJAX_FUNCTION, "Buscar_Usuario");
$xajax->register(XAJAX_FUNCTION, "Modificar_Usuario");
$xajax->register(XAJAX_FUNCTION, "Situacion_Usuario");
////////////////////////// ASIGNACION DE GRDOS ////////
$xajax->register(XAJAX_FUNCTION, "Graba_Usuario_Grado");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  