<?php 
include_once('../../html_fns.php');


function tabla_boleta_cobro($pensum,$nivel,$grado,$seccion,$cuenta,$banco){
	$ClsTemp = new ClsTempBoletaCobro();
	$result = $ClsTemp->get_boleta_cobro_temporal_alumno($pensum,$nivel,$grado,$seccion,$cuenta,$banco,'1');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">COD.BOLETA</th>';
			$salida.= '<th class = "text-center" width = "10px">COD.CUENTA</th>';
			$salida.= '<th class = "text-center" width = "10px">COD.BANCO</th>';
			$salida.= '<th class = "text-center" width = "50px">CUI</th>';
			$salida.= '<th class = "text-center" width = "50px">COD.ALUMNO</th>';
			$salida.= '<th class = "text-center" width = "30px">No.BOLETA</th>';
			$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "60px">MOTIVO</th>';
			$salida.= '<th class = "text-center" width = "60px">FECHA.REG.</th>';
			$salida.= '<th class = "text-center" width = "60px">FECHA.PAGO</th>';
			$salida.= '<th class = "text-center" width = "10px">USUARIO</th>';
			$salida.= '<th class = "text-center" width = "10px">SITUACION</th>';
			$salida.= '<th class = "text-center" width = "100px">ALUMNO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		$temp_cod = 0;
		$cantidad = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["bol_codigo"];
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//cuenta
			$cuenta = $row["bol_cuenta"];
			$salida.= '<td class = "text-center">'.$cuenta.'</td>';
			//banco
			$banco = $row["bol_banco"];
			$salida.= '<td class = "text-center" >'.$banco.'</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//alumno
			$alumno = $row["pag_codigo_interno"];
			$salida.= '<td class = "text-center">'.$alumno.'</td>';
			//boleta
			$doc = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//monto
			$monto = $row["bol_monto"];
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//motivo
			$mot = $row["bol_motivo"];
			$salida.= '<td class = "text-center">'.$mot.'</td>';
			//fecha registro
			$freg = date("Y-m-d H:i:s");
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//fecha pago
			$fpag = $row["bol_fecha_pago"];
			$salida.= '<td class = "text-center">'.$fpag.'</td>';
			//usuario
			$usu = $_SESSION["codigo"];
			$salida.= '<td class = "text-center">'.$usu.'</td>';
			//situacion
			$salida.= '<td class = "text-center">1</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $nombre." ".$apellido;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_boleta_pagada(){
	$ClsTemp = new ClsTempBoletaCobro();
	$ClsBol = new ClsBoletaCobro();
	$max = $ClsBol->max_pago_boleta_cobro();
	$max++;
	
	$result = $ClsTemp->get_boleta_pagada_temporal_alumno($ncuenta);
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">###</th>';
			$salida.= '<th class = "text-center" width = "50px">CUI</th>';
			$salida.= '<th class = "text-center" width = "50px">COD.ALUMNO</th>';
			$salida.= '<th class = "text-center" width = "30px">No.BOLETA</th>';
			$salida.= '<th class = "text-center" width = "10px">COD.CUENTA</th>';
			$salida.= '<th class = "text-center" width = "10px">COD.BANCO</th>';
			$salida.= '<th class = "text-center" width = "10px">No.CARGA</th>';
			$salida.= '<th class = "text-center" width = "10px"># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "30px">EFECTIVO</th>';
			$salida.= '<th class = "text-center" width = "60px">CHEQUES.PRO.</th>';
			$salida.= '<th class = "text-center" width = "60px">CHEQUES.OB.</th>';
			$salida.= '<th class = "text-center" width = "60px">ONLINE</th>';
			$salida.= '<th class = "text-center" width = "30px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "10px">USUARIO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		$temp_cod = $max;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center">'.$temp_cod.'</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//alumno
			$alumno = $row["alu_codigo_interno"];
			$alumno = ($alumno != "")?$alumno:'<label class ="text-danger">'.$row["pag_alumno"].'</label>';
			$salida.= '<td class = "text-center">'.$alumno.'</td>';
			//boleta
			$doc = $row["pag_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//cuenta
			$cuenta = $row["pag_cuenta"];
			$salida.= '<td class = "text-center">'.$cuenta.'</td>';
			//banco
			$banco = $row["pag_banco"];
			$salida.= '<td class = "text-center" >'.$banco.'</td>';
			//No. de Carga 
			$carga = $row["pag_carga"];
			$salida.= '<td class = "text-center">'.$carga.'</td>';
			//No. de Transaccion
			$trans = $row["pag_transaccion"];
			$salida.= '<td class = "text-center">'.$trans.'</td>';
			//efectivo
			$monto = $row["pag_efectivo"];
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//cheques propios
			$monto = $row["pag_cheques_propios"];
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//cheques otros bancos
			$monto = $row["pag_otros_bancos"];
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//online
			$monto = $row["pag_online"];
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//fecha Hora
			$freg = $row["pag_fechor"];
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//usuario
			$usu = $_SESSION["codigo"];
			$salida.= '<td class = "text-center">'.$usu.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
			$temp_cod++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
