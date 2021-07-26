<?php
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_boleta.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Combo_Cuenta_Banco($ban,$cue,$scue,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$ban,$cue,$scue,$acc");
	$contenido = cuenta_banco_html($ban,$cue,$acc);
	$respuesta->assign($scue,"innerHTML",$contenido);

	return $respuesta;
}


function Nivel_Grado($pensum,$nivel,$idgra,$idsgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$area,$grado");
	$contenido = grado_html($pensum,$nivel,$idgra,"");
	$respuesta->assign($idsgra,"innerHTML",$contenido);

	return $respuesta;
}


//////////////////---- Movimientos de Cuenta -----/////////////////////////////////////////////

function Grabar_Boleta_Cobro($periodo,$division,$grupo,$alumno,$codalumno,$referencia,$tipo,$monto,$motivo,$tipodesc,$desc,$motdesc,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   //$respuesta->alert("$division,$grupo,$alumno,$referencia,$monto,$motivo,$fecha");
		$codigo = $ClsBol->max_boleta_cobro($division,$grupo);
		$codigo++;
      ///Numero auntomatico de boleta
      if($referencia == ""){
         //--- repmplazado por el $documento (procedimiento manual)
         $referencia = $codigo;
      }
		//Query
      $motivo = utf8_encode($motivo);
      $motdesc = utf8_encode($motdesc);
      //--
      $motivo = utf8_decode($motivo);
      $motdesc = utf8_decode($motdesc);
      //--
      if($tipodesc == "M"){
         $descuento = $desc;
      }else if($tipodesc == "P"){
         $descuento = ($monto * $desc)/100;
      }
      $monto = ($monto - $descuento);
      $monto = number_format($monto, 2, '.', '');
      $descuento = number_format($descuento, 2, '.', '');
      $sql.= $ClsBol->insert_boleta_cobro($codigo,$periodo,$division,$grupo,$alumno,$codalumno,$referencia,$tipo,$monto,$motivo,$descuento,$motdesc,$fecha);
      if($tipo == "M"){ // Si la boleta es de Mora
         $ClsMora = new ClsMora();
         //grupo de mora
         $grupo = $ClsMora->max_grupo_mora();
         $grupo++;
         $sql.= $ClsMora->insert_boleta_mora($codigo, $division, $grupo, $grupo, $motivo);
      }

		//$respuesta->alert("$referencia");
		$rs = $ClsBol->exec_sql($sql);
      if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($codigo, $usu);
			$codigo = Agrega_Ceros($codigo);
			$respuesta->script('swal("Excelente!", "Transacci\u00F3n registrada satisfactoriamente!!! \n Boleta No. '.$codigo.'", "success").then((value)=>{ openBoleta(\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         $respuesta->script('gra = document.getElementById("grab").className = "btn btn-primary";');
		}

   return $respuesta;
}


function Modificar_Boleta_Cobro($codigo,$division,$grupo,$alumno,$codalumno,$referencia,$tipo,$monto,$motivo,$tipodesc,$desc,$motdesc,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   //$respuesta->alert("$codigo,$division,$grupo,$alumno,$codalumno,$referencia,$tipo,$monto,$motivo,$tipodesc,$desc,$motdesc,$fecha");
   //cadenas
   $motivo = utf8_encode($motivo);
   $motdesc = utf8_encode($motdesc);
   //--
   $motivo = utf8_decode($motivo);
   $motdesc = utf8_decode($motdesc);
   //--
   if($tipodesc == "M"){
      $descuento = $desc;
   }else if($tipodesc == "P"){
      $descuento = ($monto * $desc)/100;
   }
   $monto = ($monto - $descuento);
   $monto = number_format($monto,  2, '.', '');
   $descuento = number_format($descuento,  2, '.', '');
   $sql.= $ClsBol->update_boleta_cobro($codigo,$division,$grupo,$alumno,$codalumno,$referencia,$tipo,$monto,$motivo,$descuento,$motdesc,$fecha);

  // $respuesta->alert("$sql");
   $rs = $ClsBol->exec_sql($sql);
   if($rs == 1){
      $usu = $_SESSION["codigo"];
      $hashkey = $ClsBol->encrypt($codigo, $usu);
      $respuesta->script('swal("Excelente!", "Transacci\u00F3n modificada satisfactoriamente!!!", "success").then((value)=>{ openBoleta(\''.$hashkey.'\'); });');
   }else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
   }


   return $respuesta;
}


function Buscar_Boleta_Cobro($codigo){
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	//$respuesta->alert("$ban,$num,$tipo,$mon");
    if($codigo != ""){
		$result = $ClsBol->get_boleta_cobro($codigo);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["bol_codigo"];
				$periodo = $row["bol_periodo_fiscal"];
				$periododesc = utf8_decode($row["bol_periodo_descripcion"]);
            $division = $row["bol_division"];
				$grupo = $row["bol_grupo"];
				$referencia = $row["bol_referencia"];
            $tipo = $row["bol_tipo"];
				$motivo = utf8_decode($row["bol_motivo"]);
				$monto = $row["bol_monto"];
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fecha($fecha);
				//--
				$desc = $row["bol_descuento"];
				$motdesc = $row["bol_motivo_descuento"];
				//--
            $cui = $row["alu_cui"];
            $codint = $row["alu_codigo_interno"];
            $alu_nombre = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
            $alu_grado = utf8_decode($row["alu_grado_descripcion"]);
            //--
				$respuesta->assign("codigo","value",$codigo);
				$respuesta->assign("periodo","value",$periodo);
				$respuesta->assign("periododesc","value",$periododesc);
				$respuesta->assign("grupo","value",$grupo);
				$respuesta->assign("referencia","value",$referencia);
            $respuesta->assign("tipo","value",$tipo);
            //$respuesta->alert($tipo);
				$respuesta->assign("monto","value",$monto);
				$respuesta->assign("motivo","value",$motivo);
				$respuesta->assign("fecha","value",$fecha);
				//--
				$respuesta->assign("tipodesc","value","M");
				$respuesta->assign("desc","value",$desc);
				$respuesta->assign("motdesc","value",$motdesc);
            //--
            $respuesta->assign("cui","value",$cui);
            $respuesta->assign("codint","value",$codint);
            $respuesta->assign("nombre","value",$alu_nombre);
            $respuesta->assign("grasec","value",$alu_grado);
			}
			$contenido = "<label>Divisi&oacute;n:</label>".division_html($grupo,"division","");
			$respuesta->assign("sdiv","innerHTML",$contenido);
			$respuesta->assign("division","value",$division);
			$respuesta->script("document.getElementById('ban').setAttribute('disabled','disabled');");
			$respuesta->script("document.getElementById('cue').setAttribute('disabled','disabled');");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
         $respuesta->script("document.getElementById('nombre').focus();");
			$respuesta->script("cerrar();");
		}
	}

   return $respuesta;
}


function Valida_Boleta_Cobro($referencia,$cui){
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	//$respuesta->alert("$referencia,$cui");
   $result = $ClsBol->get_boleta_cobro('','','',$cui,$referencia);
	if(is_array($result)){
		foreach($result as $row){
			$banco = $row["bol_banco"];
			$cuenta = $row["bol_cuenta"];
			$referencia = $row["bol_referencia"];
			$monto = number_format($row["bol_monto"],2,'.','');
			$pagado = $row["bol_pagado"];
		}
		$combo = cuenta_banco_html($banco,"cue","");
		$respuesta->assign("scue","innerHTML",$combo);
		//--
		$respuesta->assign("ban","value",$banco);
		$respuesta->assign("cue","value",$cuenta);
		$respuesta->assign("boleta","value",$referencia);
		$respuesta->assign("efectivo","value",$monto);
		$respuesta->assign("pagada","value",$pagado);
		//--
		$respuesta->script("document.getElementById('ban').setAttribute('disabled','disabled');");
		$respuesta->script("document.getElementById('cue').setAttribute('disabled','disabled');");
		$respuesta->script("document.getElementById('grab').focus();");
		//--
		if($pagado == 1){
			$alerta = '<h5 class = "alert alert-info text-center">Esta Boleta ya esta reportada como pagada!...</h5>';
			$respuesta->assign("labelalerta","innerHTML",$alerta);
         $respuesta->script('swal("Oho!", "Esta Boleta ya esta reportada como pagada!...", "info").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->assign("labelalerta","innerHTML","");
		}
		$respuesta->script("cerrar();");
	}else{
		$respuesta->script('swal("Error", "Esta Boleta NO existe entre las boletas generadas para cobro \u00F3 pertenece a otro alumno, por favor revise e intente de nuevo...", "error").then((value)=>{ cerrar(); });');
	}

   return $respuesta;
}


function Eliminar_Boleta_Cobro($codigo,$motivo_anula){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   
   $motivo_anula = trim($motivo_anula);
   $motivo_anula = utf8_encode($motivo_anula);
   $motivo_anula = utf8_decode($motivo_anula);
   //
   $sql.= $ClsBol->cambia_sit_boleta_cobro($codigo,$motivo_anula,0);

   //$respuesta->alert("$sql");
   $rs = $ClsBol->exec_sql($sql);
   if($rs == 1){
      $respuesta->script('swal("Ok", "Boleta eliminada satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
   }else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
   }
      
   return $respuesta;
}


//////////////////---- Cargas Electronicas -----/////////////////////////////////////////////
function Eliminar_Carga_Electronica($carga){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();

	if($carga != ""){
		$sql = $ClsBol->delete_carga_electronica($carga);
		$result = $ClsBol->get_pagos_de_carga($carga);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["pag_codigo"];
				$boleta = $row["pag_programado"];
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$referencia = $row["pag_referencia"];
				$sql.= $ClsBol->delete_movimiento_banco_carga_electronica($cuenta,$banco,$referencia);
				$sql.= $ClsBol->cambia_pagado_boleta_cobro($boleta, 0);
				$sql.= $ClsBol->delete_pago($codigo);
			}
		}
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Movimientos de Carga Electr\u00F3nica Eliminados Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}



function Eliminar_Archivo_Carga_Electronica($archivo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	//$respuesta->alert("$archivo");
	unlink("../../CONFIG/CARGAS/$archivo");

	$respuesta->script('swal("Excelente", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');

   return $respuesta;
}



//////////////////---- Pagos -----/////////////////////////////////////////////

function Grabar_Pago_Carga_Electronica($cuenta,$banco,$desc,$archivo,$arralumno,$arrcodint,$arrcodigo,$arrperiodo,$arrreferencia,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	$ClsBan = new ClsBanco();
    $ClsPer = new ClsPeriodoFiscal();
   $periodo_default = $ClsPer->periodo;

	//$respuesta->alert("$filas");
	if($banco != "" && $cuenta != ""){
		//cadenas
			$desc = utf8_encode($desc);
			$archivo = utf8_encode($archivo);
		//--
			$desc = utf8_decode($desc);
			$archivo = utf8_decode($archivo);
		//--
		$carga = $ClsBol->max_carga_electronica();
		$carga++;
		$sql = $ClsBol->insert_carga_electronica($carga,$cuenta,$banco,$desc,$archivo);
		$cod = $ClsBan->max_mov_cuenta($cuenta,$banco);
		$cod++;
		//Query
		$contador = 1;
		for($i = 1; $i <= $filas; $i ++){
			$alumno = $arralumno[$i];
			$codint = $arrcodint[$i];
			$periodo = $arrperiodo[$i];
         $periodo = ($periodo == "")?$periodo_default:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
			$codboleta = $arrcodigo[$i];
			$referencia = $arrreferencia[$i];
			$fecha = $arrfecha[$i];
			$mes = $arrmes[$i];
			$efect = str_replace("Q","",$arrefect[$i]);
			$chp = str_replace("Q","",$arrcheprop[$i]);
			$otb = str_replace("Q","",$arrotrosban[$i]);
			$online = str_replace("Q","",$arronline[$i]);
			//--
         //$respuesta->alert("no pagada $referencia");
			//--
         $fechor = "$fecha 00:00:00";
         if($codboleta == ""){
            $codboleta = 0;
         }   
			//--
			$monto = ($efect+$chp+$otb+$online);
			$sql.= $ClsBan->insert_mov_cuenta($cod,$cuenta,$banco,'I',$monto,'DP','BOLETA DE PAGO',$referencia,$fecha);
			$sql.= $ClsBan->saldo_cuenta_banco($cuenta,$banco,$monto,"+");
			$sql.= $ClsBol->insert_pago_boleta_cobro($periodo, $alumno,$codint,$referencia,$cuenta,$banco,$carga,$codboleta,$efect,$chp,$otb,$online,$fechor);
			$sql.= $ClsBol->cambia_pagado_boleta_cobro($codboleta,1); /// 0-> Pendiente de Pago, 1-> Pagado
			$cod++;
			$contador++;
		}
		$contador--;

		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$respuesta->script('swal("Transacci\u00F3n Registrada!", "'.$contador.' registros fueron ejecutados satisfactoriamente!", "success").then((value)=>{ window.location.href="FRMdetalle_historial_pagos.php?hashkey='.$hashkey.'"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Buscar_Boleta_Cobro_Para_Pago($codigo){
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	//$respuesta->alert("$codigo");
   if($codigo != ""){
		$result = $ClsBol->get_boleta_cobro($codigo);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["bol_codigo"];
				$division = $row["bol_division"];
				$grupo = $row["bol_grupo"];
				$pagado = $row["bol_pagado"];
				if($pagado == 1){
					$respuesta->script('swal("Alto", "Esta Boleta ya Fue Pagada!", "info").then((value)=>{ cerrar(); });');
					return $respuesta;
				}
				$referencia = $row["bol_referencia"];
				$motivo = utf8_decode($row["bol_motivo"]);
				$monto = $row["bol_monto"];
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fecha($fecha);
				//--
				$desc = $row["bol_descuento"];
				$motdesc = $row["bol_motivo_descuento"];
				//--
            $alu_nombre = $row["alu_nombre_completo"];
            $alu_grado = $row["alu_grado_descripcion"];
            //--
				$respuesta->assign("codboleta","value",$codigo);
				$respuesta->assign("grupo","value",$grupo);
				$respuesta->assign("referencia","value",$referencia);
				$respuesta->assign("efectivo","value",$monto);
				$respuesta->assign("chp","value","0");
				$respuesta->assign("otb","value","0");
				$respuesta->assign("online","value","0");
            //--
            $respuesta->assign("nombre","value",$alu_nombre);
            $respuesta->assign("grasec","value",$alu_grado);
			}
			$contenido = "<label>Divisi&oacute;n:</label>".division_html($grupo,"division","");
			$respuesta->assign("sdiv","innerHTML",$contenido);
			$respuesta->assign("division","value",$division);
			$respuesta->script("document.getElementById('grupo').setAttribute('disabled','disabled');");
			$respuesta->script("document.getElementById('division').setAttribute('disabled','disabled');");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			if($pagado == 1){
				$alerta = '<h5 class = "alert alert-info text-center">Esta Boleta ya esta reportada como pagada!...</h5>';
				$respuesta->assign("labelalerta","innerHTML",$alerta);
			}else{
				$respuesta->assign("labelalerta","innerHTML","");
			}
			$respuesta->script('document.getElementById("pensum").focus();');
			$respuesta->script("cerrar();");
		}
	}

   return $respuesta;
}


function Grabar_Pago_Boleta($periodo, $alumno,$codint,$bolcodigo,$referencia,$cue,$ban,$fecha,$hora,$efect,$cheprop,$otrosban,$online){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   $ClsBan = new ClsBanco();

	if($alumno != ""){
		$fechor = "$fecha $hora";
		$monto = ($efect+$cheprop+$otrosban+$online);
		$codigo = $ClsBan->max_mov_cuenta($cue,$ban);
		$codigo++;
      //Query
		$sql.= $ClsBan->insert_mov_cuenta($codigo,$cue,$ban,'I',$monto,'DP','BOLETA DE PAGO',$referencia,$fecha);
		$sql.= $ClsBan->saldo_cuenta_banco($cue,$ban,$monto,"+");
		$sql.= $ClsBol->insert_pago_boleta_cobro($periodo, $alumno,$codint,$referencia,$cue,$ban,0,$bolcodigo,$efect,$cheprop,$otrosban,$online,$fechor);
      $sql.= $ClsBol->cambia_pagado_boleta_cobro($bolcodigo,1); // si el pago esta enlazado a alguna boleta, le cancela la situacion de pagada
		

		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente", "Transacci\u00F3n registrada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Buscar_Pago_Boleta($codigo){
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	//$respuesta->alert("$ban,$num,$tipo,$mon");
    if($codigo != ""){
		$result = $ClsBol->get_pago_boleta_cobro($codigo);
		if(is_array($result)){
			foreach($result as $row){
				$cod = $row["pag_codigo"];
				$cue = $row["pag_cuenta"];
				$ban = $row["pag_banco"];
				$codboleta = $row["pag_programado"];
				$referencia = $row["pag_referencia"];
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$efectivo = $row["pag_efectivo"];
				$chp = $row["pag_cheques_propios"];
				$otb = $row["pag_otros_bancos"];
				$online = $row["pag_online"];
				//--
				$respuesta->assign("cod","value",$cod);
				$respuesta->assign("ban","value",$ban);
				$respuesta->assign("referencia","value",$referencia);
				$respuesta->assign("fecha","value",$fecha);
				$respuesta->assign("efectivo","value",$efectivo);
				$respuesta->assign("chp","value",$chp);
				$respuesta->assign("otb","value",$otb);
				$respuesta->assign("online","value",$online);
            $respuesta->assign("codboleta","value",$codboleta);
			}
			$contenido = cuenta_banco_html($ban,"cue","");
			$respuesta->assign("scue","innerHTML",$contenido);
			$respuesta->assign("cue","value",$cue);
			$respuesta->script("document.getElementById('ban').setAttribute('disabled','disabled');");
			$respuesta->script("document.getElementById('cue').setAttribute('disabled','disabled');");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
			$respuesta->script("cerrar();");
		}
	}

   return $respuesta;
}


function Modificar_Pago_Boleta($codigo,$alumno,$codint,$bolcodigo,$referencia,$cuenta,$banco,$freg,$efect,$cheprop,$otrosban,$online){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();

	if($codigo != ""){
		$sql = $ClsBol->update_pago_boleta_cobro($codigo,$alumno,$codint,$referencia,$cuenta,$banco,$freg,$efect,$cheprop,$otrosban,$online);
      //valida si tiene boleta enlazada
		$result = $ClsBol->get_boleta_cobro($bolcodigo);
		if(is_array($result)){
			$sql.= $ClsBol->cambia_pagado_boleta_cobro($bolcodigo,1); // si el pago esta enlazado a alguna boleta, le cancela la situacion de pagada
		}

		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente", "Transacci\u00F3n modificada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Modificar_Pago_Boleta_Carga($codigo,$alumno,$codint,$referencia,$monto,$fecha,$hora){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();

	if($codigo != ""){
      $freg = "$fecha $hora";
		$sql = $ClsBol->update_pago_boleta_cobro_carga($codigo, $alumno, $codint, $referencia, $monto, $freg);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script("window.location.reload();");
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ EditBoleta('.$codigo.'); });');
		}
	}

   return $respuesta;
}


function Enlazar_Boletas($bolcodigo,$bolnumero,$pagcodigo,$periodo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();

	if($bolnumero != "" && $bolcodigo != "" && $pagcodigo != ""){
      $sql = $ClsBol->cambia_documento_boleta_cobro($bolcodigo,$bolnumero);
      $sql.= $ClsBol->cambia_pagado_boleta_cobro($bolcodigo,1); // si el pago esta enlazado a alguna boleta, le cancela la situacion de pagada
      $sql.= $ClsBol->update_pago_boleta($pagcodigo, $bolcodigo,$periodo, $bolnumero);
      //$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "N\u00FAmeros de boletas enlazados y registrada como PAGADA...", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Enlazar_Pago_Alumno($pago,$cuiCorrecto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();

	if($pago != "" && $cuiCorrecto != ""){
      $sql = $ClsBol->cambia_pago_alumno($pago, $cuiCorrecto);
      //$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "Alumnos enlazado y pago registrado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Cambiar_Boletas($bolcod,$cuenta,$banco,$pagcod,$bolnumero,$referencia){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();

	if($bolnumero != "" && $referencia != ""){
      $sql = $ClsBol->cambia_documento_boleta_cobro($bolcod,$bolnumero);
      $sql.= $ClsBol->update_pago_boleta($pagcod, $bolcod, $referencia);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "N\u00FAmeros de boletas actualizados...", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Eliminar_Pago($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	//$respuesta->alert("$codigo");

		//Query
		$sql = $ClsBol->delete_pago($codigo);
		//valida si tiene boleta enlazada
		$result = $ClsBol->get_pago_aislado($codigo);
		if(is_array($result)){
			foreach($result as $row){
				$bolcodigo = $row["pag_programado"];
         }
			$sql.= $ClsBol->cambia_pagado_boleta_cobro($bolcodigo,0); // si el pago esta enlazado a alguna boleta, le cancela la situacion de pagada
		}

		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "Pago eliminado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}


   return $respuesta;
}

//////////////////---- MORAS -----////////////////////////////////////////////

function Grabar_Mora($cuenta,$banco,$periodo,$nivel,$grado,$seccion,$desde,$hasta,$tipo,$cargo,$motivo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
 	$ClsPen = new ClsPensum();
   $ClsPer = new ClsPeriodoFiscal();
   $ClsMora = new ClsMora();
 	
   //$respuesta->alert("$cuenta,$banco,$periodo,$nivel,$grado,$seccion,$desde,$hasta,$tipo,$cargo,$motivo");
   $periodo_activo = $ClsPer->periodo;
   $periodo = ($periodo == "")?$periodo_activo:$periodo;
   if($periodo != ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else{
		$pensum = $_SESSION["pensum"];
	}
   //grupo de mora
   $grupo = $ClsMora->max_grupo_mora();
	$grupo++;
   //seleccion
   $result = $ClsBol->get_morosos($desde,$hasta,$pensum,$cuenta,$banco,$periodo,$periodo_activo,$nivel,$grado,$seccion);
   if(is_array($result)){
      $sql='';
      $i = 0;
      //--
      $codigo = $ClsBol->max_boleta_cobro();
		$codigo++;
      //$respuesta->alert("$codigo");
      $fecha = date("d/m/Y");
      foreach($result as $row){
         $programado = $row["pagos_programados"];
         $pagado = $row["pagos_ejecutados"];
         $saldo = ($programado - $pagado);
         if($saldo > 0){
            //cui
            $cui = $row["alu_cui"];
            $codinter = $row["alu_codigo_interno"];
            //nombre
            $nombre = utf8_decode($row["alu_nombre"]);
            $apellido = utf8_decode($row["alu_apellido"]);
            //grado
            $grado = utf8_decode($row["gra_descripcion"]);
            $seccion = utf8_decode($row["sec_descripcion"]);
            //programado
            $pagado = $row["pagos_ejecutados"];
            //programado
            $saldo = ($programado - $pagado);
            //monto
            if($tipo == "P"){
               $monto = ($saldo * $cargo)/100;
               //$respuesta->alert("$monto = ($saldo * $cargo)/100;");
            }else{
               $monto = $cargo;
               //$respuesta->alert("$cargo");
            }
            //codigo
            $documento = $codigo;
            $sql.= $ClsBol->insert_boleta_cobro($codigo, $periodo, $cuenta, $banco, $cui, $codinter, $documento, "M", $monto, $motivo, 0, '', $fecha);
            $sql.= $ClsMora->insert_boleta_mora($codigo, $cuenta, $banco, $grupo, $motivo);
            $codigo++;
            $i++;
         }
      }
      if($i > 0){ //si al menos un registro trae mora...
         //$respuesta->alert("$sql");
         $rs = $ClsBol->exec_sql($sql);
         if($rs == 1){
            $respuesta->script('swal("Excelente", "'.$i.' registro(s) de Mora fueron registrado(s) con exito!", "success").then((value)=>{ window.location.href="FRMnotificar_mora.php?grupo='.$grupo.'"; });');
         }else{
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         }
      }
   }


   return $respuesta;
}


function Eliminar_Moras($grupo, $justifica){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   $ClsMora = new ClsMora();
   
   $result = $ClsBol->get_mora('','','','','','','','','','','','','','','',$grupo);
   if(is_array($result)){
      $sql='';
      $i = 0;
      $justifica = utf8_encode($justifica);
      $justifica = utf8_decode($justifica);
      foreach($result as $row){       
         $banco = $row["ban_codigo"];
			$cuenta = $row["cueb_codigo"];
			$codigo = $row["bol_codigo"];
         //SQL 
         $sql.= $ClsBol->cambia_sit_boleta_cobro($codigo,$justifica,0);
         $sql.= $ClsMora->cambia_sit_mora($codigo, $cuenta, $banco, $justifica);
         $i++;
      }
      if($i > 0){ //si al menos un registro trae mora...
         //$respuesta->alert("$sql");
         $rs = $ClsBol->exec_sql($sql);
         if($rs == 1){
            $respuesta->script('swal("Ok", "'.$i.' registro(s) de Mora fueron eliminada(s) con exito!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         }
      }
   }

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
				$cod = $row["cli_id"];
				$respuesta->assign("cli$fila","value",$cod);
				$nom = trim($row["cli_nombre"]);
				$respuesta->assign("cliente$fila","value",$nom);
				$nit = trim($row["cli_nit"]);
				$respuesta->assign("nit$fila","value",$nit);
			}
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script("validaCliente('$nit','$fila');");
		}
	}else{
		$respuesta->assign("nit$fila","value","");
		$respuesta->assign("cliente$fila","value","");
		$respuesta->assign("cli$fila","value","");
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
	//decodificaciones de tildes y &oacute;'s
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
		//$respuesta->alert("$sql");
		$rs = $ClsCli->exec_sql($sql);
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



/////////////////////////////// VENTAS CON BOLETAS DE DEPOSITO //////////////////////////////////
function SucPuntVnt($suc,$id){
    $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$id");
	 $contenido = punto_venta_html($suc,$id,"Limpiar_Campos_Venta();Submit();");
	 //$respuesta->alert("$contenido");
	 $respuesta->assign("divpv","innerHTML",$contenido);

	return $respuesta;
}


function BanCueVnt($ban,$id){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = cuenta_banco_html($ban,$id,'');
	//$respuesta->alert("$contenido");
	$respuesta->assign("divcue","innerHTML",$contenido);

	return $respuesta;
}


function Producto_Servicio($tipo){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
      if($tipo == "S"){
			$contenido = Grupo_Serv_html();
      }else if($tipo == "P"){
			$contenido = Grupo_Art_html();
      }else{
			$contenido = '<select name="gru" id="gru" class = "combo">';
			$contenido.= '<option value="">Seleccione</option>';
			$contenido.='</select>';
      }
	//$respuesta->alert("$contenido");
	$respuesta->assign("spangru","innerHTML",$contenido);

	return $respuesta;
}


function Show_Barcode($barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
	$ClsSer = new ClsServicio();

	//pasa a mayusculas
		$barc = trim($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
   if($barc != ""){
		$indicador = substr($barc,0,1);
		if($indicador == "A"){
			$chunk = explode("A", $barc);
			$art = $chunk[1]; // articulo
			$gru = $chunk[2]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			//--
			$respuesta->script("TipoVenta('P');");
			$respuesta->assign("tip","value","P");
			//--
			$result = $ClsArt->get_articulo($art,$gru,'','','','','','',1,$suc);
			if(is_array($result)){
				foreach($result as $row){
					$art = $row["art_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$art = Agrega_Ceros($art);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $art."A".$gru;
					$respuesta->assign("Aart","value",$cod); //Selecciona el Combo
					$respuesta->assign("art","value",$cod); //guarada el codigo
					$nom = trim($row["art_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["art_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Abarc","value",$barc);
					$cant = $row["art_cant_suc"];
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["art_precio"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["art_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["art_precio_manufactura"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("cerrar();");
			}else{
				$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
				$respuesta->assign("art","value","");
				$respuesta->assign("artn","value","");
			}
		}else if($indicador == "S"){
			$chunk = explode("S", $barc);
			$ser = $chunk[1]; // articulo
			$gru = $chunk[2]; // grupo
			//valida que los espacios sean numericos
			$ser = (is_numeric($ser))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			//--
			$respuesta->script("TipoVenta('S');");
			$respuesta->assign("tip","value","S");
			//--
			$result = $ClsSer->get_servicio($ser,$gru,'','','',1);
			if(is_array($result)){
				foreach($result as $row){
					$ser = $row["ser_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$ser = Agrega_Ceros($ser);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $ser."A".$gru;
					$respuesta->assign("Sart","value",$cod); //Selecciona el Combo
					$respuesta->assign("art","value",$cod); //guarada el codigo
					$nom = trim($row["ser_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["ser_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Sbarc","value",$barc);
					$cant = 10000;
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["ser_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["ser_precio_venta"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["ser_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["ser_precio_costo"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("cerrar();");
			}else{
				$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
				$respuesta->assign("art","value","");
				$respuesta->assign("artn","value","");
			}

		}else{
			$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		//inicia la busqueda

	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar();");
	}

	return $respuesta;
}



function Show_Articulo($cod,$barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
   //pasa a mayusculas
		$cod = trim($cod);
		$barc = trim($barc);
   //decodificaciones de tildes y &oacute;'s
		$cod = utf8_decode($cod);
		$barc = utf8_decode($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
    if($cod != "" || $barc != ""){
		if($cod != ""){
			$chunk = explode("A", $cod);
			$art = $chunk[0]; // articulo
			$gru = $chunk[1]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			$result = $ClsArt->get_articulo($art,$gru,'','','','','','',1,$suc);
		}else{
			$result = $ClsArt->get_articulo('','','','','','','',$barc,1,$suc);
		}
		//inicia la busqueda
		if(is_array($result)){
				foreach($result as $row){
					$art = $row["art_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$art = Agrega_Ceros($art);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $art."A".$gru;
					$respuesta->assign("art","value",$cod);
					$nom = trim($row["art_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["art_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Abarc","value",$barc);
					$cant = trim($row["art_cant_suc"]);
               $cant = ($cant == "")?"0":$cant;
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["art_precio"];
					$prev = number_format($prev, 2, '.', '');
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["art_precio_costo"];
					$prec = number_format($prec, 2, '.', '');
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["art_precio_manufactura"];
					$prem = number_format($prem, 2, '.', '');
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}

	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar();");
	}

	return $respuesta;
}


function Buscar_Articulo($gru,$nom,$desc,$marca,$suc,$x){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
	//pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
	//--------
	//decodificaciones de tildes y &oacute;'s
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
	//--------
	//$respuesta->alert("$gru,$nom,$desc,$marca,$suc,$x");
    if($gru != "" || $nom != "" || $desc != "" || $marca != ""){
		$cont = $ClsArt->count_articulo('',$gru,$nom,$desc,$marca,'','',$barc,1,$suc);
		if($cont>0){
			$contenido = tabla_lista_articulos($gru,$nom,$desc,$marca,'',$suc,$x);
			$respuesta->assign("resultArt","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}



function Show_Servicio($cod,$barc){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
   //pasa a mayusculas
		$cod = trim($cod);
		$barc = trim($barc);
   //decodificaciones de tildes y &oacute;'s
		$cod = utf8_decode($cod);
		$barc = utf8_decode($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
    if($cod != "" || $barc != ""){
		if($cod != ""){
			$chunk = explode("A", $cod);
			$ser = $chunk[0]; // articulo
			$gru = $chunk[1]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($ser))?$ser:0;
			$gru = (is_numeric($gru))?$gru:0;
			$result = $ClsSer->get_servicio($ser,$gru,'','','',1);
		}else{
			$result = $ClsSer->get_servicio('','','','',$barc,1);
		}
		//inicia la busqueda
		if(is_array($result)){
				foreach($result as $row){
					$ser = $row["ser_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$ser = Agrega_Ceros($ser);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $ser."A".$gru;
					$respuesta->assign("art","value",$cod);
					$nom = trim($row["ser_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["ser_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Sbarc","value",$barc);
					$cant = 10000;
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["ser_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["ser_precio_venta"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["ser_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["ser_precio_costo"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}

	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar();");
	}

	return $respuesta;
}


function Buscar_Servicio($gru,$nom,$desc){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
	//pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y &oacute;'s
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$gru,$nom,$desc,$barc,$x");
    if($gru != "" || $nom != "" || $desc != ""){
		$cont = $ClsSer->count_servicio('',$gru,$nom,$desc,'',1);
		//$respuesta->alert("$cont");
		if($cont>0){
			$contenido = tabla_lista_servicios($gru,$nom,$desc);
			$respuesta->assign("resultArt","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("Ohoo", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Grid_Fila_Venta($pv,$suc,$tipo,$detalle,$artcodigo,$cant,$precio,$moneda,$tcamb,$tipo_descuento,$descuento){
   $respuesta = new xajaxResponse();
	$ClsVent = new ClsVenta();
	//$respuesta->alert("$pv,$suc,$tipo,$detalle,$artcodigo,$cant,$precio,$moneda,$tcamb,$tipo_descuento,$descuento");

	if($pv != "" && $suc != "" && $tipo != "" && $cant != "" && $precio != "" && $moneda != "" && $tcamb != ""){
		//pasa a mayusculas
		$detalle = trim($detalle);
		//--------
		$chunk = explode("A", $artcodigo);
		$art = $chunk[0]; // articulo
		$art = ($art != "")?$art:0; //-- valida si es servicio devuelve 0
		$grupo = $chunk[1]; // grupo
		$grupo = ($grupo != "")?$grupo:0; //-- valida si es servicio devuelve 0
		//calculos
		$subtotal = ($cant * $precio);
		$subtotal = ($cant * $precio);
		//valida descuento
		if($tipo_descuento == "P"){
			$monto_descuento = ($subtotal*$descuento)/100;
			$total = $subtotal - $monto_descuento;
		}else if($tipo_descuento == "M"){
			$monto_descuento = $descuento;
			$total = $subtotal - $monto_descuento;
		}else{
			$monto_descuento = 0;
			$total = $subtotal;
		}
		if($monto_descuento <= $subtotal){
			$codigo = $ClsVent->max_detalle_temporal($pv,$suc);
			$codigo++;
			$sql = $ClsVent->insert_detalle_temporal($codigo,$pv,$suc,$tipo,$detalle,$art,$grupo,$cant,$precio,$moneda,$tcamb,$subtotal,$monto_descuento,$total);
			$rs = $ClsVent->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$respuesta->script("cerrar();Submit();Limpiar_Campos_Venta();document.getElementById('barc').focus();");
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}
		}else{
			$respuesta->script('swal("Ohoo", "El monto de descuento individual no debe de ser menor que el precio del articulo...", "info").then((value)=>{ cerrar(); });');
		}
	}else{
		$respuesta->script('swal("Ohoo", "Algunos parametros est\u00E1n vacios...", "info").then((value)=>{ cerrar(); });');
	}

   return $respuesta;
}


function Quita_Fila_Venta($codigo,$pv,$suc){
   $respuesta = new xajaxResponse();
   $ClsVent = new ClsVenta();
	$sql = $ClsVent->delete_item_detalle_temporal($codigo,$pv,$suc);
	$rs = $ClsVent->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}


function Limpiar_Fila_Venta($pv,$suc){
   $respuesta = new xajaxResponse();
   $ClsVent = new ClsVenta();
	//$respuesta->alert("$pv,$suc");
	$sql = $ClsVent->delete_detalle_temporal($pv,$suc);
	$rs = $ClsVent->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}


function Grabar_Boleta_Venta($filas,$alumno,$codint,$referencia,$cuenta,$banco,$empresa,$pv,$fecboleta,$fecpago,$subt,$descuento,$total,$moneda,$montext){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
	$ClsBol = new ClsBoletaCobro();
   $ClsPer = new ClsPeriodoFiscal();
	$ClsVent = new ClsVenta();
	$ClsMon = new ClsMoneda();

	//--
	$monchunk = explode("/",$montext);
	$tcamb = $ClsMon->get_tipo_cambio($moneda); // Tipo de Cambio

	$sql = "";
	//------------
	$motivo = "";
	if($filas > 0 && $alumno != "" && $cuenta != "" &&  $banco != "" && $moneda != ""){
		// BOLETA
      $result = $ClsVent->get_detalle_temporal($pv,$empresa);
      if(is_array($result)){
         $motivo = "";
         foreach($result as $row){
            $motivo.= "(".trim($row["dventemp_cantidad"]).") ".utf8_decode($row["dventemp_detalle"]).", ";
         }
         $motivo = substr($motivo, 0, -2);
      }else{
         $motivo = trim("Uniformes y otros accesorios");
      }
      ////////--
      $periodo = $ClsPer->periodo;
      $codigo = $ClsBol->max_boleta_cobro();
		$codigo++;
      if($referencia == ""){
         //--- repmplazado por el $codigo
         $referencia = $codigo;
      }
      $sql.= $ClsBol->insert_boleta_cobro($codigo,$periodo,$cuenta,$banco,$alumno,$codint,$referencia,"V",$total,$motivo,$descuento,"",$fecboleta);
		//DETALLE DE VENTA
		$P = 0; // contador de filas con productos para descargar a inventario
		$P+= $ClsVent->count_detalle_temporal($pv,$empresa,'','P');
		// detalle de venta (traslado de tablas temporales)
		$sql.= $ClsBol->insert_detalle_desde_temporal($codigo,$cuenta,$banco,$pv,$empresa);
		$sql.= $ClsVent->delete_detalle_temporal($pv,$empresa);
		
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		//$respuesta->alert("$rs");
		if($rs == 1){
			if($P > 0){ ///cantidad de productos a descargar
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($codigo, $usu);
				$hashkey1 = $ClsBol->encrypt($alumno, $usu);
				//--
				$respuesta->script('boletaOKdescargar("'.$hashkey.'",'.$codigo.','.$cuenta.','.$banco.','.$P.')');
			}else{
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($codigo, $usu);
				$hashkey1 = $ClsBol->encrypt($alumno, $usu);
				//--
				$respuesta->script('swal("Excelente", "Transacci\u00F3n registrada satisfactoriamente!!!", "success").then((value)=>{ window.open("../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'"); window.location.href =\'../CPBOLETAFACTURAS/FRMalumno.php?hashkey='.$hashkey1.'\' });');
			}
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


function Grabar_Descarga($suc,$boleta,$cuenta,$banco){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventario();
   $ClsArt = new ClsArticulo();
   $ClsBol = new ClsBoletaCobro();

	if($suc != "" && $boleta != ""){
		$result = $ClsBol->get_boleta_cobro($boleta,$cuenta,$banco);
		if(is_array($result)){
			foreach($result as $row){
				$fecboleta = $row["bol_fecha_registro"];
				$fecboleta = cambia_fechaHora($fecboleta);
            $fecboleta = substr($fecboleta,0,10);
				$alumno = trim($row["bol_alumno"]);
				$documento = trim($row["bol_referencia"]);
			}
		}

		$result = $ClsBol->get_det_venta_producto('',$boleta,$cuenta,$banco,'P');
		if(is_array($result)){
			//-- Datos de Inventario ($tipo = 2 // Egreso a inventario)
			$invc = $ClsInv->max_inventario(2);
			$invc++;
			$sql.= $ClsInv->insert_inventario($invc,2,"V",$documento,$suc,$fecboleta,1);
			$jx = 0; // valida las vueltas con producto
			// Inicia el Ciclo de filas
			foreach ($result as $row){
				/// Articulo --
				$art = $row["art_codigo"];
				$grup = $row["art_grupo"];
				//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
				//Query
				$cant = $row["dven_cantidad"];
				$necesita = $cant;
				//$respuesta->alert("Necesita: $necesita");
				$hay = 0;
				$toma = 0;
				$falta = 0;
				$deja = 0;
				$result_lotes = $ClsArt->descargar_lote($grup,$art,$suc);
				if(is_array($result_lotes)){
					$j = 1;
					foreach($result_lotes as $row_lote){
						$hay = $row_lote["lot_cantidad"];
						$lote = $row_lote["lot_codigo"];
						//$respuesta->alert("en el lote $lote : vuelta $i");
						if($hay >= $necesita){
							//$respuesta->alert("hay mas que los que se necesita");
							$toma = $necesita;
							//$respuesta->alert("toma $toma");
							$sobra = $hay - $necesita;
							//$respuesta->alert("sobran $sobra");
							$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
							$sql.= $ClsInv->insert_det_inventario($jx,$invc,2,$grup,$art,$lote,$toma);
							$sql.= $ClsBol->descargar_det_venta($boleta,$cuenta,$banco,1,$art,$grup);
							$j++;//aumenta el numero de detalle en el inventario
							$jx++;
							break;
						}else if($hay < $necesita){
							//$respuesta->alert("hay menos que los que se necesita");
							$toma = $hay;
							//$respuesta->alert("toma $toma");
							$falta = $necesita - $hay;
							//$respuesta->alert("faltan $falta");
							$necesita = $falta;
							//$respuesta->alert("ahora necesita $necesita");
							$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
							$sql.= $ClsInv->insert_det_inventario($jx,$invc,2,$grup,$art,$lote,$toma);
							$sql.= $ClsBol->descargar_det_venta($boleta,$cuenta,$banco,1,$art,$grup);
							$j++;//aumenta el numero de detalle en el inventario
							$jx++;
						}
					}
				}
			}
			//$respuesta->alert("$sql");
			if($jx > 0){
				$rs = $ClsInv->exec_sql($sql);
				$respuesta->alert("$sql");
				if($rs == 1){
					$usu = $_SESSION["codigo"];
					$hashkey = $ClsBol->encrypt($alumno, $usu);
					$hashkey1 = $ClsBol->encrypt($boleta, $usu);
					//--
					$respuesta->script('swal("Excelente", "Descarga exitosa...", "success").then((value)=>{ window.open("../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey1.'"); window.location.href =\'../CPBOLETAFACTURAS/FRMalumno.php?hashkey='.$hashkey.'\' });');
				}else{
					$usu = $_SESSION["codigo"];
					$hashkey = $ClsBol->encrypt($alumno, $usu);
					$hashkey1 = $ClsBol->encrypt($boleta, $usu);
					//--
					$respuesta->script('swal("", "Ocurrio un problema durante la descarga, porfavor ingrese este registro desde la forma gr\u00E1fica de Bodega-> Descarga de Inventario por Venta...", "error").then((value)=>{ window.open("../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey1.'"); window.location.href =\'../CPBOLETAFACTURAS/FRMalumno.php?hashkey='.$hashkey.'\' });');
				}
			}else{
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($alumno, $usu);
				$hashkey1 = $ClsBol->encrypt($boleta, $usu);
				//--
				$respuesta->script('swal("", "No hay articulos de inventario para descargar en esta venta...", "info").then((value)=>{ window.open("../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey1.'"); window.location.href =\'../CPBOLETAFACTURAS/FRMalumno.php?hashkey='.$hashkey.'\' });');
			}
		}else{
			$respuesta->script('swal("Ohoo", "No hay articulos de inventario pendientes de descargar en esta venta...", "error").then((value)=>{ cerrar(); });');
		}
	}

   return $respuesta;
}


//////////////////---- Configuracion de Pagos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
//////////////////---- Programacion de Blotas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Boleta_Cobro");
$xajax->register(XAJAX_FUNCTION, "Modificar_Boleta_Cobro");
$xajax->register(XAJAX_FUNCTION, "Buscar_Boleta_Cobro");
$xajax->register(XAJAX_FUNCTION, "Valida_Boleta_Cobro");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Boleta_Cobro");
//////////////////---- Cargas Electronicas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Eliminar_Carga_Electronica");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Archivo_Carga_Electronica");
//////////////////---- Pagos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Pago_Carga_Electronica");
$xajax->register(XAJAX_FUNCTION, "Buscar_Boleta_Cobro_Para_Pago");
$xajax->register(XAJAX_FUNCTION, "Grabar_Pago_Boleta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Pago_Boleta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pago_Boleta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Pago_Boleta_Carga");
$xajax->register(XAJAX_FUNCTION, "Enlazar_Boletas");
$xajax->register(XAJAX_FUNCTION, "Enlazar_Pago_Alumno");
$xajax->register(XAJAX_FUNCTION, "Cambiar_Boletas");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Pago");
//////////////////---- MORAS -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Mora");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Moras");
//////////////////---- CLIENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");
/////////////////----- VENTAS CON BOLETAS DE DEPOSITO -------/////////////////////
$xajax->register(XAJAX_FUNCTION, "SucPuntVnt");
$xajax->register(XAJAX_FUNCTION, "BanCueVnt");
$xajax->register(XAJAX_FUNCTION, "Producto_Servicio");
//////////////////---- ARTICULOS-CLIENTES-VENDEDOR -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Barcode");
$xajax->register(XAJAX_FUNCTION, "Show_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Show_Servicio");
$xajax->register(XAJAX_FUNCTION, "Buscar_Servicio");
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Venta");
$xajax->register(XAJAX_FUNCTION, "Quita_Fila_Venta");
$xajax->register(XAJAX_FUNCTION, "Limpiar_Fila_Venta");
$xajax->register(XAJAX_FUNCTION, "Grabar_Boleta_Venta");
$xajax->register(XAJAX_FUNCTION, "Grabar_Descarga");

//El objeto xajax tiene que procesar cualquier petici&oacute;n
$xajax->processRequest();

?>
