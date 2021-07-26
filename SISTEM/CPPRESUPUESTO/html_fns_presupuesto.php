<?php 
include_once('../html_fns.php');

function tabla_reglones($reglon,$partida,$tipo,$clase,$empresa,$anio,$mes){
	$ClsPre = new ClsPresupuesto();
	$result = $ClsPre->get_reglon($reglon,$partida,$tipo,$clase,$empresa,$anio,$mes);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "120px">NOMENCLATURA</th>';
			$salida.= '<th class = "text-center" width = "270px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "70px">CLASE</th>';
			$salida.= '<th class = "text-center" width = "70px">BAJO</th>';
			$salida.= '<th class = "text-center" width = "70px">ALTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["reg_situacion"];
			$partida = $row["par_codigo"];
			$reglon = $row["reg_codigo"];
			//nombre
			$partida = Agrega_Ceros($partida);
			$reglon = Agrega_Ceros($reglon);
			$salida.= '<td class = "text-center">'.$partida.'.'.$reglon;
			$partida = $row["par_codigo"];
			$reglon = $row["reg_codigo"];
			$salida.= '<input type = "hidden" id = "partida'.$i.'"" name = "partida'.$i.'" value = "'.$partida.'" />';
			$salida.= '<input type = "hidden" id = "reglon'.$i.'"" name = "reglon'.$i.'" value = "'.$reglon.'" />';
			$salida.= '</td>';
			//Direccion
			$desc = $row["reg_desc_lg"];
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//telefono 1
			$tipo = $row["par_tipo"];
			switch ($tipo){
				case "I": $tipo = "INGRESOS"; break;
				case "E": $tipo = "EGRESOS"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			$tipo = $row["par_tipo"];
			//email
			$clase = $row["par_clase"];
			switch ($clase){
				case "V": $clase = "VENTAS"; break;
				case "I": $clase = "INVERSIONES"; break;
				case "O": $clase = "OTROS"; break;
				case "C": $clase = "COMPRAS"; break;
				case "G": $clase = "GASTOS"; break;
			}
			$salida.= '<td class = "text-center">'.$clase.'</td>';
			$clase = $row["par_clase"];
			//alto
			///--comprueba si el alumno ya tiene seccion, si no da la opcion para grabar.  Si ya tiene seccion da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsPre->get_presupuesto($cod,$reglon,$partida,$tipo,$clase,$empresa,$anio,$mes);  ////// este array se coloca en la columna de combos
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$codigo = $row_nota_alumno["pre_codigo"];
					$alto = $row_nota_alumno["pre_alto"];
					$bajo = $row_nota_alumno["pre_bajo"];
				}
				//bajo
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "bajo'.$i.'" id = "bajo'.$i.'" value = "'.$bajo.'" onkeyup="decimales(this);" onblur = "Asignar_Monto('.$i.');" />';
				$salida.= '<input type = "hidden" id = "codigo'.$i.'"" name = "codigo'.$i.'" value = "'.$codigo.'" />';
				$salida.= '</td>';
				//alto
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "alto'.$i.'" id = "alto'.$i.'" value = "'.$alto.'" onkeyup="decimales(this);" onblur = "Asignar_Monto('.$i.');" />';
				//$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Este Alumno ya Tiene Nota" ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '</td>';
			}else{
				//bajo
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "bajo'.$i.'" id = "bajo'.$i.'" onkeyup="decimales(this);" onblur = "Asignar_Monto('.$i.');" />';
				$salida.= '<input type = "hidden" id = "codigo'.$i.'"" name = "codigo'.$i.'" />';
				$salida.= '</td>';
				//alto
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "alto'.$i.'" id = "alto'.$i.'" onkeyup="decimales(this);" onblur = "Asignar_Monto('.$i.');" />';
				//$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Este Alumno ya Tiene Nota" ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '</td>';
			}
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





function tabla_clase_ingresos(){
	$ClsSer = new ClsServicio();
	$ClsArt = new ClsArticulo();
		$salida = '<br>';
		$salida.= '<table class = "tabledash" style = "margin:5px">';
		$salida.= '<tr>';
			$salida.= '<th rowspan = "2" width = "35px" height = "40px">No.</th>';
			$salida.= '<th rowspan = "2" width = "60px">CLASE</th>';
			$salida.= '<th rowspan = "2" width = "250px">PARTIDA</th>';
			$salida.= '<th rowspan = "2" width = "270px">REGL&Oacute;N</th>';
			$salida.= '<th width = "70px" colspan = "2">ESCENARIO</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "70px" >MEJOR</th>';
			$salida.= '<th width = "70px" >PEOR</th>';
		$salida.= '</tr>';
	$i = 1;	
	///////// SERVICIOS ////////////	
	$result = $ClsSer->get_grupo("","",1);
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$rcod = $row["gru_codigo"];
			$rdesc = $row["gru_nombre"];
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Clase
			$salida.= '<td>VENTA';
			$salida.= '<input type = "hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "V" >';
			$salida.= '</td>';
			//Partida
			$salida.= '<td>SERVICIOS';
			$salida.= '<input type = "hidden" name = "part'.$i.'" id = "part'.$i.'" value = "1" >';
			$salida.= '</td>';
			//Reglon
			$salida.= '<td>'.$rdesc;
			$salida.= '<input type = "hidden" name = "reg'.$i.'" id = "reg'.$i.'" value = "'.$rcod.'" >';
			$salida.= '</td>';
			//Monto 1
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoA'.$i.'" id = "montoA'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria( \'A\');" >';
			$salida.= '</td>';
			//Monto 2
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoB'.$i.'" id = "montoB'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria(\'B\');" >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
	}
	////////// ARTICULOS ///////////////
	$result = $ClsArt->get_grupo("","",1);
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$rcod = $row["gru_codigo"];
			$rdesc = $row["gru_nombre"];
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Clase
			$salida.= '<td>VENTA';
			$salida.= '<input type = "hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "V" >';
			$salida.= '</td>';
			//Partida
			$salida.= '<td>PRODUCTOS';
			$salida.= '<input type = "hidden" name = "part'.$i.'" id = "part'.$i.'" value = "2" >';
			$salida.= '</td>';
			//Reglon
			$salida.= '<td>'.$rdesc;
			$salida.= '<input type = "hidden" name = "reg'.$i.'" id = "reg'.$i.'" value = "'.$rcod.'" >';
			$salida.= '</td>';
			//Monto 1
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoA'.$i.'" id = "montoA'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria( \'A\');" >';
			$salida.= '</td>';
			//Monto 2
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoB'.$i.'" id = "montoB'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria(\'B\');" >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
	}
		///////////------
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Clase
			$salida.= '<td>VENTA';
			$salida.= '<input type = "hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "V" >';
			$salida.= '</td>';
			//Partida
			$salida.= '<td>OTROS';
			$salida.= '<input type = "hidden" name = "part'.$i.'" id = "part'.$i.'" value = "3" >';
			$salida.= '</td>';
			//Reglon
			$salida.= '<td>OTROS INGRESOS';
			$salida.= '<input type = "hidden" name = "reg'.$i.'" id = "reg'.$i.'" value = "1" >';
			$salida.= '</td>';
			//Monto 1
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoA'.$i.'" id = "montoA'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria( \'A\');" >';
			$salida.= '</td>';
			//Monto 2
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoB'.$i.'" id = "montoB'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria(\'B\');" >';
			$salida.= '</td>';
			$salida.= '</tr>';
		/////////////-----
			$salida.= '<tr>';
			$salida.= '<td colspan = "4" align = "right"> <strong>TOTAL &nbsp;&nbsp;&nbsp;&nbsp;</strong></td>';
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "TotalA" id = "TotalA" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. Total" readonly >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "TotalB" id = "TotalB" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. Total" readonly >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "6"> '.$i.' Registro(s).</td>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" >';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_clase_egresos(){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_reglon("","","","",1);
	
	if(is_array($result)){
			$salida = '<br>';
			$salida.= '<table class = "tabledash" style = "margin:5px">';
			$salida.= '<tr>';
			$salida.= '<th rowspan = "2" width = "35px" height = "40px">No.</th>';
			$salida.= '<th rowspan = "2" width = "60px">CLASE</th>';
			$salida.= '<th rowspan = "2" width = "250px">PARTIDA</th>';
			$salida.= '<th rowspan = "2" width = "270px">REGL&Oacute;N</th>';
			$salida.= '<th width = "70px" colspan = "2">ESCENARIO</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "70px" >MEJOR</th>';
			$salida.= '<th width = "70px" >PEOR</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$clase = $row["par_clase"];
			$pcod = $row["par_codigo"];
			$pdesc = $row["par_descripcion"];
			$rcod = $row["reg_codigo"];
			$rdesc = $row["reg_desc_lg"];
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Clase
			$dclase = ($clase == "C")?"COMPRA":"GASTO";
			$salida.= '<td>'.$dclase;
			$salida.= '<input type = "hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "'.$clase.'" >';
			$salida.= '</td>';
			//Partida
			$salida.= '<td>'.$pdesc;
			$salida.= '<input type = "hidden" name = "part'.$i.'" id = "part'.$i.'" value = "'.$pcod.'" >';
			$salida.= '</td>';
			//Reglon
			$salida.= '<td>'.$rdesc;
			$salida.= '<input type = "hidden" name = "reg'.$i.'" id = "reg'.$i.'" value = "'.$rcod.'" >';
			$salida.= '</td>';
			//Monto 1
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoA'.$i.'" id = "montoA'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria( \'A\');" >';
			$salida.= '</td>';
			//Monto 2
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoB'.$i.'" id = "montoB'.$i.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria(\'B\');" >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<td colspan = "4" align = "right"> <strong>TOTAL &nbsp;&nbsp;&nbsp;&nbsp;</strong></td>';
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "TotalA" id = "TotalA" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. Total" readonly >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "TotalB" id = "TotalB" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. Total" readonly >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "6"> '.$i.' Registro(s).</td>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" >';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}



function tabla_caja_movimiento($cod,$suc,$mon,$fini,$ffin){
	$ClsCaj = new ClsCaja();
	$cont = $ClsCaj->count_caja($cod,$suc,$mon,1);
	
	if($cont>0){
		$result = $ClsCaj->get_caja($cod,$suc,$mon,1);
			$salida = '<br>';
			$salida.= '<form name = "f2" id = "f2" onsubmit = "return false">';
			$salida.= '<table class = "tabledash">';
			$salida.= '<tr>';
			$salida.= '<th width = "40px" height = "30px" ><img src = "../../CONFIG/images/icons/gear.png" class="icon" ></th>';
			$salida.= '<th width = "90px"># CAJA</th>';
			$salida.= '<th width = "220px">DESCRIPCIÓN</th>';
			$salida.= '<th width = "130px">EMPRESA</th>';
			$salida.= '<th width = "70px">SALDO</th>';
			$salida.= '<th width = "90px">MONEDA</th>';
			$salida.= '</tr>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$suc = $row["caja_sucursal"];
			$caja = $row["caja_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="button" href="javascript:void(0)" onclick = "xajax_Seleccionar_Caja('.$caja.','.$suc.',\''.$fini.'\',\''.$ffin.'\')" title = "Seleccionar Caja" ><img src = "../../CONFIG/images/icons/check.png" class="icon" ></a>';
			$salida.= '</td>';
			//numero de cuenta
			$num = Agrega_Ceros($caja)."-".Agrega_Ceros($suc);
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//descripcion
			$desc = $row["caja_descripcion"];
			$salida.= '<td  class = "text-justify" >'.$desc.'</td>';
			//empresa
			$sucn = $row["suc_nombre"];
			$salida.= '<td>'.$sucn.'</td>';
			//saldo
			$mons = $row["mon_simbolo"];
			$saldo = $row["caja_saldo"];
			$salida.= '<td class = "text-center">'.$mons.'. '.$saldo.'</td>';
			//moneda
			$mon = $row["mon_desc"];
			$salida.= '<td class = "text-center">'.$mon.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "6"> '.$i.' Registro(s).</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	}
	
	return $salida;
}



function tabla_movimientos($caja,$suc,$fini,$ffin){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_mov_caja("",$caja,$suc,'','','','',$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			$salida.= '<td width = "30px" class = "text-center" >No.</td>';
			$salida.= '<td width = "80px" class = "text-center" ># TRANS.</td>';
			$salida.= '<td width = "120px" class = "text-center" >FECHA/HORA</td>';
			$salida.= '<td width = "60px" class = "text-center" >MOV.</td>';
			$salida.= '<td width = "120px" class = "text-center" >MOTIVO</td>';
			$salida.= '<td width = "200px" class = "text-center" >JUSTIFICACIÓN</td>';
			$salida.= '<td width = "100px" class = "text-center" >DOCUMENTO</td>';
			$salida.= '<td width = "50px" class = "text-center" ><b>ENTRÓ</b></td>';
			$salida.= '<td  width = "50px" class = "text-center" ><b>SALIÓ</b></td>';
			$salida.= '<td  width = "50px" class = "text-center" ><b>SALDO</b></td>';
			$salida.= '</tr>';
		$i = 1;	
		$saldo = $ClsCaj->get_saldo_anterior($caja,$suc,$fini);	
		$Tentra = 0;
		$Tsale = 0;
		foreach($result as $row){
			if ($i == 1){ //--
			$mons = trim($row["mon_simbolo"]);	
			$salida.= '<tr>';
			$salida.= '<td colspan = "7" class = "text-center"> <b>SALDO DE OPERACIONES ANTERIORES</b></td>';
			$salida.= '<td ></td>';
			$salida.= '<td ></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$saldo.'</b>';
			$salida.= '</tr>';
			} //--
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mcj_codigo"]);
			$caj = Agrega_Ceros($row["mcj_caja"]);
			$suc = Agrega_Ceros($row["mcj_sucursal"]);
			$codigo = $cod."-".$caj."-".$suc;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mcj_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mcj_movimiento"];
			$mov = ($mov == "I")?"CREDITO":"DEBITO";
			$salida.= '<td class = "text-center">'.$mov.'</td>';
			//Motivo
			$mot = $row["mcj_tipo"];
			switch($mot){
				case "C": $mot = "COMPRA"; break;
				case "RT": $mot = "RETIRO"; break;
				case "TR": $mot = "TRASLADO A CUENTA"; break;
				case "RB": $mot = "REMBOLSO DE FONDOS"; break;
				case "DP": $mot = "DEPOSITO"; break;
			}
			$salida.= '<td class = "text-center">'.$mot.'</td>';
			//justificacion
			$just = $row["mcj_motivo"];
			$salida.= '<td  class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = $row["mcj_doc"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mcj_movimiento"]);
			$cant = $row["mcj_monto"];
			if($mov == "I"){
				$entra = $cant;
				$sale = "";
				$saldo += $entra;
			}else if($mov == "E"){
				$entra = "";
				$sale = $cant;
				$saldo -=  $sale;
			}
			$Tentra+= $entra;
			$Tsale += $sale;
			$salida.= '<td class = "text-center">'.$entra.'</td>';
			$salida.= '<td class = "text-center">'.$sale.'</td>';
			$salida.= '<td class = "text-center">'.$saldo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '<tr>';
			$salida.= '<td colspan = "10" class = "text-center"><br></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td colspan = "7" align = "right"> <b>TOTAL INGRESOS</b></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$Tentra.'</b>';
			$salida.= '<td colspan = "2" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td colspan = "7" align = "right"> <b>TOTAL EGRESOS</b></td>';
			$salida.= '<td ></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$Tsale.'</b>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td colspan = "7" align = "right"> <b>SALDO</b></td>';
			$salida.= '<td colspan = "2" ></td>';
			$salida.= '<td class = "text-center"><b style = "color:green">'.$mons.'. '.$saldo.'</b>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	}
	
	return $salida;
}







/////////////////////////  CALCULADOR DE RESULTADOS ////////////////////////////////

function tabla_resultados_ventas($cod_suc,$mes,$anio,$fini,$ffin,$con_fac,$titulo){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	$ClsMon = new ClsMoneda();
	//-- trae datos de moneda por defecto
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$montcambio = trim($row['mon_cambio']); //Tipo de Cambio del dia para la moneda por defecto
			$monsimbolo = trim($row['mon_simbolo']); //simbolo de la moneda por defecto
			$montexto = trim($row['mon_desc']); //simbolo de la moneda por defecto
		}
	}
	/////////////------------- encabezados del libro -----------------------------
	$salida = '<br>';
	$salida = '<h3>'.$titulo.'</h3>';
	$salida.= '<table class = "tabledash" style = "margin:5px">';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "30px"><b>No.</b></th>';
	$salida.= '<th class = "text-center" width = "115px"><b>Clase</b></th>';
	$salida.= '<th class = "text-center" width = "115px"><b>Partida</b></th>';
	$salida.= '<th class = "text-center" width = "200px"><b>Regl&oacute;n</b></th>';
	$salida.= '<th class = "text-center" width = "125px"><b>Monto</b></th>';
	$salida.= '<th class = "text-center" width = "125px"><b>Moneda</b></th>';
	$salida.= '<th class = "text-center" width = "95px"><b>T/C</b></th>';
	$salida.= '</tr>';
	////////////----------------------------- Servicios ---------------------------------------/////////////
	///------ variables de calculo
		$descripcion = "";
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
	///-----------------------------
	$result = $ClsVent->get_venta_estadisticas('','','S','','',$cod_suc,'','',$mes,$anio,$fini,$ffin,$con_fac,'1,2');
	$i = 1;	
	$j = 1;	
	if(is_array($result)){
		$GrupoX = "";
		foreach($result as $row){
			//--- Pinta Resultados --//
			$grucod = trim($row["dven_grupo"]);
			if($GrupoX != $grucod){
				if($j > 1){
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Partida
				$salida.= '<td class = "text-left">VENTA</td>';
				//Partida
				$salida.= '<td class = "text-left">SERVICIOS</td>';
				//Reglon
				$salida.= '<td class = "text-left">'.$descripcion.'</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
				$Total = 0;
				$Rtotal = 0;
				$IVARtotal = 0;
				$TIVA = 0;
				$Tdesc = 0;
				}
				//--
				$GrupoX = $grucod;
			}
			$j++;
			//descripcion
			$descripcion = $row["ven_grupo_servicios"];
			$descripcion = utf8_decode($descripcion);
			//Cantidad
			$cant = $row["dven_cantidad"];
			//Moneda
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			//Precio Venta.
			$pre = $row["dven_precio"];
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = round($porvar, 2);
			//Descuento
			$dsc = $row["dven_descuento"];
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$stot);
			$Total+= $DcambiarT;
			//$Total = number_format($Total, 2, '.', ',');
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
		}
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Clase
				$salida.= '<td class = "text-left">VENTA</td>';
				//Partida
				$salida.= '<td class = "text-left">SERVICIOS</td>';
				//Reglon
				$salida.= '<td class = "text-left">'.$descripcion.'</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
	}
	
	////////////----------------------------- Productos ---------------------------------------/////////////
	///------ variables de calculo
		$descripcion = "";
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
	///-----------------------------
	$result = $ClsVent->get_venta_estadisticas('','','P','','',$cod_suc,'','',$mes,$anio,$fini,$ffin,$con_fac,'1,2');
	$j = 1;	
	if(is_array($result)){
		$GrupoX = "";
		foreach($result as $row){
			//--- Pinta Resultados --//
			$grucod = trim($row["dven_grupo"]);
			if($GrupoX != $grucod){
				if($j > 1){
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Clase
				$salida.= '<td class = "text-left">VENTA</td>';
				//Partida
				$salida.= '<td class = "text-left">PRODUCTOS</td>';
				//Reglon
				$salida.= '<td class = "text-left">'.$descripcion.'</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
				$Total = 0;
				$Rtotal = 0;
				$IVARtotal = 0;
				$TIVA = 0;
				$Tdesc = 0;
				}
				//--
				$GrupoX = $grucod;
			}
			$j++;
			//descripcion
			$descripcion = $row["ven_grupo_productos"];
			$descripcion = utf8_decode($descripcion);
			//Cantidad
			$cant = $row["dven_cantidad"];
			//Moneda
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			//Precio Venta.
			$pre = $row["dven_precio"];
			//Variacion
			$var = $pre - $prec;
			if($var > 0){
			$porvar = ($var*100)/$pre;
			}else{
			$porvar = 0;
			}
			$porvar = round($porvar, 2);
			//Descuento
			$dsc = $row["dven_descuento"];
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$stot);
			$Total+= $DcambiarT;
			//$Total = number_format($Total, 2, '.', ',');
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
		}
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Clase
				$salida.= '<td class = "text-left">VENTA</td>';
				//Partida
				$salida.= '<td class = "text-left">PRODUCTOS</td>';
				//Reglon
				$salida.= '<td class = "text-left">'.$descripcion.'</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
	}
	
	////////////----------------------------- otros ---------------------------------------/////////////
	///------ variables de calculo
		$descripcion = "";
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
	///-----------------------------
	$result = $ClsVent->get_venta_estadisticas('','','O','','',$cod_suc,'','',$mes,$anio,$fini,$ffin,$con_fac,'1,2');
	$j = 1;	
	if(is_array($result)){
		$GrupoX = "";
		foreach($result as $row){
			//--- Pinta Resultados --//
			//Cantidad
			$cant = $row["dven_cantidad"];
			//Moneda
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			//Precio Venta.
			$pre = $row["dven_precio"];
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = round($porvar, 2);
			//Descuento
			$dsc = $row["dven_descuento"];
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$stot);
			$Total+= $DcambiarT;
			//$Total = number_format($Total, 2, '.', ',');
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
		}
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Clase
				$salida.= '<td class = "text-left">VENTA</td>';
				//Partida
				$salida.= '<td class = "text-left">OTROS</td>';
				//Reglon
				$salida.= '<td class = "text-left">OTROS INGRESOS</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
	}
			$i--;	
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "7"> '.$i.' Registro(s).</td>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" >';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	
	return $salida;
}




function tabla_resultados_compras($cod_suc,$mes,$anio,$fini,$ffin,$titulo){
	$ClsComp = new ClsCompra();
	$ClsMon = new ClsMoneda();
	//-- trae datos de moneda por defecto
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$montcambio = trim($row['mon_cambio']); //Tipo de Cambio del dia para la moneda por defecto
			$monsimbolo = trim($row['mon_simbolo']); //simbolo de la moneda por defecto
			$montexto = trim($row['mon_desc']); //simbolo de la moneda por defecto
		}
	}
	/////////////------------- encabezados del libro -----------------------------
	$salida = '<br>';
	$salida = '<h3>'.$titulo.'</h3>';
	$salida.= '<table class = "tabledash" style = "margin:5px">';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "30px"><b>No.</b></th>';
	$salida.= '<th class = "text-center" width = "95px"><b>Clase</b></th>';
	$salida.= '<th class = "text-center" width = "300px"><b>Partida</b></th>';
	$salida.= '<th class = "text-center" width = "200px"><b>Regl&oacute;n</b></th>';
	$salida.= '<th class = "text-center" width = "115px"><b>Monto</b></th>';
	$salida.= '<th class = "text-center" width = "105px"><b>Moneda</b></th>';
	$salida.= '<th class = "text-center" width = "85px"><b>T/C</b></th>';
	$salida.= '</tr>';
	////////////----------------------------- COMPRAS ---------------------------------------/////////////
	///------ variables de calculo
		$clase = "";
		$partida = "";
		$reglon = "";
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
	///-----------------------------
	$result = $ClsComp->get_compra_estadisticas('','','',$cod_suc,$mes,$anio,$fini,$ffin,'','','1,2');
	$i = 1;	
	$j = 1;	
	if(is_array($result)){
		$GrupoX = "";
		foreach($result as $row){
			//--- Pinta Resultados --//
			$grucod = trim($row["reg_codigo"]);
			if($GrupoX != $grucod){
				if($j > 1){
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Partida
				$salida.= '<td class = "text-left">'.$clase.'</td>';
				//Partida
				$salida.= '<td class = "text-left">'.$partida.'</td>';
				//Reglon
				$salida.= '<td class = "text-left">'.$reglon.'</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
				$Total = 0;
				$Rtotal = 0;
				$IVARtotal = 0;
				$TIVA = 0;
				$Tdesc = 0;
				}
				//--
				$GrupoX = $grucod;
			}
			$j++;
			//clase
			$clase = $row["par_clase"];
			$clase = ($clase == "C")?"COMPRA":"GASTO";
			//partida
			$partida = $row["par_descripcion"];
			$partida = utf8_decode($partida);
			//reglon
			$reglon = $row["reg_desc_ct"];
			$reglon = utf8_decode($reglon);
			//Cantidad
			$cant = $row["dcom_cantidad"];
			//Moneda
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			//Precio Venta.
			$pre = $row["dcom_precio"];
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = round($porvar, 2);
			//Descuento
			$dsc = $row["dcom_descuento"];
			//sub Total
			$monc = $row["dcom_tcambio"];
			$Vmonc = $row["com_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$stot);
			$Total+= $DcambiarT;
			//$Total = number_format($Total, 2, '.', ',');
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
		}
				$salida.= '<tr>';
				//No.
				$salida.= '<th class = "text-center">'.$i.'.</th>';
				//Partida
				$salida.= '<td class = "text-left">'.$clase.'</td>';
				//Partida
				$salida.= '<td class = "text-left">'.$partida.'</td>';
				//Reglon
				$salida.= '<td class = "text-left">'.$reglon.'</td>';
				//Monto
				$salida.= '<td align = "right">'.$monsimbolo.' '.$Total.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montexto.'</td>';
				//---
				$salida.= '<td class = "text-center">'.$montcambio.' x 1</td>';
				//---
				$salida.= '</tr>';
				$i++;
	}
	
			$i--;	
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "7"> '.$i.' Registro(s).</td>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" >';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_presupuestos_actualiza($suc,$mes,$anno,$clase){
	$ClsPre = new ClsPresupuesto();
	$result = $ClsPre->get_det_presupuesto($suc,$mes,$anno,$clase,'','','','',1);
	
	if(is_array($result)){
			$salida = '<br>';
			$salida.= '<table class = "tabledash" style = "margin:5px">';
			$salida.= '<tr>';
			$salida.= '<th rowspan = "2" width = "35px" height = "40px">No.</th>';
			$salida.= '<th rowspan = "2" width = "60px">CLASE</th>';
			$salida.= '<th rowspan = "2" width = "250px">PARTIDA</th>';
			$salida.= '<th rowspan = "2" width = "270px">REGL&Oacute;N</th>';
			$salida.= '<th width = "70px" colspan = "2">ESCENARIO</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "70px" >MEJOR</th>';
			$salida.= '<th width = "70px" >PEOR</th>';
			$salida.= '</tr>';
		$i = 1;
		$MontoT1 = 0;
		$montoT2 = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$clase = $row["dpre_clase"];
			$cod = $row["dpre_codigo"];
			$pcod = $row["dpre_partida"];
			$rcod = $row["dpre_reglon"];
			$monto1 = $row["dpre_monto1"];
			$monto2 = $row["dpre_monto2"];
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Clase
			if($clase == "I"){
				$tipo = $row["dpre_tipo"];
				if($tipo == "S"){
					$dclase = "VENTAS";
					$pdesc = "SERVICIOS";
					$rdesc = $row["pre_reglon_servicios"];
				}else if($tipo == "P"){
					$dclase = "VENTAS";
					$pdesc = "PRODUCTOS";
					$rdesc = $row["pre_reglon_productos"];
				}else if($tipo == "O"){
					$dclase = "VENTAS";
					$pdesc = "OTROS";
					$rdesc = "OTROS";
				}
			}else if($clase == "E"){
				$tipo = $row["dpre_tipo"];
				if($tipo == "C"){
					$dclase = "COMPRA";
					$pdesc = $row["pre_partida_egresos"];
					$rdesc = $row["pre_reglon_egresos"];
				}else if($tipo == "G"){
					$dclase = "GASTO";
					$pdesc = $row["pre_partida_egresos"];
					$rdesc = $row["pre_reglon_egresos"];
				}	
			}
			$salida.= '<td>'.$dclase;
			$salida.= '<input type = "hidden" name = "cod'.$i.'" id = "cod'.$i.'" value = "'.$cod.'" >';
			$salida.= '<input type = "hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "'.$clase.'" >';
			$salida.= '</td>';
			//Partida
			$salida.= '<td>'.$pdesc;
			$salida.= '<input type = "hidden" name = "part'.$i.'" id = "part'.$i.'" value = "'.$pcod.'" >';
			$salida.= '</td>';
			//Reglon
			$salida.= '<td>'.$rdesc;
			$salida.= '<input type = "hidden" name = "reg'.$i.'" id = "reg'.$i.'" value = "'.$rcod.'" >';
			$salida.= '</td>';
			//Monto 1
			$MontoT1+= $monto1;
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoA'.$i.'" id = "montoA'.$i.'" value = "'.$monto1.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria( \'A\');" >';
			$salida.= '</td>';
			//Monto 2
			$MontoT2+= $monto2;
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "montoB'.$i.'" id = "montoB'.$i.'" value = "'.$monto2.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. 0.00" onkeyup = "decimales(this)" onblur = "val_campo(this);valorSumatoria(\'B\');" >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<td colspan = "4" align = "right"> <strong>TOTAL &nbsp;&nbsp;&nbsp;&nbsp;</strong></td>';
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "TotalA" id = "TotalA" value = "'.$MontoT1.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. Total" readonly >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type = "text" name = "TotalB" id = "TotalB" value = "'.$MontoT2.'" style = "border:0;width:90%;padding:3px;text-align:center" placeholder = "Q. Total" readonly >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "6"> '.$i.' Registro(s).</td>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" >';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}


function tabla_presupuestos_visualiza($suc,$mes,$anno,$clase,$sit){
	$ClsPre = new ClsPresupuesto();
	$result = $ClsPre->get_det_presupuesto($suc,$mes,$anno,$clase,'','','','',$sit);
	
	if(is_array($result)){
			$salida = '<br>';
			$salida.= '<table class = "tabledash" style = "margin:5px">';
			$salida.= '<tr>';
			$salida.= '<th rowspan = "2" width = "35px" height = "40px">No.</th>';
			$salida.= '<th rowspan = "2" width = "60px">CLASE</th>';
			$salida.= '<th rowspan = "2" width = "250px">PARTIDA</th>';
			$salida.= '<th rowspan = "2" width = "270px">REGL&Oacute;N</th>';
			$salida.= '<th width = "70px" colspan = "2">ESCENARIO</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "70px" >MEJOR</th>';
			$salida.= '<th width = "70px" >PEOR</th>';
			$salida.= '</tr>';
		$i = 1;
		$MontoT1 = 0;
		$montoT2 = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$clase = $row["dpre_clase"];
			$pcod = $row["dpre_partida"];
			$rcod = $row["dpre_reglon"];
			$monto1 = $row["dpre_monto1"];
			$monto2 = $row["dpre_monto2"];
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Clase
			if($clase == "I"){
				$tipo = $row["dpre_tipo"];
				if($tipo == "S"){
					$dclase = "VENTAS";
					$pdesc = "SERVICIOS";
					$rdesc = $row["pre_reglon_servicios"];
				}else if($tipo == "P"){
					$dclase = "VENTAS";
					$pdesc = "PRODUCTOS";
					$rdesc = $row["pre_reglon_productos"];
				}else if($tipo == "O"){
					$dclase = "VENTAS";
					$pdesc = "OTROS";
					$rdesc = "OTROS";
				}
			}else if($clase == "E"){
				$tipo = $row["dpre_tipo"];
				if($tipo == "C"){
					$dclase = "COMPRA";
					$pdesc = $row["pre_partida_egresos"];
					$rdesc = $row["pre_reglon_egresos"];
				}else if($tipo == "G"){
					$dclase = "GASTO";
					$pdesc = $row["pre_partida_egresos"];
					$rdesc = $row["pre_reglon_egresos"];
				}	
			}
			$salida.= '<td>'.$dclase.'</td>';
			//Partida
			$salida.= '<td>'.$pdesc.'</td>';
			//Reglon
			$salida.= '<td>'.$rdesc.'</td>';
			//Monto 1
			$MontoT1+= $monto1;
			$salida.= '<td class = "text-center">'.$monto1.'</td>';
			//Monto 2
			$MontoT2+= $monto2;
			$salida.= '<td class = "text-center">'.$monto2.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<td colspan = "4" align = "right"> <strong>TOTAL &nbsp;&nbsp;&nbsp;&nbsp;</strong></td>';
			$salida.= '<td class = "text-center"><strong>'.$MontoT1.'</strong></td>';
			$salida.= '<td class = "text-center"><strong>'.$MontoT2.'</strong></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "6"> '.$i.' Registro(s).</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}


//echo tabla_presupuestos_visualiza($suc,$mes,$anno,$clase);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////

//echo tabla_presupuestos($suc,$mes,$anno,$clase);

//$ClsPre = new ClsPresupuesto();
//-- trae datos de moneda por defecto
//$result = $ClsPre->get_det_presupuesto(1,'','','','');

?>
