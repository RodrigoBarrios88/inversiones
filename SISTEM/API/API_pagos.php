<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);
//--
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "programados":
			$hijo = $_REQUEST["hijo"]; //cui
			API_pagos_programados($hijo);
			break;
		case "ejecutados":
			$hijo = $_REQUEST["hijo"]; //cui
			API_pagos_ejecutados($hijo);
			break;
		case "saldo":
			$hijo = $_REQUEST["hijo"]; //cui
			API_saldo($hijo);
			break;
		case "mora":
			$hijo = $_REQUEST["hijo"]; //cui
			API_mora($hijo);
			break;
		default:
			$arr_data = array(
			"status" => "error",
			"message" => "Parametros invalidos...");
			echo json_encode($arr_data);
			break;
	}
}else{
	//devuelve un mensaje de manejo de errores
	$arr_data = array(
		"status" => "error",
		"message" => "Delimite el tipo de consulta a realizar...");
		echo json_encode($arr_data);
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function API_lista_hijos($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['cui'] = $row["alu_cui"];
					$arr_data[$i]['tipo_cui'] = $row["alu_tipo_cui"];
					$arr_data[$i]['nombre'] = trim($row["alu_nombre"]);
					$arr_data[$i]['apellido'] = trim($row["alu_apellido"]);
					$arr_data[$i]['fecha_nacimiento'] = cambia_fecha($row["alu_fecha_nacimiento"]);
					$arr_data[$i]['edad'] = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
					$arr_data[$i]['genero'] = $row["alu_genero"];
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No exsisten hijos enlazados a este papa...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de padres...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_pagos_programados($hijo){
	$ClsBan = new ClsBanco();
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	
	if($hijo != ""){
		$arr_data = array();
		$result = $ClsBan->get_cuenta_banco('','','','','','',1);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				$cuecodigo = trim($row["cueb_codigo"]);
				$cuebanco = trim($row["cueb_banco"]);
				$numero = trim($row["cueb_ncuenta"]);
				$nombre = trim($row["cueb_nombre"]);
				$arr_boleta = array();
				//--------------
				$result_programado = $ClsBol->get_boleta_vs_pago('',$cuecodigo,$cuebanco,$hijo,'',$periodo,'','','',1,3);
				if(is_array($result_programado)){
						$j = 0;
						foreach($result_programado as $row_progra){
							$valor = $row_progra["bol_monto"];
							$mons = $row_progra["bol_simbolo_moneda"];
							$valor = number_format($valor, 2);
							$fecha = $row_progra["bol_fecha_pago"];
							$fecha = cambia_fecha($fecha);
							$motivo = trim($row_progra["bol_motivo"]);
							//--
							$arr_boleta[$j]['boleta'] = Agrega_Ceros($row_progra["bol_codigo"]);
							$arr_boleta[$j]['monto'] = "$mons. $valor";
							$arr_boleta[$j]['fecha_pago'] = $fecha;
							$arr_boleta[$j]['motivo'] = $motivo;
							$j++;
						}
						
				}else{
					//no hay boletas	
				}
				$arr_data[$i]['rubro'] = $nombre;
				$arr_data[$i]['boletas'] = $arr_boleta;
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No hay pagos programados para este alumno en este año...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI del alumno esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_pagos_ejecutados($hijo){
	$ClsBan = new ClsBanco();
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	
	if($hijo != ""){
		$arr_data = array();
		$result = $ClsBan->get_cuenta_banco('','','','','','',1);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				$cuecodigo = trim($row["cueb_codigo"]);
				$cuebanco = trim($row["cueb_banco"]);
				$numero = trim($row["cueb_ncuenta"]);
				$nombre = trim($row["cueb_nombre"]);
				$arr_boleta = array();
				//--------------
				$result_ejecutados = $ClsBol->get_boleta_vs_pago('',$cuecodigo,$cuebanco,$hijo,'',$periodo,'','','',1,3);
				$j = 0;
				if(is_array($result_ejecutados)){
					foreach($result_ejecutados as $row_ejecutado){
						$pago = $row_ejecutado["pag_codigo"];
						if($pago != ""){
							$valor = $row_ejecutado["pag_total"]; /// monto registrado en la boleta, ya con descuento
							$mons = $row_ejecutado["bol_simbolo_moneda"];
							$valor = number_format($valor, 2);
							$fecha = $row_ejecutado["pag_fechor"];
							$fecha = cambia_fechaHora($fecha);
							$motivo = trim($row_ejecutado["bol_motivo"]);
							//--
							$arr_boleta[$j]['boleta'] = $row_ejecutado["pag_programado"];
							$arr_boleta[$j]['monto'] = "$mons. $valor";
							$arr_boleta[$j]['fecha_pago'] = $fecha;
							$arr_boleta[$j]['motivo'] = $motivo;
							$j++;
						}
					}
				}
				$result_aislado = $ClsBol->get_pago_aislado('',$cuenta,$banco, $hijo,'',$periodo,'','0','','','','');
				if(is_array($result_aislado)){
					foreach($result_aislado as $row_aislado){
						$valor = $monto = $row_aislado["pag_efectivo"]+$row_aislado["pag_cheques_propios"]+$row_aislado["pag_otros_bancos"]+$row_aislado["pag_online"];
						$mons = $row_aislado["mon_simbolo"];
						$valor = number_format($valor, 2);
						$fecha = $row_aislado["pag_fechor"];
						$fecha = cambia_fechaHora($fecha);
						$motivo = trim($row_aislado["bol_motivo"]);
						//--
						$arr_boleta[$j]['boleta'] = $row_aislado["pag_programado"];
						$arr_boleta[$j]['monto'] = "$mons. $valor";
						$arr_boleta[$j]['fecha_pago'] = $fecha;
						$arr_boleta[$j]['motivo'] = 'Pago de boleta no programado';
						$j++;
					}
					
				}
				$arr_data[$i]['rubro'] = $nombre;
				$arr_data[$i]['boletas'] = $arr_boleta;
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No hay pagos ejecutados para este alumno en este año...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI del alumno esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_saldo($hijo){
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	
	if($hijo != ""){
		////// AÑO DE CARGOS A LISTAR /////////
		$anio_actual = $ClsPer->get_anio_periodo($periodo);
		$anio = $_REQUEST["anio"];
		$anio = ($anio == "")?$anio_actual:$anio;
		//// fechas ///
		if($anio == $anio_actual){
			$mes = date("m"); ///mes de este año para calculo de saldos y moras
			$fini = "01/01/$anio";
			$ffin = "31/$mes/$anio";
			$titulo_programado = "Programado a la fecha:";
			$titulo_pagado = "Pagado a la fecha:";
		}else{
			$fini = "01/01/$anio";
			$ffin = "31/12/$anio";
			$titulo_programado = "Programado para el año $anio:";
			$titulo_pagado = "Pagado del el año $anio:";
		}
		
		/////// PROGRAMADO ////////
		$ClsBol = new ClsBoletaCobro();
		$result = $ClsBol->get_boleta_vs_pago('',$cuenta,'',$hijo,'',$periodo,'',$fini,$ffin,1,2);
		$monto_programdo = 0;
		$monto_pagado = 0;
		$referenciaX;
		if(is_array($result)){
			foreach($result as $row){
				$bolcodigo = $row["bol_codigo"];
				$mons = $row["bol_simbolo_moneda"];
				if($bolcodigo != $referenciaX){
					$monto_programdo+= $row["bol_monto"];
					$fecha_programdo = $row["bol_fecha_pago"];
					$fecha_pago = $row["pag_fechor"];
					$referenciaX = $bolcodigo;
				}
				$monto_pagado+= $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
			}
		}
		//echo $monto_programdo;
		$valor_programado = $mons .". ".number_format($monto_programdo, 2, '.', ',');
		
		/////// PAGADO ////////
		$ClsBol = new ClsBoletaCobro();
		$result = $ClsBol->get_pago_aislado('',$cuenta,'', $hijo,'',$periodo,'','0','',$fini,$ffin,'');
		if(is_array($result)){
			foreach($result as $row){
				$mons = $row["mon_simbolo"];
				$monto_pagado+= $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			}
		}
		//echo $monto_pagado;
		$valor_pagado = $mons .". ".number_format($monto_pagado, 2, '.', ',');
		
		////////// CALUCULO DE SOLVENCIA ///////////
		$diferencia = $monto_programdo - $monto_pagado;
		$diferencia = round($diferencia, 2);
		if($diferencia <= 0){
			$diferencia = ($diferencia * -1);
			$fecha_programdo = cambia_fechaHora($fecha_programdo);
			$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
			$arr_data['texto'] = 'SOLVENTE';
			$arr_data['diferencia'] = 'A FAVOR';
			$arr_data['saldo'] = $diferencia;
			$arr_data['fecha_ultimo_pago'] = $fecha_programdo;
		}else{
			if($anio == $anio_actual){
				$hoy = date("Y-m-d");
				//echo "$fecha_programdo < $hoy";
				if($fecha_programdo < $hoy){
					$fecha_programdo = cambia_fecha($fecha_programdo);
					$diferencia = $mons ." ".number_format($diferencia, 2);
					$arr_data['texto'] = 'FECHA DE PAGO EXPIRADA!';
					$arr_data['diferencia'] = 'EN CONTRA';
					$arr_data['saldo'] = $diferencia;
					$arr_data['fecha_programada_pago'] = $fecha_programdo;
				}else{
					$fecha_programdo = cambia_fecha($fecha_programdo);
					$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
					$arr_data['texto'] = 'SALDO PARA ESTE MES';
					$arr_data['diferencia'] = 'PENDIENTE';
					$arr_data['saldo'] = $diferencia;
					$arr_data['fecha_programada_pago'] = $fecha_programdo;
				}
			}else{
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
				$arr_data['texto'] = 'SALDO PARA ESTE MES';
				$arr_data['diferencia'] = 'PENDIENTE';
				$arr_data['saldo'] = $diferencia;
				$arr_data['fecha_programada_pago'] = $fecha_programdo;
			}
		}
		
		echo json_encode($arr_data);
		
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI del alumno esta vacio");
			echo json_encode($arr_data);
	}
	
}




function API_mora($hijo){
	$ClsBol = new ClsBoletaCobro();
	
	if($hijo != ""){
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No hay moras...");
			echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI del alumno esta vacio");
			echo json_encode($arr_data);
	}
	
}





