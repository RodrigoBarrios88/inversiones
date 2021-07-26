<?php 
include_once('../../html_fns.php');

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////

function tabla_rep_sucursales($nom,$contact,$sit){
	$ClsEmp = new ClsEmpresa();
	$cont = $ClsEmp->count_sucursal($cod,'',$nom,$contact,$sit);
	
	if($cont>0){
		$result = $ClsEmp->get_sucursal($cod,'',$nom,$contact,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px">No.</th>';
			$salida.= '<th align = "center" width = "60px">CODIGO</th>';
			$salida.= '<th align = "center" width = "220px">NOMBRE DE LA EMPRESA</th>';
			$salida.= '<th align = "center" width = "250px">DIRECCIÓN</th>';
			$salida.= '<th align = "center" width = "70px">TELEFONO 1</th>';
			$salida.= '<th align = "center" width = "70px">TELEFONO 2</th>';
			$salida.= '<th align = "center" width = "100px">MAIL</th>';
			$salida.= '<th align = "center" width = "100px">CONTACTO</th>';
			$salida.= '<th align = "center" width = "70px">TEL. CONTACTO</th>';
			$salida.= '<th align = "center" width = "70px">SITUACIÓN</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<th align = "center">'.$i.'.</th>';
			//codigo
			$cod = $row["suc_id"];
			$salida.= '<td align = "center">'.Agrega_Ceros($cod).'</td>';
			//nombre
			$nom = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$nom.'</td>';
			//direccion
			$dir = $row["suc_direccion"];
			$salida.= '<td align = "center">'.$dir.'</td>';
			//telefono 1
			$tel = $row["suc_tel1"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//telefono 2
			$tel = $row["suc_tel2"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//mail
			$mail = $row["suc_mail"];
			$salida.= '<td align = "center">'.$mail.'</td>';
			//contacto
			$contacto = $row["suc_contacto"];
			$salida.= '<td align = "center">'.$contacto.'</td>';
			//telefono contacto
			$tel = $row["suc_cont_tel"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//situacion
			$sit = $row["suc_situacion"];
			$sit = ($sit == 1)?"ACTIVA":"INACTIVA";
			$salida.= '<td align = "center">'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "10"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
