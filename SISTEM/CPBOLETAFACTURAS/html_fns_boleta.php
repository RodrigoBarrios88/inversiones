<?php 
include_once('../html_fns.php');

function tabla_lista_cargas(){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_carga_electronica($cod); 
	
	if(is_array($result)){
		$salida = '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "5px">No.</th>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "30px">CODIGO</th>';
		$salida.= '<th class = "text-center" width = "150px">CUENTA</th>';
		$salida.= '<th class = "text-center" width = "150px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "150px">FECHA DE CARGA</th>';
		$salida.= '<th class = "text-center" width = "50px">OBSERVACIONES</th>'; 
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			//-------- Lista archivos
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'. </td>';
			//--
			$carga = $row["car_codigo"];
			$usu = $_SESSION["codigo"];
			$confactura = $row["carga_con_factura"];
			$conrecibo = $row["carga_con_recibo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			if($confactura == "" && $conrecibo == ""){
				$salida.= '<td class = "text-center">';
				$salida.= '<a class="btn btn-outline  btn-success" title="Generar Facturas" href="FRMgestor_facturas.php?hashkey='.$hashkey.'" ><i class="fa fa-dollar"></i> Factura</a> ';
				$salida.= '</td>';
				$salida.= '<td class = "text-center">';
				$salida.= '<a class="btn btn-outline  btn-info" title="Generar Recibos" href="FRMgestor_recibos.php?hashkey='.$hashkey.'" ><i class="fa fa-check"></i> Recibo</a> ';
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center">';
				$salida.= '<button class="btn btn-success" title="Generar Facturas" disabled ><i class="fa fa-dollar" ></i> Factura</button> ';
				$salida.= '</td>';
				$salida.= '<td class = "text-center">';
				$salida.= '<button class="btn btn-info" title="Generar Recibos" disabled ><i class="fa fa-check"></i> Recibo</button> ';
				$salida.= '</td>';
			}
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-outline  btn-default" title="Generar Recibos" href="FRMvisualizador_facturas.php?hashkey='.$hashkey.'" '.$disabled.' ><i class="fa fa-search"></i> Visualizar</a> ';
			$salida.= '</td>';
			//codigo
			$codigo = $row["car_codigo"];
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//cuenta
			$cuenta = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center" >'.$cuenta.'</td>';
			//Banco
			$banco = $row["ban_desc_lg"];
			$salida.= '<td class = "text-center" >'.$banco.'</td>';
			//fecha de Carga
			$fecha = $row["car_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//observaciones
			$confactura = $row["carga_con_factura"];
			$conrecibo = $row["carga_con_recibo"];
			if($confactura != "" && $conrecibo == ""){
				$observaciones = 'Se generaron facturas';
			}else if($confactura == "" && $conrecibo != ""){
				$observaciones = 'Se generaron recibos';
			}else{
				$observaciones = '---';
			}
			$salida.= '<td class = "text-center" >'.$observaciones.'</td>';
			//--
			$salida.= '</tr>';
			//--------
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_pagos_carga_electronica($carga,$fecha_manual){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pagos_de_carga($carga);
	if(is_array($result)){
		$salida = '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n</th>';
		$salida.= '<th class = "text-center" width = "40px"># Boleta</th>';
		$salida.= '<th class = "text-center" width = "40px"># Referencia</th>';
		$salida.= '<th class = "text-center" width = "60px">Fecha Pago</th>';
		$salida.= '<th class = "text-center" width = "40px">Monto</th>';
		$salida.= '<th class = "text-center" width = "40px">Descuento</th>';
		$salida.= '<th class = "text-center" width = "40px">Saldo</th>';
		$salida.= '<th class = "text-center" width = "40px">Pagado</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			if($row["alu_cui"] != ""){
				$comprueba_alumno = $row["alu_cui"];
				$cliente = $row["alu_cliente_factura"];
			}else if($row["alu_inscripciones_cui"] != ""){ //comprueba existencia de alumno (en modulo de inscripciones / no activo en el sistema)
				$comprueba_alumno = $row["alu_inscripciones_cui"];
				$cliente = $row["alu_inscripciones_cliente_factura"];
			}else{
				$comprueba_alumno = "";
			}
			/// si reconoce al alumno lo agrega al listado, si no, NO
			if($comprueba_alumno != ""){
			////-- Comprobaciones
				$iconos = "";
				$facturado = $row["pag_facturado"]; ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
				
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$alumno = $row["pag_alumno"];
				$monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha,0,10);
				$fecha = ($fecha_manual != "")?$fecha_manual:$fecha;
				$motivo = utf8_decode($row["bol_motivo"]);
				$motivo = ($motivo == "")?"Pago no programdo":$motivo;
				//--comprueba
				$codpago = $row["pag_codigo"];
				$programado = $row["pag_referencia"];
				$boleta = $row["bol_codigo"];
				$valida_boleta = ($programado == $boleta)?1:"";
				$valida_alumno = ($comprueba_alumno == $alumno)?$alumno:"";
				$cliente = ($cliente == "")?0:$cliente;
				if($valida_boleta == "" && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta != "" && $valida_alumno != ""){
					$class = "";
					$iconos = ' <span class="fa fa-check text-success" title ="Datos Correctos"></span> ';
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == ""){
					$iconos.= ' <span class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></span> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <span class="fa fa-user text-danger" title ="No existe el alumno"></span> ';
					$errores_alumnos++;
				}
				if($facturado == 1){
					$class = "success";
					$iconos = ' <label><span class="fa fa-text-file-o" title ="Este pago ya fue facturado!"></span> FACTURADO</label>';
				}if($facturado == 2){
					$class = "success";
					$iconos = ' <label><span class="fa fa-text-file-o" title ="Este pago ya se le gener&oacute; recibo!"></span> RECIBO</label>';
				}
				//--------
				$salida.= '<tr class="'.$class.'">';
				//--No.
				$salida.= '<td class = "text-center" >'.$i.'. </td>';
				//boton
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$referencia.'\',\''.$cuenta.'\',\''.$banco.'\')" ><span class="fa fa-search"></span></button> ';
				$salida.= '<input type = "hidden" name = "codpago'.$i.'" id = "codpago'.$i.'" value = "'.$codpago.'" />'; /// valida con el codigo de pago
				$salida.= '<input type = "hidden" name = "facturado'.$i.'" id = "facturado'.$i.'" value = "'.$facturado.'" />'; /// valida con el codigo de pago
				$salida.= '<input type = "hidden" name = "boleta'.$i.'" id = "boleta'.$i.'" value = "'.$referencia.'" />';
				$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$alumno.'" />';
				$salida.= '<input type = "hidden" name = "cli'.$i.'" id = "cli'.$i.'" value = "'.$cliente.'" />';
				$salida.= '<input type = "hidden" name = "monto'.$i.'" id = "monto'.$i.'" value = "'.$monto_total.'" />';
				$salida.= '<input type = "hidden" name = "fecha'.$i.'" id = "fecha'.$i.'" value = "'.$fecha.'" />';
				$salida.= '<input type = "hidden" name = "desc'.$i.'" id = "desc'.$i.'" value = "'.$motivo.'" />';
				$salida.= ' &nbsp; '.$iconos.'</td>';
				//motivo
				$nit = trim($row["alu_nit"]);
				$motivo = utf8_decode($row["bol_motivo"]);
				$motivo = ($motivo == "")?"Pago no programdo":$motivo;
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//fecha de pago
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$valor = $row["pag_total"];
				$mons = $row["pag_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($valor, 2, '.',',').'</td>';
				//--
				$salida.= '</tr>';
				//--
				$i++;
			}	
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" />';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_facturas_carga($carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_factura('','',$carga,'','','','','');
	$usu = $_SESSION["codigo"];
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<div class="alert alert-info text-center">';
			$salida.= '<h6>Facturas emitidas por esta Carga Electr&oacute;nica</h6>';
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$salida.= '<a type="button" class="btn btn-default" title="Ver todas las facturas" href = "../../CONFIG/FACTURAS/REPfacturas_carga.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-files-o"></span></a>';
			$salida.= '</div>';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-facturas">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "40px">NIT</th>';
		$salida.= '<th class = "text-center" width = "60px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "40px">FECHA</th>';
		$salida.= '<th class = "text-center" width = "40px">SITUACI&Oacute;N</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$situacion = $row["fac_situacion"];
			if($situacion == 0){
				$class = "danger";
			}else{
				$class = "";
			}	
			//--------
			$salida.= '<tr class="'.$class.'">';
			$salida.= '<td class = "text-center">';
			$serie = $row["fac_serie"];
			$factura = $row["fac_numero"];
			$hashkey1 = $ClsBol->encrypt($serie, $usu);
			$hashkey2 = $ClsBol->encrypt($factura, $usu);
			$salida.= '<a type="button" class="btn btn-default" title="Ver Factura Individual " href = "../../CONFIG/FACTURAS/REPfactura.php?hashkey1='.$hashkey1.'&hashkey1='.$hashkey2.'" target = "_blank" ><span class="fa fa-file-text-o"></span></a>';
			$salida.= '</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["fac_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//factura
			$serie = $row["ser_numero"];
			$factura = $row["fac_numero"];
			$salida.= '<td class = "text-center" >'.$serie.' '.$factura.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//nit
			$nit = $row["cli_nit"];
			$salida.= '<td class = "text-center" >'.$nit.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left" >'.$cliente.'</td>';
			//monto
			$valor = $row["fac_monto"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//Fecha de Pago
			$fecha = $row["fac_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//situacion
			$situacion = $row["fac_situacion"];
			if($situacion == 1){
				$salida.= '<td class = "text-center" ><span class = "text-success">Facturado</span></td>';
			}else{
				$salida.= '<td class = "text-center"><strong class = "text-danger"><i class = "fa fa-ban"></i> ANULADA</strong></td>';
			}
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_facturas_carga_electronica($suc,$serie){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_factura('',$serie,'','','','',$suc,'',1);
	$usu = $_SESSION["codigo"];
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-facturas">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "40px">NIT</th>';
		$salida.= '<th class = "text-center" width = "60px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "40px">FECHA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			//--------
			$salida.= '<tr class="'.$class.'">';
			//--
			$serie = $row["fac_serie"];
			$factura = $row["fac_numero"];
			$hashkey1 = $ClsBol->encrypt($serie, $usu);
			$hashkey2 = $ClsBol->encrypt($factura, $usu);
			$salida.= '<td class = "text-center">';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" title="Editar Datos de Factura" onclick = "abrir();xajax_Buscar_Factura('.$serie.','.$factura.');" ><span class="fa fa-edit"></span></button> ';
					$salida.= '<button type="button" class="btn btn-danger" title="Anular Factura" onclick = "ConfirmAnularFactura('.$serie.','.$factura.')" ><span class="fa fa-trash-o"></span></button> ';
					$salida.= '<a type="button" class="btn btn-primary" title="Ver Factura Individual" href = "../../CONFIG/FACTURAS/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
				$salida.= '</div>';
			$salida.= '</td>';
			
				
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["fac_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//factura
			$serie = $row["ser_numero"];
			$factura = $row["fac_numero"];
			$salida.= '<td class = "text-center" >'.$serie.' '.$factura.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//nit
			$nit = $row["cli_nit"];
			$salida.= '<td class = "text-center" >'.$nit.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left" >'.$cliente.'</td>';
			//monto
			$valor = $row["fac_monto"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//Fecha de Pago
			$fecha = $row["fac_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_recibos_carga($carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_recibo('','',$carga,'','','','','',1);
	$usu = $_SESSION["codigo"];
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<div class="alert alert-info text-center">';
			$salida.= '<h6>Recibos emitidos por esta Carga Electr&oacute;nica</h6>';
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$salida.= '<a type="button" class="btn btn-default" title="Ver todos las Recibos " href = "../../CONFIG/FACTURAS/REPrecibos_carga.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-files-o"></span></a>';
			$salida.= '</div>';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-recibos">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">RECIBO</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "40px">NIT</th>';
		$salida.= '<th class = "text-center" width = "60px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "40px">FECHA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			//--------
			$salida.= '<tr class="'.$class.'">';
			$salida.= '<td class = "text-center">';
			$serie = $row["rec_serie"];
			$recibo = $row["rec_numero"];
			$hashkey1 = $ClsBol->encrypt($serie, $usu);
			$hashkey2 = $ClsBol->encrypt($recibo, $usu);
			$salida.= '<a type="button" class="btn btn-default" title="Ver Recibo Individual " href = "../../CONFIG/FACTURAS/REPrecibo.php?hashkey1='.$hashkey1.'&hashkey1='.$hashkey2.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
			$salida.= '</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["rec_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//recibo
			$serie = $row["ser_numero"];
			$recibo = $row["rec_numero"];
			$salida.= '<td class = "text-center" >'.$serie.' '.$recibo.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//nit
			$nit = $row["cli_nit"];
			$salida.= '<td class = "text-center" >'.$nit.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left" >'.$cliente.'</td>';
			//monto
			$valor = $row["rec_monto"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//Fecha de Pago
			$fecha = $row["rec_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_recibos_carga_electronica($suc,$serie){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_recibo('',$serie,'','','','',$suc,'',1);
	$usu = $_SESSION["codigo"];
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-recibos">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">RECIBO</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "40px">NIT</th>';
		$salida.= '<th class = "text-center" width = "60px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "40px">FECHA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			//--------
			$salida.= '<tr class="'.$class.'">';
			$serie = $row["rec_serie"];
			$recibo = $row["rec_numero"];
			$hashkey1 = $ClsBol->encrypt($serie, $usu);
			$hashkey2 = $ClsBol->encrypt($recibo, $usu);
			$salida.= '<td class = "text-center">';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" title="Editar Datos del Recibo" onclick = "abrir();xajax_Buscar_Recibo('.$serie.','.$recibo.');" ><span class="fa fa-edit"></span></button>';
					$salida.= '<button type="button" class="btn btn-danger" title="Anular Recibo" onclick = "ConfirmAnularRecibo('.$serie.','.$recibo.')" ><span class="fa fa-trash-o"></span></button>';
					$salida.= '<a type="button" class="btn btn-primary" title="Ver Recibo Individual" href = "../../CONFIG/FACTURAS/REPrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-print"></span></a>';
				$salida.= '</div>';
			$salida.= '</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["rec_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//recibo
			$serie = $row["ser_numero"];
			$recibo = $row["rec_numero"];
			$salida.= '<td class = "text-center" >'.$serie.' '.$recibo.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//nit
			$nit = $row["cli_nit"];
			$salida.= '<td class = "text-center" >'.$nit.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left" >'.$cliente.'</td>';
			//monto
			$valor = $row["rec_monto"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//Fecha de Pago
			$fecha = $row["rec_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}





function tabla_boletas($cue,$ban,$referencia,$fini,$ffin,$acc){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('',$cue,$ban,$alumno,$referencia,$periodo,'','','',$fini,$ffin,2);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "50px">CUENTA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "60px">FECHA PAGO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr">';
			//--------
			$salida.= '<td class = "text-center">';
			$facturado = $row["pag_facturado"]; ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
			$codigo = $row["pag_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($codigo, $usu);
			if($acc == "FAC" && $facturado == 0){
			$salida.= '<a type="button" class="btn btn-info" title="Seleccionar Boleta para Generar Factura" href = "FRMnewfactura.php?hashkey='.$hashkey.'"><span class="fa fa-file-text-o"></span></a>';
			}else if($acc == "REC" && $facturado == 0){
			$salida.= '<a type="button" class="btn btn-default" title="Seleccionar Boleta para Generar Recibo" href = "FRMnewrecibo.php?hashkey='.$hashkey.'"><span class="fa fa-file-text-o"></span></a>';
			}else{
				$label = ($facturado == 1)?'YA FUE FACTURADO':'YA SE GENER&Oacute; RECIBO';
				$salida.= '<label class = "text-info"><i class = "fa fa-info-circle"></i> '.$label.'</label>';
			}
			$salida.= '</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//cuenta
			$cuenta = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center" >'.$cuenta.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//descripcion
			$descripcion = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-left" >'.$descripcion.'</td>';
			//Fecha de Registro
			$fecreg = $row["pag_fechor"];
			$fecreg = cambia_fechaHora($fecreg);
			$salida.= '<td class = "text-center" >'.$fecreg.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_facturas($num,$ser,$suc,$referencia,$fini,$ffin){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_factura($num,$ser,$carga,$referencia,$cli,$alumno,$suc,'','',$fini,$ffin);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "60px">FECHA PAGO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr">';
			//--------
			$salida.= '<td class = "text-center">';
			$situacion = $row["fac_situacion"];
			$numero = $row["fac_numero"];
			$serie = $row["fac_serie"];
			$codpago = $row["fac_pago"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBol->encrypt($numero, $usu);
			$hashkey2 = $ClsBol->encrypt($serie, $usu);
			if($situacion != 0){
				$salida.= '<div class="btn-group">';
				$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Factura a Editar" href = "FRMeditfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'"><span class="fa fa-edit"></span></a>';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Factura" onclick="ConfirmAnularFactura('.$serie.','.$numero.','.$codpago.');"><span class="fa fa-trash-o"></span></button>';
				$salida.= '</div>';
			}else{
			    $salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Factura a Editar" href = "FRMeditfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'"><span class="fa fa-edit"></span></a> &nbsp; ';
				$salida.= '<label class = "text-danger">ANULADA</label>';
			}
			$salida.= '</td>';
			//factura
			$serdesc = $row["ser_numero"];
			$numero = $row["fac_numero"];
			$salida.= '<td class = "text-center" >'.$serdesc.' '.$numero.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["fac_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//descripcion
			$descripcion = utf8_decode($row["fac_descripcion"]);
			$salida.= '<td class = "text-left" >'.$descripcion.'</td>';
			//Fecha de Registro
			$fecha = $row["fac_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_recibos($num,$ser,$suc,$referencia,$fini,$ffin){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_recibo($num,$ser,$carga,$referencia,$cli,$alumno,$suc,'','',$fini,$ffin);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">RECIBO</th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "60px">FECHA PAGO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr">';
			//--------
			$situacion = $row["rec_situacion"];
			$salida.= '<td class = "text-center">';
			if($situacion != 0){
				$numero = $row["rec_numero"];
				$serie = $row["rec_serie"];
				$codpago = $row["rec_pago"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<div class="btn-group">';
					$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Recibo a Editar" href = "FRMeditrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'"><span class="fa fa-edit"></span></a>';
					$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Recibo" onclick="ConfirmAnularRecibo('.$serie.','.$numero.','.$codpago.');"><span class="fa fa-trash-o"></span></button>';
				$salida.= '</div>';
			}else{
				$salida.= '<label class = "text-danger"><i class = "fa fa-ban"></i> ANULADO</label>';
			}
			$salida.= '</td>';
			//recibo
			$serdesc = $row["ser_numero"];
			$numero = $row["rec_numero"];
			$salida.= '<td class = "text-center" >'.$serdesc.' '.$numero.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["rec_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//descripcion
			$descripcion = utf8_decode($row["rec_descripcion"]);
			$salida.= '<td class = "text-left" >'.$descripcion.'</td>';
			//Fecha de Registro
			$fecha = $row["rec_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_lista_facturas($suc,$ser,$num,$alumno,$referencia,$carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_factura($num,$ser,$carga,$referencia,'',$alumno,$suc,'','','','');
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "60px">FECHA PAGO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr">';
			//--------
			$salida.= '<td class = "text-center">';
			$situacion = $row["fac_situacion"];
			if($situacion != 0){
				$numero = $row["fac_numero"];
				$serie = $row["fac_serie"];
				$codpago = $row["fac_pago"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<a class="btn btn-default btn-xs" title="Imprimir Factura" target="_blank" href = "../../CONFIG/FACTURAS/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'"><span class="fa fa-print"></span></a> &nbsp; ';
			}else{
				$salida.= '<label class = "text-danger"><i class = "fa fa-ban"></i> ANULADA</label>';
			}
			$salida.= '</td>';
			//factura
			$serdesc = $row["ser_numero"];
			$numero = $row["fac_numero"];
			$salida.= '<td class = "text-center" >'.$serdesc.' '.$numero.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["fac_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//descripcion
			$descripcion = utf8_decode($row["fac_descripcion"]);
			$salida.= '<td class = "text-left" >'.$descripcion.'</td>';
			//Fecha de Registro
			$fecha = $row["fac_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}



function tabla_lista_recibos($suc,$ser,$num,$alumno,$referencia,$carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_recibo($num,$ser,$carga,$referencia,'',$alumno,$suc,'','','','');
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">RECIBO</th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "60px">FECHA PAGO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr">';
			//--------
			$salida.= '<td class = "text-center">';
			$situacion = $row["rec_situacion"];
			if($situacion != 0){
				$numero = $row["rec_numero"];
				$serie = $row["rec_serie"];
				$codpago = $row["rec_pago"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<a class="btn btn-default btn-xs" title="Imprimir recibo" target="_blank" href = "../../CONFIG/FACTURAS/REPrecibo.php?hashkey1='.$hashkey1.'&hashkey1='.$hashkey2.'"><span class="fa fa-print"></span></a> &nbsp; ';
			}else{
				$salida.= '<label class = "text-danger"><i class = "fa fa-ban"></i> ANULADA</label>';
			}
			$salida.= '</td>';
			//factura
			$serdesc = $row["ser_numero"];
			$numero = $row["rec_numero"];
			$salida.= '<td class = "text-center" >'.$serdesc.' '.$numero.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["rec_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//descripcion
			$descripcion = utf8_decode($row["rec_descripcion"]);
			$salida.= '<td class = "text-left" >'.$descripcion.'</td>';
			//Fecha de Registro
			$fecha = $row["rec_fecha"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}


////////////////////////// TABLAS POR ALUMNOS ///////////////////////////////////////////

function tabla_alumnos($pensum,$nivel,$grado,$seccion,$acc){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">CUI</td>';
		$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
		$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
		$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			$sit = $row["alu_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAcad->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
		if($acc == "REC" || $acc =="FAC"){
			$salida.= '<a class="btn btn-primary" href="FRMalumno.php?hashkey='.$hashkey.'&acc='.$acc.'" title = "Listar Boletas del Alumno" > <span class="fa fa-file-text-o"></span> </a>';
			}else{
				$salida.= '<a class="btn btn-primary" href="FRMfacturas_recibos_gene.php?hashkey='.$hashkey.'&acc='.$acc.'" title = "Listar Boletas del Alumno" > <span class="fa fa-file-text-o"></span> </a>';
			}
			$salida.= '</td>';
			//cui
			$cui = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo interno
			$codigo = utf8_decode($row["alu_codigo_interno"]);
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-center">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-center">'.$pad.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			$salida.= '</tr>';
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}
function tabla_pagos_alumno($cod,$alumno,$periodo,$acc){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro($cod,'','',$alumno,'',$periodo);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<div class="alert alert-success text-center">';
			$salida.= '<h6>Pagos ya realizados este a&ntilde;o</h6>';
			$salida.= '</div>';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-2">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "3px" height = "30px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px"></th>';
		$salida.= '<th class = "text-center" width = "15px"></th>';
		$salida.= '<th class = "text-center" width = "10px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "10px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "30px">FECHA DE PAGO</th>';
		$salida.= '<th class = "text-center" width = "5px"></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			////-- Comprobaciones
			$referencia = $row["pag_referencia"];
			$codigo = $row["pag_codigo"];
			$alumno = $row["pag_alumno"];
			$facturado = $row["pag_facturado"];
			$monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			//--------
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//--
			$salida.= '<td class = "text-center">';
			if($facturado > 0){ /////// Controles de Edicion de facturas
				if($facturado == 1){
				$numero = $row["fac_numero"];
				$serie = $row["fac_serie"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Factura a Editar" href = "FRMeditfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a> ';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Factura" onclick="ConfirmAnularFactura('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
				}else if($facturado == 2){
				$numero = $row["rec_numero"];
				$serie = $row["rec_serie"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Recibo a Editar" href = "FRMeditrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a> ';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Recibo" onclick="ConfirmAnularRecibo('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
				}	
			}else{ ///controles de generación de facturas
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($codigo, $usu);
				$salida.= '<a class="btn btn-info btn-xs" title="Generar Factura" href = "FRMnewfactura.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a> ';
				$salida.= '<a class="btn btn-default btn-xs" title="Generar Recibo" href = "FRMnewrecibo.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
			}
			$salida.= '</td>';
			//factura
			//$factura = $row["pag_transaccion"];
			if($facturado == 1){
				$numdesc = $row["fac_numero"];
				$serdesc = $row["fac_serie_numero"];
				$facturado = '<label class = "text-info">FACTURA '.$serdesc.'-'.$numdesc.'</label>';
			}else if($facturado == 2){
				$numdesc = $row["rec_numero"];
				$serdesc = $row["rec_serie_numero"];
				$facturado = '<label>RECIBO '.$serdesc.'-'.$numdesc.'</label>';
			}else{
				$facturado = "<em>Pendiente</em>";
			}
			$salida.= '<td class = "text-center" >'.$facturado.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$cuenta = $row["pag_cuenta"];
			$banco = $row["pag_banco"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//efectivo
			$valor = $row["pag_efectivo"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//chequede propio banco
			$valor = $row["pag_cheques_propios"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			//$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//cheque de otros bancos
			$valor = $row["pag_otros_bancos"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			//$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//Pagos Online
			$valor = $row["pag_online"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			//$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//boleta
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$referencia.'\',\''.$cuenta.'\',\''.$banco.'\');" ><span class="fa fa-search"></span></button> &nbsp; ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------


function tabla_fac_rec_gener($alumno,$periodo,$division,$grupo){
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	
	$orderby = 3;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('',$division,$grupo,$alumno,'',$periodo,'','','',1,$orderby);
	$result_aislado = $ClsBol->get_pago_aislado('',$division,$grupo, $alumno,'',$periodo,'','0','','','','');
	$salida.= '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<thead>';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "5px">No.</th>';
	$salida.= '<th class = "text-center" width = "50px"></th>';
	$salida.= '<th class = "text-center" width = "50px"></th>';
	$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n</th>';
	$salida.= '<th class = "text-center" width = "40px"># Boleta</th>';
	$salida.= '<th class = "text-center" width = "40px"># Referencia</th>';
	$salida.= '<th class = "text-center" width = "60px">Fecha Limite / Fecha Pago</th>';
	$salida.= '<th class = "text-center" width = "40px">Monto Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Descuento Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Saldo por Pagar</th>';
	$salida.= '<th class = "text-center" width = "40px">Pagado</th>';
	$salida.= '</tr>';
	$salida.= '</thead>';
	$i = 1;
	$referenciaX = '';
	$montoTotal = 0;
	$saldoTotal = 0;
	if(is_array($result)){
		foreach($result as $row){
			////-- Comprobaciones
			$bolcodigo = $row["bol_codigo"];
			if($bolcodigo != $referenciaX){
				//-------------------------------------------------------------------------------------------------------------------------------------------------------
				$salida.= '<tr class="info">';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//--
				// $referenciarec =$row ["rec_referencia"];	
				// $referenciafac = $row["fac_referencia"];
				$cuenta = $row["bol_cuenta"];
				$banco = $row["bol_banco"];
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button> ';
				$salida.= '</td>';
				//--
				$pagado_desc = ($pagado == 1)?"- pagado -":" pendiente de pago";
				$salida.= '<td class = "text-center">'.$pagado_desc.'</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//Fecha de Pago
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				$montoTotal+= $row["bol_monto"];
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
				$referenciaX = $bolcodigo;
			}else{
				$i--;
			}
			//-------------------------------------------------------------------------------------------------------------------------------------------------------
			$pago = $row["pag_codigo"];
			$facturado = $row["pag_facturado"];
			if($pago != ""){
				$iconos = "";
				$boleta = $row["pag_programado"];
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$alumno = $row["pag_alumno"];
				$monto_total = floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				/// valido
				$validaBoleta = $ClsBol->comprueba_boleta_cobro($boleta);
				$valida_boleta = $validaBoleta["valida"];
				$codigo_boleta = $validaBoleta["bol_codigo"];
				$valida_monto = floatval($validaBoleta["bol_monto"]);
				$valida_pagado = $validaBoleta["bol_pagado"];
				$situacion_boleta = $validaBoleta["bol_situacion"];
				//--
				$valida_alumno = $ClsBol->comprueba_alumno($alumno);
				if($valida_boleta == false && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto != $monto_total)){
					$class = "info";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto == $monto_total)){
					$class = "";
					$iconos = ' <i class="fa fa-check text-success" title ="Datos Correctos"></i> ';
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <i class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></i> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <i class="fa fa-user text-danger" title ="No existe el alumno"></i> ';
					$errores_alumnos++;
				}
				if($valida_boleta == true && ($valida_monto != $monto_total)){
					$iconos.= ' <i class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></i> ';
					$errores_monto++;
				}
				
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				//--
				$codigo = $row["pag_codigo"];
				if($facturado > 0){ /////// Controles de Edicion de facturas
					if($facturado == 1){
					$numero = $row["fac_numero"];
					$serie = $row["fac_serie"];
					$usu = $_SESSION["codigo"];
					$bolcodigo = $row["bol_codigo"];
					$hashkey1 = $ClsBol->encrypt($numero, $usu);
					$hashkey2 = $ClsBol->encrypt($serie, $usu);
					$hashkey3 = $ClsBol->encrypt($bolcodigo,$usu);
					$salida.= '<td class = "text-center" >';
					$referenciafac =$row ["fac_referencia"];	
						$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-info btn-xs" title="Imprimir Factura" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'"><span class="fa fa-print"></span></a> &nbsp; ';
						$salida.= '</div>';
					$salida.= '</td>';
					}else if($facturado == 2){
					$numero = $row["rec_numero"];
					$serie = $row["rec_serie"];
					$usu = $_SESSION["codigo"];
					$referencia = $row["bol_referencia"];
					$hashkey1 = $ClsBol->encrypt($numero, $usu);
					$hashkey2 = $ClsBol->encrypt($serie, $usu);
					$salida.= '<td class = "text-center" >';
						$salida.= '<div class="btn-group">';
							$salida.= '<a class="btn btn-info btn-xs" title="Imprimir recibo" target="_blank" href = "../../CONFIG/FACTURAS/REPrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'"><span class="fa fa-print"></span></a> &nbsp; ';
						$salida.= '</div>';
					$salida.= '</td>';
					}	
				}else{ ///controles de generación de facturas
					$usu = $_SESSION["codigo"];
					$hashkey = $ClsBol->encrypt($codigo, $usu);
					$salida.= '<td class = "text-center">';
						$salida.= '<div class="btn-group">';
							$salida.= '<a class="btn btn-info btn-xs" title="Generar Factura" href = "FRMnewfactura.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
							$salida.= '<a class="btn btn-default btn-xs" title="Generar Recibo" href = "FRMnewrecibo.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
						$salida.= '</div>';
					$salida.= '</td>';
				}
				//factura
				if($facturado == 1){
					$numdesc = $row["fac_numero"];
					$serdesc = $row["fac_serie_numero"];
					$facturado = '<label class = "text-info">FACTURA '.$serdesc.'-'.$numdesc.'</label>';
				}else if($facturado == 2){
					$numdesc = $row["rec_numero"];
					$serdesc = $row["rec_serie_numero"];
					$facturado = '<label>RECIBO '.$serdesc.'-'.$numdesc.'</label>';
				}else{
					$facturado = "<em></em>";
				}
				$salida.= '<td class = "text-center" >'.$facturado.'</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//fecha de pago
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$saldo = $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
				$saldoTotal+= $saldo;
				$mons = $row["pag_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($valor, 2, '.',',').'</td>';
				//--
				$salida.= '</tr>';
			}else{
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				$salida.= '<td class = "text-center"></td>';
				//--
				$salida.= '<td class = "text-center" > - </td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" > - Pendiente de pago -</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//--
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
			}
			//--
			$i++;
		}
	}
	if(is_array($result_aislado)){
		foreach($result_aislado as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$facturado = $row["pag_facturado"];
			if($facturado > 0){ /////// Controles de Edicion de facturas
				if($facturado == 1){
				$numero = $row["fac_numero"];
				$serie = $row["fac_serie"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Factura a Editar" href = "FRMeditfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a>';
						$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Factura" onclick="ConfirmAnularFactura('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
					$salida.= '</div>';
				$salida.= '</td>';
				}else if($facturado == 2){
				$numero = $row["rec_numero"];
				$serie = $row["rec_serie"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Recibo a Editar" href = "FRMeditrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a>';
						$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Recibo" onclick="ConfirmAnularRecibo('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
					$salida.= '</div>';
				$salida.= '</td>';
				}	
			}else{ ///controles de generación de facturas
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($codigo, $usu);
				$salida.= '<td class = "text-center">';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-info btn-xs" title="Generar Factura" href = "FRMnewfactura.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
						$salida.= '<a class="btn btn-default btn-xs" title="Generar Recibo" href = "FRMnewrecibo.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
					$salida.= '</div>';
				$salida.= '</td>';
			}
			//factura
			if($facturado == 1){
				$numdesc = $row["fac_numero"];
				$serdesc = $row["fac_serie_numero"];
				$facturado = '<label class = "text-info">FACTURA '.$serdesc.'-'.$numdesc.'</label>';
			}else if($facturado == 2){
				$numdesc = $row["rec_numero"];
				$serdesc = $row["rec_serie_numero"];
				$facturado = '<label>RECIBO '.$serdesc.'-'.$numdesc.'</label>';
			}else{
				$facturado = "<em></em>";
			}
			$salida.= '<td class = "text-center" >'.$facturado.'</td>';
			//motivo
			$salida.= '<td class = "text-left" ><strong>- Pago de Boleta No Programado -</strong></td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//monto
			$descuento = 0;
			$mons = $row["mon_simbolo"];
			$monto = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//descuento
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//saldo
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//pagado
			$saldoTotal+= $monto;
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
	$i--; //quita la ultima fila para cuadrar cantidades
	$salida.= '</table>';
	//$salida.= '<label> Monto: '.$montoTotal.'</label><br>';
	//$salida.= '<label> Saldo: '.$saldoTotal.'</label><br>';
	
	return $salida;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------

function tabla_estado_pagos($alumno,$periodo,$division,$grupo){
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$orderby = 3;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('',$division,$grupo,$alumno,'',$periodo,'','','',1,$orderby);
	$result_aislado = $ClsBol->get_pago_aislado('',$division,$grupo, $alumno,'',$periodo,'','0','','','','');
	
	$salida = '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<thead>';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "5px">No.</th>';
	$salida.= '<th class = "text-center" width = "60px"></th>';
	$salida.= '<th class = "text-center" width = "50px"></th>';
	$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n</th>';
	$salida.= '<th class = "text-center" width = "40px"># Boleta</th>';
	$salida.= '<th class = "text-center" width = "40px"># Referencia</th>';
	$salida.= '<th class = "text-center" width = "60px">Fecha Limite / Fecha Pago</th>';
	$salida.= '<th class = "text-center" width = "40px">Monto Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Descuento Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Saldo por Pagar</th>';
	$salida.= '<th class = "text-center" width = "40px">Pagado</th>';
	$salida.= '</tr>';
	$salida.= '</thead>';
	$i = 1;
	$referenciaX = '';
	$montoTotal = 0;
	$saldoTotal = 0;
	if(is_array($result)){
		foreach($result as $row){
			////-- Comprobaciones
			$bolcodigo = $row["bol_codigo"];
			if($bolcodigo != $referenciaX){
				//-------------------------------------------------------------------------------------------------------------------------------------------------------
				$salida.= '<tr class="info">';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//--
				$cuenta = $row["bol_cuenta"];
				$banco = $row["bol_banco"];
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button> ';
				$salida.= '</td>';
				//--
				$pagado_desc = ($pagado == 1)?"- pagado -":" pendiente de pago";
				$salida.= '<td class = "text-center">'.$pagado_desc.'</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//Fecha de Pago
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				$montoTotal+= $row["bol_monto"];
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
				$referenciaX = $bolcodigo;
			}else{
				$i--;
			}
			//-------------------------------------------------------------------------------------------------------------------------------------------------------
			$pago = $row["pag_codigo"];
			$facturado = $row["pag_facturado"];
			if($pago != ""){
				$iconos = "";
				$boleta = $row["pag_programado"];
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$alumno = $row["pag_alumno"];
				$monto_total = floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				/// valido
				$validaBoleta = $ClsBol->comprueba_boleta_cobro($boleta);
				$valida_boleta = $validaBoleta["valida"];
				$codigo_boleta = $validaBoleta["bol_codigo"];
				$valida_monto = floatval($validaBoleta["bol_monto"]);
				$valida_pagado = $validaBoleta["bol_pagado"];
				$situacion_boleta = $validaBoleta["bol_situacion"];
				//--
				$valida_alumno = $ClsBol->comprueba_alumno($alumno);
				if($valida_boleta == false && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto != $monto_total)){
					$class = "info";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto == $monto_total)){
					$class = "";
					$iconos = ' <i class="fa fa-check text-success" title ="Datos Correctos"></i> ';
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <i class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></i> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <i class="fa fa-user text-danger" title ="No existe el alumno"></i> ';
					$errores_alumnos++;
				}
				if($valida_boleta == true && ($valida_monto != $monto_total)){
					$iconos.= ' <i class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></i> ';
					$errores_monto++;
				}
				
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				//--
				$codigo = $row["pag_codigo"];
				if($facturado > 0){ /////// Controles de Edicion de facturas 
					if($facturado == 1){
					$numero = $row["fac_numero"];
					$serie = $row["fac_serie"];
					$bolcodigo = $row["bol_codigo"];
					$usu = $_SESSION["codigo"];
					$hashkey1 = $ClsBol->encrypt($numero, $usu);
					$hashkey2 = $ClsBol->encrypt($serie, $usu);
					$hashkey3 = $ClsBol->encrypt($bolcodigo, $usu);
					$salida.= '<td class = "text-centers" >';
						$salida.= '<div class="btn-group">';
							$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Factura a Editar" href = "FRMeditfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" ><span class="fa fa-edit"></span></a>';
							$salida.= '<a class="btn btn-default btn btn-danger btn-xs" title="Anular Factura" onclick="ConfirmAnularFactura('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></a>';
							$salida.= '<a class="btn btn-default btn-xs" title ="imprimir factura" href ="../CPBOLETAFACTURAS/CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank"><span class="fa fa-file-text-o"><i class="fas fa-file-invoice"></i></a>';
						$salida.= '</div>';
							$salida.= '</td>';
					}else if($facturado == 2){
					$referencia = $row["bol_referencia"];
					$numero = $row["rec_numero"];
					$serie = $row["rec_serie"];
					$usu = $_SESSION["codigo"];
					$hashkey1 = $ClsBol->encrypt($numero, $usu);
					$hashkey2 = $ClsBol->encrypt($serie, $usu);
					$hashkey3 = $ClsBol->encrypt($referencia, $usu);
					$salida.= '<td class="btn-group">';
						$salida.= '<div class = btn-group">';
							$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Recibo a Editar" href = "FRMeditrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a>';
							$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Recibo" onclick="ConfirmAnularRecibo('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
							$salida.= '<a class="btn btn-default btn-xs" title ="imprimir recibo" href ="../../CONFIG/FACTURAS/REPrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank"><span class="fa fa-file-text-o"><i class="fas fa-file-invoice"></i></a>';
							$salida.= '</div>';
						$salida.= '</td>';
					}	
				}else{ ///controles de generación de facturas
					$usu = $_SESSION["codigo"];
					$hashkey = $ClsBol->encrypt($codigo, $usu);
					$salida.= '<td class = "text-center">';
						$salida.= '<div class="btn-group">';
							$salida.= '<a class="btn btn-info btn-xs" title="Generar Factura" href = "FRMnewfactura.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
							$salida.= '<a class="btn btn-default btn-xs" title="Generar Recibo" href = "FRMnewrecibo.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
						$salida.= '</div>';
					$salida.= '</td>';
				}
				//factura
				if($facturado == 1){
					$numdesc = $row["fac_numero"];
					$serdesc = $row["fac_serie_numero"];
					$facturado = '<label class = "text-info">FACTURA '.$serdesc.'-'.$numdesc.'</label>';
				}else if($facturado == 2){
					$numdesc = $row["rec_numero"];
					$serdesc = $row["rec_serie_numero"];
					$facturado = '<label>RECIBO '.$serdesc.'-'.$numdesc.'</label>';
				}else{
					$facturado = "<em></em>";
				}
				$salida.= '<td class = "text-center" >'.$facturado.'</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//fecha de pago
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$saldo = $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
				$saldoTotal+= $saldo;
				$mons = $row["pag_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($valor, 2, '.',',').'</td>';
				//--
				$salida.= '</tr>';
			}else{
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				$salida.= '<td class = "text-center"></td>';
				//--
				$salida.= '<td class = "text-center" > - </td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" > - Pendiente de pago -</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//--
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
			}
			//--
			$i++;
		}
	}
	if(is_array($result_aislado)){
		foreach($result_aislado as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$facturado = $row["pag_facturado"];
			if($facturado > 0){ /////// Controles de Edicion de facturas
				if($facturado == 1){
				$numero = $row["fac_numero"];
				$serie = $row["fac_serie"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Factura a Editar" href = "FRMeditfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a>';
						$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Factura" onclick="ConfirmAnularFactura('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
					$salida.= '</div>';
				$salida.= '</td>';
				}else if($facturado == 2){
				$numero = $row["rec_numero"];
				$serie = $row["rec_serie"];
				$usu = $_SESSION["codigo"];
				$hashkey1 = $ClsBol->encrypt($numero, $usu);
				$hashkey2 = $ClsBol->encrypt($serie, $usu);
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-default btn-xs" title="Seleccionar Recibo a Editar" href = "FRMeditrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" ><span class="fa fa-edit"></span></a>';
						$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Recibo" onclick="ConfirmAnularRecibo('.$serie.','.$numero.','.$codigo.');"><span class="fa fa-trash-o"></span></button>';
					$salida.= '</div>';
				$salida.= '</td>';
				}	
			}else{ ///controles de generación de facturas
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($codigo, $usu);
				$salida.= '<td class = "text-center">';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-info btn-xs" title="Generar Factura" href = "FRMnewfactura.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
						$salida.= '<a class="btn btn-default btn-xs" title="Generar Recibo" href = "FRMnewrecibo.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-file-text-o"></i></a>';
					$salida.= '</div>';
				$salida.= '</td>';
			}
			//factura
			if($facturado == 1){
				$numdesc = $row["fac_numero"];
				$serdesc = $row["fac_serie_numero"];
				$facturado = '<label class = "text-info">FACTURA '.$serdesc.'-'.$numdesc.'</label>';
			}else if($facturado == 2){
				$numdesc = $row["rec_numero"];
				$serdesc = $row["rec_serie_numero"];
				$facturado = '<label>RECIBO '.$serdesc.'-'.$numdesc.'</label>';
			}else{
				$facturado = "<em></em>";
			}
			$salida.= '<td class = "text-center" >'.$facturado.'</td>';
			//motivo
			$salida.= '<td class = "text-left" ><strong>- Pago de Boleta No Programado -</strong></td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//monto
			$descuento = 0;
			$mons = $row["mon_simbolo"];
			$monto = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//descuento
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//saldo
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//pagado
			$saldoTotal+= $monto;
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
	$i--; //quita la ultima fila para cuadrar cantidades
	$salida.= '</table>';
	//$salida.= '<label> Monto: '.$montoTotal.'</label><br>';
	//$salida.= '<label> Saldo: '.$saldoTotal.'</label><br>';
	
	return $salida;
}



function tabla_lectora_csv($archivo){
	$ClsAlu = new ClsAlumno();
	$ClsBol = new ClsBoletaCobro();
	if (($gestor = fopen("../../CONFIG/FACE/$archivo", "r")) !== FALSE) {
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px">Centro de Venta</th>';
		$salida.= '<th class = "text-center" width = "100px">Fecha</th>';
		$salida.= '<th class = "text-center" width = "40px">Tipo Documento</th>';
		$salida.= '<th class = "text-center" width = "40px">Operacion</th>';
		$salida.= '<th class = "text-center" width = "60px">Serie</th>';
		$salida.= '<th class = "text-center" width = "60px">N&uacute;mero</th>';
		$salida.= '<th class = "text-center" width = "50px">NIT</th>';
		$salida.= '<th class = "text-center" width = "40px">Bienes</th>';
		$salida.= '<th class = "text-center" width = "40px">Servicios</th>';
		$salida.= '<th class = "text-center" width = "40px">IVA</th>';
		$salida.= '<th class = "text-center" width = "40px">Total</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
			$numero = count($datos);
			if($numero > 0){
				if(trim($datos[2]) == "FACE"){ /////// Valida que solo traiga filas con facturas
					//centro
					$centro = $datos[0];
					$salida.= '<td class = "text-center" >'.$centro;
					$salida.= '<input type = "hidden" id = "centro'.$i.'" name = "centro'.$i.'" value = "'.$centro.'" />'; 
					$salida.= '</td>';
					//fecha
					$fecha = $datos[1];
					$salida.= '<td class = "text-center" >'.$fecha;
					$salida.= '<input type = "hidden" id = "fecha'.$i.'" name = "fecha'.$i.'" value = "'.$fecha.'" />'; 
					$salida.= '</td>';
					//tipo
					$tipo = $datos[2];
					$salida.= '<td class = "text-center" >'.$tipo;
					$salida.= '<input type = "hidden" id = "tipo'.$i.'" name = "tipo'.$i.'" value = "'.$tipo.'" />'; 
					$salida.= '</td>';
					//operacion
					$operacion = $datos[3];
					$salida.= '<td class = "text-center" >'.$operacion;
					$salida.= '<input type = "hidden" id = "operacion'.$i.'" name = "operacion'.$i.'" value = "'.$operacion.'" />'; 
					$salida.= '</td>';
					//serie
					$serie = $datos[4];
					$salida.= '<td class = "text-center" >'.$serie;
					$salida.= '<input type = "hidden" id = "serie'.$i.'" name = "serie'.$i.'" value = "'.$serie.'" />'; 
					$salida.= '</td>';
					//facutra
					$numero = $datos[5];
					$salida.= '<td class = "text-center" >'.$numero;
					$salida.= '<input type = "hidden" id = "numero'.$i.'" name = "numero'.$i.'" value = "'.$numero.'" />'; 
					$salida.= '</td>';
					//NIT
					$nit = $datos[6];
					$salida.= '<td class = "text-center" >'.$nit;
					$salida.= '<input type = "hidden" id = "nit'.$i.'" name = "nit'.$i.'" value = "'.$nit.'" />'; 
					$salida.= '</td>';
					//Bien
					$bien = $datos[8];
					$bien = validaEntrada($bien);
					$bien = floatval($bien);
					$salida.= '<td class = "text-center" >'.$bien;
					$salida.= '<input type = "hidden" id = "bienes'.$i.'" name = "bienes'.$i.'" value = "'.$bien.'" />'; 
					$salida.= '</td>';
					//Servicio
					$servicio = $datos[9];
					$servicio = validaEntrada($servicio);
					$servicio = floatval($servicio);
					$salida.= '<td class = "text-center" >'.$servicio;
					$salida.= '<input type = "hidden" id = "servicios'.$i.'" name = "servicios'.$i.'" value = "'.$servicio.'" />'; 
					$salida.= '</td>';
					//IVA
					$iva = floatval($datos[15]);
					$iva = number_format($iva,2,'.','');
					$salida.= '<td class = "text-center" >'.$iva;
					$salida.= '<input type = "hidden" id = "iva'.$i.'" name = "iva'.$i.'" value = "'.$iva.'" />'; 
					$salida.= '</td>';
					//TOTAL
					$total = floatval($datos[16]);
					$total = number_format($total,2,'.','');
					$salida.= '<td class = "text-center" >'.$total;
					$salida.= '<input type = "hidden" id = "total'.$i.'" name = "total'.$i.'" value = "'.$total.'" />'; 
					$salida.= '</td>';
					//--
					$salida.= '</tr>';
					//--
					$i++;
				}
			}
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '<input type = "hidden" id = "filas" name = "filas" value = "'.$i.'" />';
		$salida.= '</div>';
		//-- /terminan notificaciones
		$salida.= '</div>';

	}else{
		$salida.= '<h5 class="alert alert-danger text-center"> <i class = "fa fa-exclamation-circle"></i> Error de lectura del archivo .CSV</h5>';
		$salida.= '<input type = "hidden" id = "errorgarrafal" name = "errorgarrafal" value = "1000" />';
	}
	fclose($gestor);
	
	return $salida;
}

function validaEntrada($dato){
	$dato = str_replace(" ","",$dato);
	$dato = str_replace("-","",$dato);
	return $dato;
}

?>