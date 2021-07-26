<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_ficha.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- PASOS -----/////////////////////////////////////////////
function Paso1($cui,$edad,$adaptado,$repitente,$repite_grado,$otros_col,$retirado_por,$porque_este,$hermanos_aqui,$estudiaron_aqui,$hermanos,$lugar_hermanos,$vive_con){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	
    //$respuesta->alert("$cui,$edad,$adaptado,$repitente,$repite_grado,$otros_col,$retirado_por,$porque_este,$hermanos_aqui,$estudiaron_aqui,$hermanos,$lugar_hermanos,$vive_con");
		
    if($cui != ""){
		//pasa a mayusculas
		$edad = trim($edad);
		$adaptado = trim($adaptado);
		$repitente = trim($repitente);
		$repite_grado = trim($repite_grado);
		$otros_col = trim($otros_col);
		$retirado_por = trim($retirado_por);
		$porque_este = trim($porque_este);
		$hermanos_aqui = trim($hermanos_aqui);
		$estudiaron_aqui = trim($estudiaron_aqui);
		$hermanos = trim($hermanos);
		$lugar_hermanos = trim($lugar_hermanos);
		$vive_con = trim($vive_con);
		//--------
		//decodificaciones de tildes y Ñ's
		$edad = utf8_encode($edad);
		$adaptado = utf8_encode($adaptado);
		$repitente = utf8_encode($repitente);
		$repite_grado = utf8_encode($repite_grado);
		$otros_col = utf8_encode($otros_col);
		$retirado_por = utf8_encode($retirado_por);
		$porque_este = utf8_encode($porque_este);
		$hermanos_aqui = utf8_encode($hermanos_aqui);
		$estudiaron_aqui = utf8_encode($estudiaron_aqui);
        $hermanos = utf8_encode($hermanos);
		$lugar_hermanos = utf8_encode($lugar_hermanos);
		$vive_con = utf8_encode($vive_con);
		//--
		$edad = utf8_decode($edad);
		$adaptado = utf8_decode($adaptado);
		$repitente = utf8_decode($repitente);
		$repite_grado = utf8_decode($repite_grado);
		$otros_col = utf8_decode($otros_col);
		$retirado_por = utf8_decode($retirado_por);
		$porque_este = utf8_decode($porque_este);
		$hermanos_aqui = utf8_decode($hermanos_aqui);
		$estudiaron_aqui = utf8_decode($estudiaron_aqui);
        $hermanos = utf8_decode($hermanos);
		$lugar_hermanos = utf8_decode($lugar_hermanos);
		$vive_con = utf8_decode($vive_con);
		//--------
		$sql = $ClsFic->insert_info_colegio($cui,$edad,$adaptado,$repitente,$repite_grado,$otros_col,$retirado_por,$porque_este,$hermanos_aqui,$estudiaron_aqui,$hermanos,$lugar_hermanos,$vive_con); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso2.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso2($cui,$planificado,$duracion,$complicaciones,$tipo_complicaciones,$rayos_x,$depresion,$otros){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$planificado,$duracion,$complicaciones,$tipo_complicaciones,$rayos_x,$depresion,$otros");
		
    if($cui != ""){
		//pasa a mayusculas
		$planificado = trim($planificado);
		$duracion = trim($duracion);
		$complicaciones = trim($complicaciones);
		$tipo_complicaciones = trim($tipo_complicaciones);
		$rayos_x = trim($rayos_x);
		$depresion = trim($depresion);
		$otros = trim($otros);
		//--------
		//decodificaciones de tildes y Ñ's
		$planificado = utf8_encode($planificado);
		$duracion = utf8_encode($duracion);
		$complicaciones = utf8_encode($complicaciones);
		$tipo_complicaciones = utf8_encode($tipo_complicaciones);
		$rayos_x = utf8_encode($rayos_x);
		$depresion = utf8_encode($depresion);
		$otros = utf8_encode($otros);
		//--
		$planificado = utf8_decode($planificado);
		$duracion = utf8_decode($duracion);
		$complicaciones = utf8_decode($complicaciones);
		$tipo_complicaciones = utf8_decode($tipo_complicaciones);
		$rayos_x = utf8_decode($rayos_x);
		$depresion = utf8_decode($depresion);
		$otros = utf8_decode($otros);
		//--------
		$sql = $ClsFic->insert_embarazo($cui,$planificado,$duracion,$complicaciones,$tipo_complicaciones,$rayos_x,$depresion,$otros); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso3.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}

function Paso3($cui,$tipo,$anestesia,$inducido,$forceps,$otros){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$tipo,$anestesia,$inducido,$forceps,$otros");
		
    if($cui != ""){
		//pasa a mayusculas
		$tipo = trim($tipo);
		$anestesia = trim($anestesia);
		$inducido = trim($inducido);
		$forceps = trim($forceps);
		$otros = trim($otros);
		//--------
		//decodificaciones de tildes y Ñ's
		$tipo = utf8_encode($tipo);
		$anestesia = utf8_encode($anestesia);
		$inducido = utf8_encode($inducido);
		$forceps = utf8_encode($forceps);
		$otros = utf8_encode($otros);
		//--
		$tipo = utf8_decode($tipo);
		$anestesia = utf8_decode($anestesia);
		$inducido = utf8_decode($inducido);
		$forceps = utf8_decode($forceps);
		$otros = utf8_decode($otros);
		//--------
		$sql = $ClsFic->insert_parto($cui,$tipo,$anestesia,$inducido,$forceps,$otros); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso4.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}

function Paso4($cui,$pecho,$pacha,$vomitos,$colicos){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$pecho,$pacha,$vomitos,$colicos");
		
    if($cui != ""){
		//pasa a mayusculas
		$pecho = trim($pecho);
		$pacha = trim($pacha);
		$vomitos = trim($vomitos);
		$colicos = trim($colicos);
		//--------
		//decodificaciones de tildes y Ñ's
		$pecho = utf8_encode($pecho);
		$pacha = utf8_encode($pacha);
		$vomitos = utf8_encode($vomitos);
		$colicos = utf8_encode($colicos);
		//--
		$pecho = utf8_decode($pecho);
		$pacha = utf8_decode($pacha);
		$vomitos = utf8_decode($vomitos);
		$colicos = utf8_decode($colicos);
		//--------
		$sql = $ClsFic->insert_lactancia($cui,$pecho,$pacha,$vomitos,$colicos); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso5.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso5($cui,$cabeza,$sento,$camino,$gateo,$balanceo,$babeo){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$cabeza,$duracio,$camino,$gateo,$balanceo,$babeo");
		
    if($cui != ""){
		//pasa a mayusculas
		$cabeza = trim($cabeza);
		$sento = trim($sento);
		$camino = trim($camino);
		$gateo = trim($gateo);
		$balanceo = trim($balanceo);
		$babeo = trim($babeo);
		//--------
		//decodificaciones de tildes y Ñ's
		$cabeza = utf8_encode($cabeza);
		$sento = utf8_encode($sento);
		$camino = utf8_encode($camino);
		$gateo = utf8_encode($gateo);
		$balanceo = utf8_encode($balanceo);
		$babeo = utf8_encode($babeo);
		//--
		$cabeza = utf8_decode($cabeza);
		$sento = utf8_decode($sento);
		$camino = utf8_decode($camino);
		$gateo = utf8_decode($gateo);
		$balanceo = utf8_decode($balanceo);
		$babeo = utf8_decode($babeo);
		//--------
		$sql = $ClsFic->insert_motor($cui,$cabeza,$sento,$camino,$gateo,$balanceo,$babeo); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso6.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso6($cui,$dientes,$balbuceo,$palabras,$oraciones,$articula,$entiende){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$dientes,$duracio,$palabras,$oraciones,$articula,$entiende");
		
    if($cui != ""){
		//pasa a mayusculas
		$dientes = trim($dientes);
		$balbuceo = trim($balbuceo);
		$palabras = trim($palabras);
		$oraciones = trim($oraciones);
		$articula = trim($articula);
		$entiende = trim($entiende);
		//--------
		//decodificaciones de tildes y Ñ's
		$dientes = utf8_encode($dientes);
		$balbuceo = utf8_encode($balbuceo);
		$palabras = utf8_encode($palabras);
		$oraciones = utf8_encode($oraciones);
		$articula = utf8_encode($articula);
		$entiende = utf8_encode($entiende);
		//--
		$dientes = utf8_decode($dientes);
		$balbuceo = utf8_decode($balbuceo);
		$palabras = utf8_decode($palabras);
		$oraciones = utf8_decode($oraciones);
		$articula = utf8_decode($articula);
		$entiende = utf8_decode($entiende);
		//--------
		$sql = $ClsFic->insert_lenguaje($cui,$dientes,$balbuceo,$palabras,$oraciones,$articula,$entiende); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso7.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}

function Paso7($cui,$duerme,$despierta,$terror,$insomnio,$crujido,$horas,$duerme_con){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$duerme,$despierta,$terror,$insomnio,$crujido,$horas,$duerme_con");
		
    if($cui != ""){
		//pasa a mayusculas
		$duerme = trim($duerme);
		$despierta = trim($despierta);
		$terror = trim($terror);
		$insomnio = trim($insomnio);
		$crujido = trim($crujido);
		$horas = trim($horas);
		$duerme_con = trim($duerme_con);
		//--------
		//decodificaciones de tildes y Ñ's
		$duerme = utf8_encode($duerme);
		$despierta = utf8_encode($despierta);
		$terror = utf8_encode($terror);
		$insomnio = utf8_encode($insomnio);
		$horas = utf8_encode($horas);
		$duerme_con = utf8_encode($duerme_con);
		//--
		$duerme = utf8_decode($duerme);
		$despierta = utf8_decode($despierta);
		$terror = utf8_decode($terror);
		$insomnio = utf8_decode($insomnio);
		$horas = utf8_decode($horas);
		$duerme_con = utf8_decode($duerme_con);
		//--------
		$sql = $ClsFic->insert_suenio($cui,$duerme,$despierta,$terror,$insomnio,$crujido,$horas,$duerme_con); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso8.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso8($cui,$solo,$exceso,$poco,$obligado,$habitos,$talla,$peso){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$solo,$exceso,$poco,$obligado,$habitos,$talla,$peso");
		
    if($cui != ""){
		//pasa a mayusculas
		$solo = trim($solo);
		$exceso = trim($exceso);
		$poco = trim($poco);
		$obligado = trim($obligado);
		$habitos = trim($habitos);
		$talla = trim($talla);
		$peso = trim($peso);
		//--------
		//decodificaciones de tildes y Ñ's
		$solo = utf8_encode($solo);
		$exceso = utf8_encode($exceso);
		$poco = utf8_encode($poco);
		$obligado = utf8_encode($obligado);
		$talla = utf8_encode($talla);
		$peso = utf8_encode($peso);
		//--
		$solo = utf8_decode($solo);
		$exceso = utf8_decode($exceso);
		$poco = utf8_decode($poco);
		$obligado = utf8_decode($obligado);
		$talla = utf8_decode($talla);
		$peso = utf8_decode($peso);
		//--------
		$sql = $ClsFic->insert_alimentacion($cui,$solo,$exceso,$poco,$obligado,$habitos,$peso,$talla); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso9.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso9($cui,$lentes,$uso,$irritacion,$secrecion,$se_acerca,$dolor,$desviacion,$otro){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	
    //$respuesta->alert("$cui,$lentes,$uso,$irritacion,$secrecion,$se_acerca,$dolor,$desviacion,$otro");
		
    if($cui != ""){
		//pasa a mayusculas
		$lentes = trim($lentes);
		$uso = trim($uso);
		$irritacion = trim($irritacion);
		$secrecion = trim($secrecion);
		$se_acerca = trim($se_acerca);
		$dolor = trim($dolor);
		$desviacion = trim($desviacion);
		$otro = trim($otro);
		//--------
		//decodificaciones de tildes y Ñ's
		$lentes = utf8_encode($lentes);
		$uso = utf8_encode($uso);
		$irritacion = utf8_encode($irritacion);
		$secrecion = utf8_encode($secrecion);
		$se_acerca = utf8_encode($se_acerca);
		$dolor = utf8_encode($dolor);
		$desviacion = utf8_encode($desviacion);
		$otro = utf8_encode($otro);
		//--
		$lentes = utf8_decode($lentes);
		$uso = utf8_decode($uso);
		$irritacion = utf8_decode($irritacion);
		$secrecion = utf8_decode($secrecion);
		$se_acerca = utf8_decode($se_acerca);
		$dolor = utf8_decode($dolor);
		$desviacion = utf8_decode($desviacion);
		$otro = utf8_decode($otro);
		//--------
		$sql = $ClsFic->insert_vista($cui,$lentes,$uso,$irritacion,$secrecion,$se_acerca,$dolor,$desviacion,$otro); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso10.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso10($cui,$afecciones,$cuales,$esfuerzo,$responde,$no_escucha){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	
    //$respuesta->alert("$cui,$afecciones,$cuales,$esfuerzo,$responde,$no_escucha");
		
    if($cui != ""){
		//pasa a mayusculas
		$afecciones = trim($afecciones);
		$cuales = trim($cuales);
		$esfuerzo = trim($esfuerzo);
		$responde = trim($responde);
		$no_escucha = trim($no_escucha);
		//--------
		//decodificaciones de tildes y Ñ's
		$afecciones = utf8_encode($afecciones);
		$cuales = utf8_encode($cuales);
		$esfuerzo = utf8_encode($esfuerzo);
		$responde = utf8_encode($responde);
		$no_escucha = utf8_encode($no_escucha);
		//--
		$afecciones = utf8_decode($afecciones);
		$cuales = utf8_decode($cuales);
		$esfuerzo = utf8_decode($esfuerzo);
		$responde = utf8_decode($responde);
		$no_escucha = utf8_decode($no_escucha);
		//--------
		$sql = $ClsFic->insert_oido($cui,$afecciones,$cuales,$esfuerzo,$responde,$no_escucha); /// actualiza;
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso11.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Paso11($cui,$arrcaracter,$filas){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFic = new ClsFicha();
	//$respuesta->alert("$cui,$afecciones,$cuales,$esfuerzo,$responde,$no_escucha");
	if($cui != ""){
		$sql = $ClsFic->delete_conducta_caracter($cui);
		if($filas > 0){
			for($i = 1; $i <= $filas; $i ++){
				$caracter = $arrcaracter[$i];
				$sql.= $ClsFic->insert_conducta_caracter($cui,$caracter); /// actualiza;
			}
		}
		
		$rs = $ClsFic->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
            $msj = '<h5>Datos actualizados satisfactoriamente!</h5><br><br>';
            $msj.= '<a class="btn btn-primary" href = "FRMpaso11.php?hashkey='.$hashkey.'" ><span class="fa fa-check"></span> Aceptar</a> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
            $msj = '<h5>Error en la transacci&oacute;n....</h5><br><br>';
            $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
            $respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}else{
		$msj = '<h5>Seleccione al menos un item....</h5><br><br>';
        $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
        $respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	
   return $respuesta;
}

//////////////////---- PASOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Paso1");
$xajax->register(XAJAX_FUNCTION, "Paso2");
$xajax->register(XAJAX_FUNCTION, "Paso3");
$xajax->register(XAJAX_FUNCTION, "Paso4");
$xajax->register(XAJAX_FUNCTION, "Paso5");
$xajax->register(XAJAX_FUNCTION, "Paso6");
$xajax->register(XAJAX_FUNCTION, "Paso7");
$xajax->register(XAJAX_FUNCTION, "Paso8");
$xajax->register(XAJAX_FUNCTION, "Paso9");
$xajax->register(XAJAX_FUNCTION, "Paso10");
$xajax->register(XAJAX_FUNCTION, "Paso11");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  