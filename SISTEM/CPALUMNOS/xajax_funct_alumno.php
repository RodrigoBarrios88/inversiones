<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_alumno.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// COMBOS /////////
function Area_Grado($area){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$clase");
	$contenido = Grado_html("",$area,"xajax_Grado_Grupo(document.getElementById('area'),$this.value);");
	$respuesta->assign("sgrado","innerHTML",$contenido);
	
	return $respuesta;
}

function Grado_Grupo($area,$grado){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$area,$grado");
	$contenido = Grupos_Clase_html("",$area,$grado,"");
	$respuesta->assign("sgrupo","innerHTML",$contenido);
	
	return $respuesta;
}

//--
function Nivel_Grado($pensum,$nivel,$idgra,$idsgra,$fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$area,$grado");
	$contenido = grado_html($pensum,$nivel,$idgra,"xajax_Grado_Seccion_Alumno($pensum,$nivel,this.value,'seccion$fila','divsec$fila');");
	$respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Seccion_Alumno($pensum,$nivel,$grado,$idsec,$idssec){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$pensum,$nivel,$grado,$idsec,$idssec");
    $contenido = seccion_html($pensum,$nivel,$grado,"",$idsec,"");
	 $respuesta->assign($idssec,"innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- CLIENTES -----/////////////////////////////////////////////
function Show_Cliente($nit,$fila){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //$respuesta->alert("$nit,$fila");
	if($nit != ""){
		$result = $ClsCli->get_cliente('',$nit,'');
		if(is_array($result)){
			foreach($result as $row){
				$nit = trim($row["cli_nit"]);
				$respuesta->assign("nit$fila","value",$nit);
				$nombre = trim($row["cli_nombre"]);
				$respuesta->assign("clinombre$fila","value",$nombre);
			}
			$respuesta->script("cerrar();");
		}else{
         $respuesta->script("cerrar();");
		}
	}else{
		$respuesta->script("cerrar();");
	}
	
	return $respuesta;
}


function Grabar_Cliente($nit,$nom,$direc,$tel1,$tel2,$mail,$fila){
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
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	 //$respuesta->alert("$nit,$nom,$direc,$tel1,$tel2,$mail,$fila");
    if($nit != "" && $nom != "" && $direc != ""){
		$id = $ClsCli->max_cliente();
		$id++; /// Maximo codigo de Cliente
		//$respuesta->alert("$id");
		$sql = $ClsCli->insert_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail); /// Inserta Cliente
		$rs = $ClsCli->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->assign("cli$fila","value",$id);
			$respuesta->assign("nit$fila","value",$nit);
			$respuesta->assign("cliente$fila","value",$nom);
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   
   return $respuesta;
}


function Modificar_Cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail,$fila){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //limpia cadena
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
				$respuesta->assign("cli$fila","value",$cod);
            $respuesta->assign("nit$fila","value",$nit);
            $respuesta->assign("cliente$fila","value",$nom);
            $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n, refresque la pagina e intente de nuevo...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


//////////////////---- Padres -----/////////////////////////////////////////////
function Filas_Padres($filas,$arrcod,$arrnom,$arrape,$arrtel,$arrmail,$arrexist){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas,$arrpagina,$arrlink");
	$contenido = lista_padres($filas,$arrcod,$arrnom,$arrape,$arrtel,$arrmail,$arrexist);
	$respuesta->assign("divpadres","innerHTML",$contenido);
	$respuesta->script("cerrar();");
	
	return $respuesta;
}


function Buscar_Padre($cui,$fila){
   $respuesta = new xajaxResponse();
   $ClsPad = new ClsPadre();
   //$respuesta->alert("$cui");
   if(trim($cui) != ""){
	   $result = $ClsPad->get_padre($cui);
	   if(is_array($result)){
			foreach($result as $row){
				$cui = $row["pad_cui"];
				$respuesta->assign("dpi$fila","value",$cui);
				$ape = utf8_decode($row["pad_apellido"]);
			   $respuesta->assign("ape$fila","value",$ape);
				$respuesta->script("document.getElementById('ape$fila').setAttribute('readonly', 'readonly');");
				$nom = utf8_decode($row["pad_nombre"]);
				$respuesta->assign("nom$fila","value",$nom);
				$respuesta->script("document.getElementById('nom$fila').setAttribute('readonly', 'readonly');");
				$tel = $row["pad_telefono"];
				$respuesta->assign("tel$fila","value",$tel);
				$respuesta->script("document.getElementById('tel$fila').setAttribute('readonly', 'readonly');");
				$mail = $row["pad_mail"];
				$respuesta->assign("mail$fila","value",$mail);
				$respuesta->script("document.getElementById('mail$fila').setAttribute('readonly', 'readonly');");
            $parentesco = utf8_decode($row["pad_parentesco"]);
            $respuesta->assign("parentesco$fila","value",$parentesco);
			}
			$respuesta->script("document.getElementById('ape$fila').focus();");
			$respuesta->assign("existe$fila","value",1);
	   }else{
			$respuesta->assign("ape$fila","value","");
			$respuesta->script("document.getElementById('ape$fila').removeAttribute('readonly',0);");
			$respuesta->assign("nom$fila","value","");
			$respuesta->script("document.getElementById('nom$fila').removeAttribute('readonly',0);");
			$respuesta->assign("tel$fila","value","");
			$respuesta->script("document.getElementById('tel$fila').removeAttribute('readonly',0);");
			$respuesta->assign("mail$fila","value","");
			$respuesta->script("document.getElementById('mail$fila').removeAttribute('readonly',0);");
		}
   }    
   return $respuesta;
}


//////////////////---- Alumnos -----/////////////////////////////////////////////

function Calcular_Edad($fecnac,$fila){
   $respuesta = new xajaxResponse();
   
	if($fecnac != ""){
		$edad = Calcula_Edad($fecnac);
		$respuesta->assign("edad$fila","value",$edad);
		$respuesta->assign("sedad$fila","innerHTML","$edad  a&ntilde;os");
	}	

   return $respuesta;
}

function Grabar_Alumno($arrcui,$arrcodigo,$arrnombre,$arrapellido,$arrgenero,$arrfecnac,$arrpensum,$arrnivel,$arrgrado,$arrseccion,$arrnit,$arrclinombre,$alumnos,$arrdpi,$arrnom,$arrape,$arrparent,$arrtel,$arrmail,$arrexist,$padres){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
   $ClsAsi = new ClsAsignacion();
   $ClsUsu = new ClsUsuario();
   $ClsPad = new ClsPadre();
	$ClsAcad = new ClsAcademico();
   //$respuesta->alert("$arrcui,$arrcodigo,$arrnombre,$arrapellido,$arrgenero,$arrfecnac,$arrpensum,$arrnivel,$arrgrado,$arrseccion,$arrnit,$arrclinombre,$alumnos,$arrdpi,$arrnom,$arrape,$arrparent,$arrtel,$arrmail,$arrexist,$padres");
   $sql = "";
	///////// Ejecuta primero a los padres para grabarlos y estar disponibles para la asignacion con sus hijos mas abajo
	if($padres > 0){
		$padres_nuevos = 1;
		for($i = 1; $i<= $padres; $i++){
			$dpi = $arrdpi[$i];
			$existe = $arrexist[$i];
			//$respuesta->alert("$existe");
			if($existe != 1){
				$nom = $arrnom[$i];
				$ape = $arrape[$i];
            $parentesco = $arrparent[$i];
				$tel = $arrtel[$i];
				$mail = $arrmail[$i];
	         //pasa a mayusculas
				$nom = trim($nom);
				$ape = trim($ape);
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
				$sql.= $ClsPad->insert_padre($dpi,$nom,$ape,$parentesco,$tel,$mail,'',''); /// Inserta
			    $pass = Generador_Contrasena();
				if($padres_nuevos == 1){
					$id = $ClsUsu->max_usuario();
				}
			    $id++; /// Maximo codigo
			    $sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,3,$dpi,$mail,$pass,1);
			    //$respuesta->alert("Contrasea $pass, CUI $dpi");
				//--------
				$padres_nuevos++;
			}else{
				$dpi = $arrdpi[$i];
				$nom = $arrnom[$i];
				$ape = $arrape[$i];
            $parentesco = $arrparent[$i];
				$tel = $arrtel[$i];
				$mail = $arrmail[$i];
	         //pasa a mayusculas
				$nom = trim($nom);
				$ape = trim($ape);
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
				$sql.= $ClsPad->modifica_padre($dpi,$nom,$ape,$parentesco,$tel,$mail,'','');
			}
		}
	}	
		
	////// graba alumnos, los asigna a grados y a secciones
	if($alumnos > 0){
      $lastCui = "";
		for($i = 1; $i<= $alumnos; $i++){
			$cui = $arrcui[$i];
         $lastCui = $cui;
			$result = $ClsAlu->get_alumno($cui);
			if(!is_array($result)){
				$codigo = $arrcodigo[$i];
				$nombre = $arrnombre[$i];
				$apellido = $arrapellido[$i];
				$genero = $arrgenero[$i];
				$fecnac = $arrfecnac[$i];
				$pensum = $arrpensum[$i];
				$nivel = $arrnivel[$i];
				$grado = $arrgrado[$i];
				$seccion = $arrseccion[$i];
				$nit = $arrnit[$i];
				$clinombre = $arrclinombre[$i];
				//pasa a mayusculas
				$nombre = trim($nombre);
				$apellido = trim($apellido);
				//--------
				//decodificaciones de tildes y Ñ's
				$nombre = utf8_encode($nombre);
				$apellido = utf8_encode($apellido);
				$nombre = utf8_decode($nombre);
				$apellido = utf8_decode($apellido);
				//--------
				$sql.= $ClsAlu->insert_alumno($cui,$codigo,$nombre,$apellido,$fecnac,"Guatemalateco",$genero,$nit,$clinombre,'Ciudad',''); /// Inserta
				$sql.= $ClsAlu->insert_cliente($cui,$nit,$clinombre,$clidireccion); /// Inserta el cliente 
				/////////// --- Asignación a Grado y Sección --- ///////////////
				$codigo = $ClsAcad->max_grado_alumno($pensum,$nivel,$grado,$cui);
				$codigo++;
				$sql.= $ClsAcad->delete_grado_alumno($pensum,$nivel,$cui);
				$sql.= $ClsAcad->insert_grado_alumno($pensum,$nivel,$grado,$codigo,$cui);
				if($seccion != ""){
					$codigo = $ClsAcad->max_seccion_alumno($pensum,$nivel,$grado,$seccion,$cui);
					$codigo++;
					$sql.= $ClsAcad->delete_seccion_alumno($pensum,$cui);
					$sql.= $ClsAcad->insert_seccion_alumno($pensum,$nivel,$grado,$seccion,$codigo,$cui);
				}	
				/////--------------
				for($j = 1; $j<= $padres; $j++){ /// barre de nuevo el array de padres y asigna a los padres y encargados por cada alumno
					$dpi = $arrdpi[$j];
					$sql.= $ClsAsi->asignacion_alumno_padre($dpi,$cui); /// Inserta
				}
			}else{
            foreach($result as $row){
               $ape = utf8_decode($row["alu_apellido"]);
               $nom = utf8_decode($row["alu_nombre"]);
               $nombre = $nom." ".$ape;
            }	
            $respuesta->script('swal("Error", "El alumno '.$nombre.', esta inscrito en el sistema con el n\u00FAmero de CUI '.$cui.'; porfavor verifique a quien pertenece dicho codigo \u00FAnico...", "error").then((value)=>{ cerrar(); });');
            return $respuesta;
			}
		}
	}	

	//$respuesta->alert("$sql");
	$rs = $ClsAlu->exec_sql($sql);
	if($rs == 1){
      $usu = $_SESSION["codigo"];
      $hashkey = $ClsAlu->encrypt($lastCui, $usu);
		$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMmodalumno.php?hashkey='.$hashkey.'"; });');
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}

function Buscar_Alumno($cui){
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
   //$respuesta->alert("$cui");
   $result = $ClsAlu->get_alumno($cui);
   if(is_array($result)){
      foreach($result as $row){
         $cui = $row["alu_cui"];
         $respuesta->assign("cod","value",$cui);
         $codigo = $row["alu_codigo_interno"];
         $respuesta->assign("cod","value",$cui);
         $ape = utf8_decode($row["alu_apellido"]);
         $respuesta->assign("ape","value",$ape);
         $nom = utf8_decode($row["alu_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $tel = $row["alu_telefono"];
         $respuesta->assign("tel","value",$tel);
         $mail = $row["alu_mail"];
         $respuesta->assign("mail","value",$mail);
      }
      //abilita y desabilita botones
      $contenido = tabla_alumnos($cui,$ape,$nom,$usu,$suc,1);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
	}	
   return $respuesta;
}


function Modificar_Alumno($cui,$tipocui,$codigo,$nombre,$apellido,$genero,$fecnac,$religion,$nacionalidad,$idioma,$sangre,$alergico,$emergencia,$emetel,$mail,$recoge,$redesociales,$pensum,$nivel,$grado,$seccion,$nit,$clinombre,$clidireccion,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
	$ClsSeg = new ClsSeguro();
   $ClsAcad = new ClsAcademico();
   
   //pasa a mayusculas
      $cui = trim($cui);
      $tipocui = trim($tipocui);
      $codigo = trim($codigo);
      $nombre = trim($nombre);
      $apellido = trim($apellido);
      $alergico = trim($alergico);
      $poliza = trim($poliza);
      $aseguradora = trim($aseguradora);
      $plan = trim($plan);
      $asegurado = trim($asegurado);
      $instrucciones = trim($instrucciones);
      $comentarios = trim($comentarios);
      //--//
      $nacionalidad = trim($nacionalidad);
      $religion = trim($religion);
      $idioma = trim($idioma);
      $mail = trim($mail);
      //--//
      $nit = trim($nit);
      $clinombre = trim($clinombre);
      $clidireccion = trim($clidireccion);
   //--------
   //decodificaciones de tildes y Ñ's
      $nombre = utf8_encode($nombre);
      $apellido = utf8_encode($apellido);
      $alergico = utf8_encode($alergico);
      $poliza = utf8_encode($poliza);
      $aseguradora = utf8_encode($aseguradora);
      $plan = utf8_encode($plan);
      $asegurado = utf8_encode($asegurado);
      $instrucciones = utf8_encode($instrucciones);
      $comentarios = utf8_encode($comentarios);
      //--//
      $nacionalidad = utf8_encode($nacionalidad);
      $religion = utf8_encode($religion);
      $idioma = utf8_encode($idioma);
      $recoge = utf8_encode($recoge);
      //--//
      $nit = utf8_encode($nit);
      $clinombre = utf8_encode($clinombre);
      $clidireccion = utf8_encode($clidireccion);
      //--
      $nombre = utf8_decode($nombre);
      $apellido = utf8_decode($apellido);
      $alergico = utf8_decode($alergico);
      $poliza = utf8_decode($poliza);
      $aseguradora = utf8_decode($aseguradora);
      $plan = utf8_decode($plan);
      $asegurado = utf8_decode($asegurado);
      $instrucciones = utf8_decode($instrucciones);
      $comentarios = utf8_decode($comentarios);
      //--//
      $nacionalidad = utf8_decode($nacionalidad);
      $religion = utf8_decode($religion);
      $idioma = utf8_decode($idioma);
      $recoge = utf8_decode($recoge);
      //--//
      $nit = utf8_decode($nit);
      $clinombre = utf8_decode($clinombre);
      $clidireccion = utf8_decode($clidireccion);
   //
   if($cui != "" && $tipocui != "" && $nombre != "" && $apellido != "" && $genero != "" && $fecnac != "" && $nivel != "" && $grado != "" && $nit != "" && $clinombre != "" && $clidireccion != ""){
      $sql.= $ClsAlu->modifica_alumno($cui,$tipocui,$codigo,$nombre,$apellido,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emetel,$mail,$recoge,$redesociales); /// modificar;
      $sql.= $ClsAlu->modificar_cliente($cui,$nit,$clinombre,$clidireccion);
       $get_cliente = $ClsAlu->get_cliente('',$nit);
          if(is_array($get_cliente)){
            $sql.= $ClsAlu->modificar_cliente($cui,$nit,$clinombre,$clidireccion);   
          }else{
            $sql.= $ClsAlu->insert_cliente($cui,$nit,$clinombre,$clidireccion);
          }
      $sql.= $ClsSeg->update_seguro($cui,$seguro,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios);
      /////////// --- Asignación a Grado y Sección --- ///////////////
      $codgrado = $ClsAcad->max_grado_alumno($pensum,$nivel,$grado,$cui);
      $codgrado++;
      $sql.= $ClsAcad->delete_grado_alumno($pensum,$nivel,$cui);
      $sql.= $ClsAcad->insert_grado_alumno($pensum,$nivel,$grado,$codgrado,$cui);
      if($seccion != ""){
         $codgrado = $ClsAcad->max_seccion_alumno($pensum,$nivel,$grado,$seccion,$cui);
         $codgrado++;
         $sql.= $ClsAcad->delete_seccion_alumno($pensum,$cui);
         $sql.= $ClsAcad->insert_seccion_alumno($pensum,$nivel,$grado,$seccion,$codgrado,$cui);
      }
      
      //$respuesta->alert("$sql");
      $rs = $ClsAlu->exec_sql($sql);
      if($rs == 1){
         $usu = $_SESSION["codigo"];
         $hashkey = $ClsAlu->encrypt($cui, $usu);
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMmodalumno.php?hashkey='.$hashkey.'"; });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n, hay parametros obligatorios vacios...", "error").then((value)=>{ cerrar(); });');
   }
	
   return $respuesta;
}




function Situacion_Alumno($cui,$sit){
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();

	if($cui != ""){
      if($sit == 2){
         $sql = $ClsAlu->cambia_sit_alumno($cui,$sit);
         //$respuesta->alert("$sql");
         $rs = $ClsAlu->exec_sql($sql);
         if($rs == 1){
           $respuesta->script('swal("Excelente!", "Alumno inhabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
           $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         }	
      }else if($sit == 1){
         $sql = $ClsAlu->cambia_sit_alumno($cui,$sit);
         //$respuesta->alert("$sql");
         $rs = $ClsAlu->exec_sql($sql);
         if($rs == 1){
            $respuesta->script('swal("Excelente!", "Alumno Re-Activada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         }	
      }
	}

	return $respuesta;
}


function Agregar_Padre($cui,$dpi,$nom,$ape,$parentesco,$tel,$mail,$existe){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
   $ClsAsi = new ClsAsignacion();
   $ClsUsu = new ClsUsuario();
   $ClsPad = new ClsPadre();
	//$respuesta->alert("$cui,$dpi,$nom,$ape,$parent,$tel,$mail,$exist,$padres");
   $sql = "";
	///////// Ejecuta primero a los padres para grabarlos y estar disponibles para la asignacion con sus hijos mas abajo
	if($existe != 1){
      //pasa a mayusculas
      $nom = trim($nom);
      $ape = trim($ape);
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
      $sql.= $ClsPad->insert_padre($dpi,$nom,$ape,$parentesco,$tel,$mail,'',''); /// Inserta
      $pass = Generador_Contrasena();
      $id = $ClsUsu->max_usuario();
      $id++; /// Maximo codigo
      $sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,3,$dpi,$mail,$pass,1);
      //$respuesta->alert("Contrasea $pass, CUI $dpi");
      $sql.= $ClsAsi->asignacion_alumno_padre($dpi,$cui); /// Inserta
   }else{
      $sql.= $ClsAsi->asignacion_alumno_padre($dpi,$cui); /// Inserta
   }
		
	//$respuesta->alert("$sql");
	$rs = $ClsAsi->exec_sql($sql);
	if($rs == 1){
      $usu = $_SESSION["codigo"];
      $hashkey = $ClsAsi->encrypt($cui, $usu);
		$respuesta->script('swal("Excelente!", "Padre anclado satisfactoriamente!!!", "success").then((value)=>{ window.history.back(); });');
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}



function Desligar_Padre($alumno,$padre){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();

	//$respuesta->alert("$cui,$sit");
	if($alumno != "" && $padre != ""){
		$sql = $ClsAsi->desasignacion_alumno_padre($padre,$alumno);
		//$respuesta->alert("$sql");
		$rs = $ClsAsi->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Padre, Madre o Encargado desligado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

	return $respuesta;
}


////////////////////////// ASIGNACION DE GRUPOS Y ALUMNOS ////////

function Area_Grupos($area,$grupos){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$area,'$grupos'");
      $contenido = grupos_no_alumno_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      $respuesta->script("cerrar();");
	  
   return $respuesta;
}



function Graba_Alumno_Grupos($alumno,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   if($alumno != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
         $sql.= $ClsAsi->asignacion_alumno_grupo($grupos[$i],$alumno);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
         $respuesta->script("Busca_Grupos_Alumno('$alumno',$area);");
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Quitar_Alumno_Grupos($alumno,$area,$grupos,$filas){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   if($alumno != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
         //$respuesta->alert("$grupos[$i],$alumno");   
         $sql.= $ClsAsi->desasignacion_alumno_grupo($grupos[$i],$alumno);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsAsi->exec_sql($sql);
      if($rs == 1){
         $respuesta->script("Busca_Grupos_Alumno('$alumno',$area);");
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


function Grupos_Alumno($alumno,$area){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$alumno,$area");
   if($alumno != ""){
      $result = $ClsAsi->get_alumno_grupo("",$alumno,1);
      if(is_array($result)){
         $grupos = "";
         foreach($result as $row){
            $grupos.= $row["gru_codigo"].",";
         }
         $grupos = substr($grupos, 0, strlen($grupos) - 1);
      }
      /// Setea listas de puntos
      $contenido = grupos_no_alumno_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      
      $contenido = grupos_alumno_lista_multiple("asignados",$alumno);
      $respuesta->assign("divasignados","innerHTML",$contenido);
      
      $respuesta->script("cerrar();");
   }else{
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}




//////////////////---- COMENTARIOS PSICOSOCIALES -----/////////////////////////////////////////////
function Grabar_Comentario($cui,$pensum,$nivel,$grado,$seccion,$comentario){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();
   //pasa a mayusculas
		$comentario = trim($comentario);
	//--------
	//decodificaciones de tildes y Ñ's
		$comentario = utf8_encode($comentario);
		//--
		$comentario = utf8_decode($comentario);
	//--------
	//$respuesta->alert("$cui,$pensum,$nivel,$grado,$seccion,$comentario");
	if($comentario != ""){
		$codigo = $ClsAcadem->max_comentario_psicopedagogico($cui);
		$codigo++;
		$sql = $ClsAcadem->insert_comentario_psicopedagogico($codigo,$cui,$pensum,$nivel,$grado,$seccion,$comentario);
		//$respuesta->alert("$sql");
		$rs = $ClsAcadem->exec_sql($sql);

		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}	

   return $respuesta;

}


function Buscar_Comentario($codigo,$alumno){
   $respuesta = new xajaxResponse();
  $ClsAcadem = new ClsAcademico();
   //$respuesta->alert("$cod");
	$result = $ClsAcadem->get_comentario_psicopedagogico($codigo,$alumno);
   if(is_array($result)){
      foreach($result as $row){
         $cod = $row["psi_codigo"];
         $respuesta->assign("cod","value",$cod);
         $alumno = $row["psi_alumno"];
         $respuesta->assign("cui","value",$alumno);
         $coment = utf8_decode($row["pis_comentario"]);
         $respuesta->assign("coment","value",$coment);
      }
      //abilita y desabilita botones
      $respuesta->script("cerrar();");
   }	

   return $respuesta;

}


function Modificar_Comentario($codigo,$cui,$comentario){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();

   //pasa a mayusculas
		$comentario = trim($comentario);
	//--------
	//decodificaciones de tildes y Ñ's
		$comentario = utf8_encode($comentario);
		//--
		$comentario = utf8_decode($comentario);
	//--------
	//$respuesta->alert("$cod,$dia,$desc,$desc,$marca");
    if($codigo != ""){
		if($comentario != ""){
			$sql = $ClsAcadem->update_comentario_psicopedagogico($codigo,$cui,$comentario);
			//$respuesta->alert("$sql");
			$rs = $ClsAcadem->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->alert("Error de Traslación..., refresque la pagina e intente de nuevo");
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


function Situacion_Comentario($codigo,$cui){
   $respuesta = new xajaxResponse();
   $ClsAcadem = new ClsAcademico();

    //$respuesta->alert("$diap,$tipo");
    if($codigo != "" && $cui){
      $sql = $ClsAcadem->cambia_comentario_psicopedagogico($codigo,$cui,0);
      //$respuesta->alert("$sql");
      $rs = $ClsAcadem->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Comentario Desactivada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
	}

	return $respuesta;
}


//////////////////---- COMBOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Area_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Grupo");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Seccion_Alumno");
//////////////////---- CLIENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");
//////////////////---- PADRES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Filas_Padres");
$xajax->register(XAJAX_FUNCTION, "Buscar_Padre");
//////////////////---- ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Calcular_Edad");
$xajax->register(XAJAX_FUNCTION, "Grabar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Buscar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Modificar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Situacion_Alumno");
$xajax->register(XAJAX_FUNCTION, "Agregar_Padre");
$xajax->register(XAJAX_FUNCTION, "Desligar_Padre");
////////////////////////// ASIGNACION DE GRUPOS Y ALUMNOS ////////
$xajax->register(XAJAX_FUNCTION, "Area_Grupos");
$xajax->register(XAJAX_FUNCTION, "Graba_Alumno_Grupos");
$xajax->register(XAJAX_FUNCTION, "Quitar_Alumno_Grupos");
$xajax->register(XAJAX_FUNCTION, "Grupos_Alumno");
//////////////////---- COMENTARIOS PSICOSOCIALES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Comentario");
$xajax->register(XAJAX_FUNCTION, "Buscar_Comentario");
$xajax->register(XAJAX_FUNCTION, "Modificar_Comentario");
$xajax->register(XAJAX_FUNCTION, "Situacion_Comentario");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  