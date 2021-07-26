<?php 
include_once('../../html_fns.php');

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////

function tabla_rep_groomistas($cod,$dpi,$nom,$usu,$suc,$sit){
	$ClsGro = new ClsGroomista();
	$cont = $ClsGro->count_groomista($cod,$dpi,$nom,$usu,$suc,'','','',$sit);
	
	if($cont>0){
		$result = $ClsGro->get_groomista($cod,$dpi,$nom,$usu,$suc,'','','',$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px">No.</th>';
			$salida.= '<th align = "center" width = "60px">CODIGO</th>';
			$salida.= '<th align = "center" width = "60px">DPI</td>';
			$salida.= '<th align = "center" width = "200px">NOMBRE</td>';
			$salida.= '<th align = "center" width = "300px">DIRECCIÓN</th>';
			$salida.= '<th align = "center" width = "80px">TELEFONO 1</th>';
			$salida.= '<th align = "center" width = "80px">TELEFONO 2</th>';
			$salida.= '<th align = "center" width = "100px">MAIL</th>';
			$salida.= '<th align = "center" width = "50px">SITUACIÓN</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<th align = "center">'.$i.'.</th>';
			//codigo
			$cod = $row["gro_codigo"];
			$salida.= '<td align = "center">'.Agrega_Ceros($cod).'</td>';
			//nombre
			$dpi = $row["gro_dpi"];
			$salida.= '<td align = "center">'.$dpi.'</td>';
			//nombre
			$nom = $row["gro_nombre"];
			$salida.= '<td align = "left">'.$nom.'</td>';
			//direccion
			$dir = $row["gro_direccion"];
			$mundep = $row["dm_desc"];
			$salida.= '<td align = "left">'.$dir.' '.$mundep.'</td>';
			//telefono 1
			$tel = $row["gro_tel1"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//telefono 2
			$tel = $row["gro_tel2"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//mail
			$mail = $row["gro_mail"];
			$salida.= '<td align = "center">'.$mail.'</td>';
			//situacion
			$sit = $row["gro_situacion"];
			$sit = ($sit == 1)?"ACTIVA":"INACTIVA";
			$salida.= '<td align = "center">'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "9"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}



//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
