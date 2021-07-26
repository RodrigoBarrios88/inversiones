<?php
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_usuarios.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- USUARIO -----/////////////////////////////////////////////
function Grabar_Usuario($nom,$mail,$tel,$usu,$pass,$tipo,$cambio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
     //pasa a mayusculas
     $nom = trim($nom);
     //--------
     //decodificaciones de tildes y �'s
     $nom = utf8_encode($nom);
     //--
     $nom = utf8_decode($nom);
     //--------
     //pasa a minuscula
     $mail = strtolower($mail);
     //--------
    if($nom != "" && $tipo != "" && $usu != "" && $pass != "" && $mail != ""){
		$mc = comprobar_email($mail);
		if($mc > 0){
			$cont = $ClsUsu->count_usuario("","","","","","",$usu);
			if($cont == 0){
				$id = $ClsUsu->max_usuario();
				$id++; /// Maximo codigo
				$sql = $ClsUsu->insert_usuario($id,$nom,$nom,$mail,$tel,$tipo,0,$usu,$pass,$cambio);
				$rs = $ClsUsu->exec_sql($sql);
				//$respuesta->alert("$sql");
				if($rs == 1){
					$contenido = tabla_usuarios($id,$tipo,$nom,$niv,$sit);
					$respuesta->assign("result","innerHTML",$contenido);
					$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMusuarios.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
					$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
				}
			}else{
				$msj = '<h5>El Nombre de Usuario ya esta asignado a otra persona, busque otra nombre...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->assign("usu","style.borderColor","red");
				$respuesta->assign("usu","style.backgroundColor","#F8E0E0");
				$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			}
		}else{
			$msj = '<h5>Formato de e-mail incorrecto...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("mail","style.borderColor","red");
			$respuesta->assign("mail","style.backgroundColor","#F8E0E0");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
	}

   return $respuesta;
}



function Buscar_Usuario($id){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   //$respuesta->alert("$id");
		$cont = $ClsUsu->count_usuario($id,$tipo,$nom,$mail,$nivel,$band,$sit);
		if($cont>0){
			if($cont==1){
				$result = $ClsUsu->get_usuario($id,$tipo,$nom,$mail,$nivel,$band,$sit);
				foreach($result as $row){
					$id = $row["usu_id"];
					$respuesta->assign("cod","value",$id);
					$tipo = $row["usu_tipo"];
					$respuesta->assign("tipo","value",$tipo);
					$nombre = utf8_decode($row["usu_nombre"]);
					$respuesta->assign("nom","value",$nombre);
					$usu = $row["usu_usuario"];
					$respuesta->assign("usu","value",$usu);
					$mail = $row["usu_mail"];
					$respuesta->assign("mail","value",$mail);
					$tel = $row["usu_telefono"];
					$respuesta->assign("tel","value",$tel);
					$avi = $row["usu_avilita"];
					if($avi==0){
						$respuesta->script("document.getElementById('avi').checked = true;");
					}else{
						$respuesta->script("document.getElementById('avi').checked = false;");
					}
					$cambio = $row["usu_cambio"];
					if($cambio == 0){
						$respuesta->script("document.getElementById('cambio1').checked = false;");
						$respuesta->script("document.getElementById('cambio2').checked = true;");
					}else{
						$respuesta->script("document.getElementById('cambio2').checked = false;");
						$respuesta->script("document.getElementById('cambio1').checked = true;");
					}
					// indica si la cuenta se bloqueo por seguridad al intentar entrar mas de las veces permitidas con una contrase�a incorrecta
					$seg = $row["usu_seguridad"];
					if($seg==0){
						$respuesta->script("document.getElementById('seg').checked = false;");
					}else{
						$respuesta->script("document.getElementById('seg').checked = true;");
						$respuesta->script("document.getElementById('seg').removeAttribute('disabled');");
					}
				}
			}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('avi').removeAttribute('disabled');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");

			$contenido = tabla_usuarios($id,$tipo,$nom,$nivel,$sit);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
	   	}
    return $respuesta;
}


function Modificar_Usuario($id,$tipo,$nom,$mail,$tel,$usu,$pass,$avi,$seg,$cambio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
		//$respuesta->alert("$id,$tipo,$nom,$mail,$tel,$niv,$sit,$usu,$pass,$avi,$seg");
	    //--------
	    if($id != ""){
			$mc = comprobar_email($mail);
			if($mc > 0){
				//$respuesta->alert("$avi,$seg");
				$cont = $ClsUsu->comprueba_nusuario($id,$usu);
				if($cont == 0){
					$sql = $ClsUsu->modifica_usuario($id,$nom,$tipo,$mail,$tel,$usu,$pass,$avi,$seg,$cambio);
					$rs = $ClsUsu->exec_sql($sql);
					//$respuesta->alert("$sql");
					if($rs == 1){
						$respuesta->assign("result","innerHTML",$contenido);
						$msj = '<h5>Registros Modificados Satisfactoriamente!!!</h5><br><br>';
						$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMusuarios.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
						$respuesta->assign("lblparrafo","innerHTML",$msj);
						$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
						$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
					}else{
						$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
						$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						$respuesta->assign("lblparrafo","innerHTML",$msj);
						$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
					}
				}else{
					$msj = '<h5>El Nombre de Usuario ya esta asignado a otra persona, busque otra nombre...</h5><br><br>';
					$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					$respuesta->assign("lblparrafo","innerHTML",$msj);
					$respuesta->assign("usu","style.borderColor","red");
					$respuesta->assign("usu","style.backgroundColor","#F8E0E0");
					$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
				}
			}else{
				$msj = '<h5>Formato de e-mail incorrecto...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->assign("mail","style.borderColor","red");
				$respuesta->assign("mail","style.backgroundColor","#F8E0E0");
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}
	    }else{
		    $respuesta->alert("Error de Traslaci�n..., refresque la pagina e intente de nuevo");
		    $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		    $respuesta->script("cerrar();");
	    }

   return $respuesta;
}


function Ver_Usuarios($tipo,$nom,$usu,$sit,$acc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	    //$respuesta->alert("$tipo,$nom,$usu,$sit,$acc");
		$contenido = tabla_busca_usuarios($tipo,$nom,$usu,$sit,$acc);
		$respuesta->assign("cuerpo","innerHTML",$contenido);
		$respuesta->script("cerrarModal();");

   return $respuesta;
}

function Ver_Info_Usuario($cod,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
  		$contenido = tabla_info_usuarios($cod,$fila);
		$respuesta->assign("idusu$fila","innerHTML",$contenido);
		$respuesta->script("cerrar();");

   return $respuesta;
}

function Cerrar_Info($fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$respuesta->assign("idusu$fila","innerHTML","");
	return $respuesta;
}


function CambiaSit_Usuario($cod,$sit){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
   if($cod != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsUsu->cambia_sit_usuario($cod,$sit);
		$rs = $ClsUsu->exec_sql($sql);
		if($rs == 1){
			$contenido = tabla_busca_usuarios($tipo,$nom,$usu,"",3);
			$respuesta->assign("cuerpo","innerHTML",$contenido);
			$msj = '<h5>Cambio de Situaci�n Satisfactorio!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrarModal();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}
		//$respuesta->script("cerrarMixPromt();");
	}

   return $respuesta;
}


////////////----- ASIGNACION DE PERMISOS -------///////////////////////////////////

function Cuadro_Roles_Usuario($usu){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
		$contenido = tabla_encabezado_asignacion($usu);
		$contenido.= '<div id = "result" align = "center" ></div>';
		$contenido.= tabla_botones_asignacion();
		$respuesta->assign("cuerpo","innerHTML",$contenido);
		$respuesta->script("cerrar();");

   return $respuesta;
}

function Cuadro_Permisos_Rol($roll){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
    if($roll != 0){
		$contenido = tabla_permisos_roll($roll);
	}else{
		$contenido = tabla_permisos_libre();
	}
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar();");

   return $respuesta;
}

function Asignar_Permisos($usu,$rol,$arrperm,$arrgru,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPerm = new ClsPermiso();
   $ClsUsu = new ClsUsuario();
    if($usu != "" && $rol != "" && $cant != ""){
		$sql = $ClsPerm->delet_perm_asignacion($usu);
		for($i = 1; $i <= $cant; $i++){
			$perm = $arrperm[$i];
			$grupo = $arrgru[$i];
			$sql.= $ClsPerm->insert_perm_asignacion($usu,$rol,$perm,$grupo);
		}
		//$respuesta->alert($sql);
		$rs = $ClsPerm->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Permisos Asignados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location=\'FRMusuarios.php\'" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}

   return $respuesta;
}


function Ver_Usu_Perm($cod,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
  		$contenido = tabla_ver_permisos_usu($fila,$cod);
		$respuesta->assign("idusu$fila","innerHTML",$contenido);
		$respuesta->script("cerrar();");

   return $respuesta;
}


function Ver_Usu_Hist($cod,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
  		$contenido = tabla_hist_permisos_usu($fila,$cod);
		$respuesta->assign("idusu$fila","innerHTML",$contenido);
		$respuesta->script("cerrar();");

   return $respuesta;
}


////////////----- PERDIDA DE PASS -------///////////////////////////////////
function Buscar_Pregunta_C($tipo,$mail){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsUsu = new ClsUsuario();
	//$respuesta->alert("$tipo,$mail");
    if($mail != "" || $tipo != ""){
		$mc = comprobar_email($mail);
		if($mc > 0){
			$result = $ClsUsu->get_usuario('','',$mail,$tipo,'',1,'');
			//$respuesta->alert("$result");
			if(is_array($result)){
					foreach($result as $row){
						$cod = $row["usu_id"];
						$respuesta->assign("cod","value",$cod);
						$usu = $row["usu_usuario"];
						$respuesta->assign("usu","value",$usu);
						$preg = utf8_decode($row["usu_pregunta"]);
						$respuesta->assign("preg","value",$preg);
						$respuesta->script("document.getElementById('preg1').style.display = 'block';");
						$respuesta->script("document.getElementById('preg2').style.display = 'block';");
						$respuesta->script("document.getElementById('resp1').style.display = 'block';");
						$respuesta->script("document.getElementById('resp2').style.display = 'block';");
						$respuesta->script("document.getElementById('bot1').className = 'btn btn-primary hidden';");
						$respuesta->script("document.getElementById('bot2').className = 'btn btn-success';");
						//desabilita los campo e-mail y empresa
						$respuesta->script("document.getElementById('mail').setAttribute('disabled','disabled');");
						$respuesta->script("document.getElementById('suc').setAttribute('disabled','disabled');");
					}
					$respuesta->script("cerrar();");
			}else{
				$msj = '<h5>No se registran Usuarios con estos criterios de busqueda!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<h5>Formato de e-mail incorrecto...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("mail","style.borderColor","red");
			$respuesta->assign("mail","style.backgroundColor","#F8E0E0");
		}
	}

   return $respuesta;
}

/////////////------ ALUMNOS ----------------------////////////////////////////////

function Grabar_Usuario_Alumno($cui){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
	$ClsUsu = new ClsUsuario();
	//pasa a mayusculas
		$cui = trim($cui);
	//--------
   if($cui != ""){
		$result = $ClsAlu->get_alumno($cui);
      if(is_array($result)){
         foreach($result as $row){
            $cui = trim($row["alu_cui"]);
            $nombre = trim($row["alu_nombre"]);
            $apellido = trim($row["alu_apellido"]);
            $mail = trim($row["alu_mail"]);
            $telefono = trim($row["alu_emergencia_telefono"]);
            $pass_claro = "123456";
         }
         if(strlen($mail) > 0){
            $cont = $ClsUsu->count_usuario("","","","","","",$mail);
            if($cont == 0){
               $result_cui = $ClsUsu->get_usuario_tipo_codigo('',$cui);
               if(!is_array($result_cui)){
                  $id = $ClsUsu->max_usuario();
                  $id++; /// Maximo codigo
                  $sql = $ClsUsu->insert_usuario($id,"$nombre $apellido","$nombre $apellido",$mail,$telefono,10,$cui,$mail,$pass_claro,1);
                  //$respuesta->alert("$sql");
                  $rs = $ClsUsu->exec_sql($sql);
                  if($rs == 1){
                     $respuesta->script('swal("Excelente!", "Usuario creado satisfactoriamente!", "success");');
                  }else{
                     $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
                  }
               }else{
                  $respuesta->script('swal("Usuario Existente", "Este alumno ya tiene un usuario generado, por lo tanto no puede generarse otro usuario... ", "warning").then((value)=>{ cerrar(); });');
               }
            }else{
               $respuesta->script('swal("Alto", "Este correo ya fue usado para generar un usuario...", "warning").then((value)=>{ cerrar(); });');
            }
         }else{
            $respuesta->script('swal("No tiene Correo", "Este alumno no tiene correo registrado a\u00FAn, por lo tanto no puede generarse su usuario... ", "warning").then((value)=>{ cerrar(); });');
         }
      }
	}

   return $respuesta;
}



//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- USUARIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Usuario");
$xajax->register(XAJAX_FUNCTION, "Buscar_Usuario");
$xajax->register(XAJAX_FUNCTION, "Modificar_Usuario");
$xajax->register(XAJAX_FUNCTION, "Ver_Usuarios");
$xajax->register(XAJAX_FUNCTION, "Ver_Info_Usuario");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Info");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Usuario");

//////////////////---- ASIGNACION DE PERMISOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Cuadro_Roles_Usuario");
$xajax->register(XAJAX_FUNCTION, "Cuadro_Permisos_Rol");
$xajax->register(XAJAX_FUNCTION, "Asignar_Permisos");
$xajax->register(XAJAX_FUNCTION, "Ver_Usu_Perm");
$xajax->register(XAJAX_FUNCTION, "Ver_Usu_Hist");

//////////////////---- PERDIDA DE PASS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Pregunta_C");
///////////////------- ALUMNOS -------//////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Usuario_Alumno");
//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>
