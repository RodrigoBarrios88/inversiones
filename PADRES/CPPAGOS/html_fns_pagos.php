<?php 
include_once('../html_fns.php');

function tabla_hijos($padre){
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_alumno_padre($padre,"");
	
	if(is_array($result)){
			$salida.= '<div class="panel-body users-list">';
            $salida.= '<div class="row-fluid table">';
			$salida.= '<table class="table table-hover">';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
            //foto
            $cui = trim($row["alu_cui"]);
			$foto = trim($row["alu_foto"]);
			if(file_exists ('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
                $foto = 'ALUMNOS/'.$foto.'.jpg';
            }else{
                $foto = 'nofoto.png';
            }
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAsi->encrypt($cui, $usu);
            //nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
            $nombre = ucwords(strtolower($nom));
            $apellido = ucwords(strtolower($ape));
			//--
			$salida.= '<td>';
			$salida.= '<a href="FRMpagos.php?hashkey='.$hashkey.'">';
            $salida.= '<img src="../../CONFIG/Fotos/'.$foto.'" class="img-circle avatar hidden-phone" width = "50px" />';
			$salida.= '</a>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-left">';
            $salida.= '<a href="FRMpagos.php?hashkey='.$hashkey.'" class="name">'.$nombre.'</a>';
            $salida.= '<span class="subtext">'.$apellido.'</span>';
            $salida.= '</td>';
			//grado(seccion)
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$salida.= '<td class = "text-center">'.$fecnac.' ('.$edad.' a&ntilde;os)</td>';
			//grado(seccion)
			$desc_nomina = $row["alu_desc_nomina"];
			$salida.= '<td class = "text-center">'.$desc_nomina.'</td>';
			//--
			$salida.= '<td>';
            $salida.= '<a class="btn-glow primary" href="FRMpagos.php?hashkey='.$hashkey.'" ><i class="icon icon-arrow-right"></i></a>';
            $salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_estado_cuenta($alumno,$periodo,$division,$grupo){ 
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$orderby = 3;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('',$division,$grupo,$alumno,'',$periodo,'','','',1,$orderby);
	$result_aislado = $ClsBol->get_pago_aislado('',$division,$grupo, $alumno,'',$periodo,'','0','','','','');
	$salida.= '<div class="dataTable_wrapper">';
	$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
	$salida.= '<thead>';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "5px">No.</th>';
	$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
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
				$boleta = trim($row["bol_codigo"]);
				$cuenta = $row["bol_cuenta"];
				$banco = $row["bol_banco"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($bolcodigo, $usu);
				$salida.= '<td class = "text-center">';
					$salida.= '<div class="btn-group">';
						$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fas fa-search"></i></button> ';
						$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta Original (boleta f&iacute;sica)" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
					$salida.= '</div>';
					
				$salida.= '</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = Agrega_Ceros($row["bol_codigo"]);
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
			$fecha = $row["pag_fechor"];
			$yy = substr($fecha,0,4);
			if($pago != ""){
				$iconos = "";
				$boleta = trim($row["pag_programado"]);
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$monto_total = floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				/// valido
				$validaBoleta = $ClsBol->comprueba_boleta_cobro($boleta);
				$valida_boleta = $validaBoleta["valida"];
				$codigo_boleta = $validaBoleta["bol_codigo"];
				$valida_monto = trim($validaBoleta["bol_monto"]);
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
				}else{
					$class = "warning";
				}
				
				//////////////////////////////////////////////////
				$result_factura = $ClsBol ->get_factura('','','',$referencia,'','','','','','','',$pago);
				if(is_array($result_factura)){	
				    foreach($result_factura as $rowfac){
        				$numero= $rowfac["fac_numero"];
        				$serie = $rowfac["fac_serie"];
        				$usu = $_SESSION["codigo"];	
        				$bolcodigo = $row["bol_codigo"];
        				$hashkey1 = $ClsBol->encrypt($numero, $usu);
        				$hashkey2 = $ClsBol->encrypt($serie, $usu);
        				$hashkey3 = $ClsBol->encrypt($bolcodigo,$usu);
        				$iconos.= '<div class="btn-group">';
        					$iconos.= '<a type="button" class="btn btn-info  btn-xs"   title="Facturas"  href = "../../SISTEM/CPBOLETAFACTURAS/CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank"><span class="fa fa-file-text-o"><i class="fas fa-file-invoice"></i></a>';
        				$iconos.= '</div>';
				    }
				} 
            	$result_recibo = $ClsBol ->get_recibo('','','',$referencia,'','','','','','','',$pago);
				if(is_array($result_recibo)){
				    foreach($result_recibo as $rowrecibo){
        				$numero = $rowrecibo["rec_numero"];
        				$serie = $rowrecibo["rec_serie"];
        				$usu = $_SESSION["codigo"];
        				$hashkey1 = $ClsBol->encrypt($numero, $usu);
        				$hashkey2 = $ClsBol->encrypt($serie, $usu);
        				$iconos.='<div class="btn-group">';
        					$iconos.= '<a type="button" class="btn btn-default btn-xs" title="Recibos" href="../../CONFIG/FACTURAS/REPrecibo.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" > <span class="fa fa-file-text-o"><i class="fas fa-file-invoice"></i></a>';
        				$iconos.='</div>';
				    }
				}
				///////////////////////////////////////

				if ($result_recibo == '!E'  && $result_factura == '!E' && $valida_boleta == 1 ){
					$iconos = ' <span class="fa fa-check text-success" title ="Pagos Generados"></span> ';
				}
				

				///////////////////////////////////////
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
					$iconos.= ' <i class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado '.$valida_boleta.', '.$valida_monto.', '.$monto_total.'  "></i> ';
					$errores_monto++;
				}
				
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				//--
				$salida.= '<td class = "text-center" >'.$iconos.'</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = trim($row["pag_programado"]);
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
			$salida.= '<td class = "text-center"></td>';
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
	$salida.= '</div>';
	//$salida.= '<label> Monto: '.$montoTotal.'</label><br>';
	//$salida.= '<label> Saldo: '.$saldoTotal.'</label><br>';
	
	return $salida;
}

function tabla_moras($alumno,$anio){
	$ClsBol = new ClsBoletaCobro();
	
	$result = $ClsBol->get_mora('','','',$alumno,'','','','', $anio, '', '', '', 1, '',0);
	if(is_array($result)){
		$salida = '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<tr>';
		$salida.= '<thead>';
		$salida.= '<th class = "text-center danger" colspan = "4"><strong>MORA</strong></th>';
		$salida.= '</thead>';
		$salida.= '</tr>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px" height = "30px"></th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA/REGISTRO</th>';
		$salida.= '<th class = "text-center" width = "100px">MOTIVO</th>';
		$salida.= '</tr>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$banco = $row["ban_codigo"];
			$cuenta = $row["cueb_codigo"];
			$codigo = $row["bol_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoletaMora(\''.$codigo.'\',\''.$cuenta.'\',\''.$banco.'\');" ><span class="fas fa-search"></span></button> ';
			$salida.= '</td>';
			//Monto
			$monto = $row["bol_monto"];
			$monto = number_format($monto,2,'.',',');
			$salida.= '<td class = "text-center">Q.'.$monto.'</td>';
			//fecha de registro
			$freg = $row["bol_fecha_registro"];
			$freg = cambia_fechaHora($freg);
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-left">'.$motivo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;	
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


?>