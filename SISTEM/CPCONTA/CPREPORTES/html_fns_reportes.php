<?php 
include_once('../../html_fns.php');

function rep_tabla_partidas($cod,$tipo,$clase,$desc,$sit){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_partida($cod,$tipo,$clase,$desc,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "35px"></th>';
			$salida.= '<th width = "120px">NOMENCLATURA</th>';
			$salida.= '<th width = "300px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th width = "70px">TIPO</th>';
			$salida.= '<th width = "70px">CLASE</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td align = "center">'.$i.'</td>';
			//codigo
			$cod = $row["par_codigo"];
			$cod = Agrega_Ceros($cod);
			$salida.= '<td align = "center">'.$cod.'</td>';
			//Direccion
			$desc = $row["par_descripcion"];
			$salida.= '<td align = "left">'.$desc.'</td>';
			//telefono 1
			$tipo = $row["par_tipo"];
			switch ($tipo){
				case "I": $tipo = "INGRESOS"; break;
				case "E": $tipo = "EGRESOS"; break;
			}
			$salida.= '<td align = "center">'.$tipo.'</td>';
			//email
			$clase = $row["par_clase"];
			switch ($clase){
				case "V": $clase = "VENTAS"; break;
				case "I": $clase = "INVERSIONES"; break;
				case "O": $clase = "OTROS"; break;
				case "C": $clase = "COMPRAS"; break;
				case "G": $clase = "GASTOS"; break;
			}
			$salida.= '<td align = "center">'.$clase.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "center" colspan = "5"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function rep_tabla_reglones($cod,$part,$dct,$dlg,$sit){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_reglon($cod,$part,'',$dct,$dlg,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "35px"></th>';
			$salida.= '<th width = "120px">NOMENCLATURA</th>';
			$salida.= '<th width = "300px">DESCRIPCI&Oacute;N LARGA</th>';
			$salida.= '<th width = "200px">DESCRIPCI&Oacute;N CORTA</th>';
			$salida.= '<th width = "70px">TIPO</th>';
			$salida.= '<th width = "70px">CLASE</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td align = "center">'.$i.'</td>';
			//codigo
			$cod = $row["par_codigo"];
			$cod = Agrega_Ceros($cod);
			$par = $row["par_codigo"];
			$par = Agrega_Ceros($par);
			$salida.= '<td align = "center">'.$par.'.'.$cod.'</td>';
			//desc. larga
			$desclg = $row["reg_desc_lg"];
			$salida.= '<td align = "left">'.$desclg.'</td>';
			//desc. corta
			$descct = $row["reg_desc_ct"];
			$salida.= '<td align = "left">'.$descct.'</td>';
			//tipo
			$tipo = $row["par_tipo"];
			switch ($tipo){
				case "I": $tipo = "INGRESOS"; break;
				case "E": $tipo = "EGRESOS"; break;
			}
			$salida.= '<td align = "center">'.$tipo.'</td>';
			//email
			$clase = $row["par_clase"];
			switch ($clase){
				case "V": $clase = "VENTAS"; break;
				case "I": $clase = "INVERSIONES"; break;
				case "O": $clase = "OTROS"; break;
				case "C": $clase = "COMPRAS"; break;
				case "G": $clase = "GASTOS"; break;
			}
			$salida.= '<td align = "center">'.$clase.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "center" colspan = "6"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_articulos($cod,$banp,$nom,$desc,$marca,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////


//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
