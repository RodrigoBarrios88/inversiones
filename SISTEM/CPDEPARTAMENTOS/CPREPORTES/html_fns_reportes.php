<?php 
include_once('../../html_fns.php');

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////

function tabla_rep_departamentos($cod,$suc,$dct,$dlg,$sit){
	$ClsDep = new ClsDepartamento();
	$cont = $ClsDep->count_departamento($cod,$suc,$dct,$dlg,$sit);
	
	if($cont>0){
		$result = $ClsDep->get_departamento($cod,$suc,$dct,$dlg,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px">No.</th>';
			$salida.= '<th align = "center" width = "70px">CODIGO</th>';
			$salida.= '<th align = "center" width = "200px">NOMBRE DE LA EMPRESA</th>';
			$salida.= '<th align = "center" width = "120px">NOMBRE ABREVIADOP</th>';
			$salida.= '<th align = "center" width = "200px">NOMBRE COMPLETO</th>';
			$salida.= '<th align = "center" width = "80px">SITUACIÓN</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<th align = "center">'.$i.'.</th>';
			//codigo
			$cod = $row["dep_id"];
			$salida.= '<td align = "center">'.Agrega_Ceros($cod).'</td>';
			//nombre
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$suc.'</td>';
			//desc ct
			$dct = $row["dep_desc_ct"];
			$salida.= '<td align = "center">'.$dct.'</td>';
			//dec larga
			$dlg = $row["dep_desc_lg"];
			$salida.= '<td align = "center">'.$dlg.'</td>';
			//situacion
			$sit = $row["dep_situacion"];
			$sit = ($sit == 1)?"ACTIVO":"INACTIVO";
			$salida.= '<td align = "center">'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "6"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
