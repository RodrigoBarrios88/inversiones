<?php 
include_once('../../html_fns.php');

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////

function tabla_rep_plazas($dct,$dlg,$suc,$dep,$sit){
	$ClsOrg = new ClsOrganizacion();
	$cont = $ClsOrg->count_plaza($plaza,$suc,$dep,$dct,$dlg,$jer,$sub,$ind,$sit);
	
	if($cont>0){
		$result = $ClsOrg->get_plaza($plaza,$suc,$dep,$dct,$dlg,$jer,$sub,$ind,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px">No.</td>';
			$salida.= '<th align = "center" width = "90px">PLAZA</td>';
			$salida.= '<th align = "center" width = "110px">NOMBRE ABREVIADO</td>';
			$salida.= '<th align = "center" width = "200px">NOMBRE COMPLETO</td>';
			$salida.= '<th align = "center" width = "120px">EMPRESA</td>';
			$salida.= '<th align = "center" width = "150px">DEPARAMENTO</td>';
			$salida.= '<th align = "center" width = "80px">SITUACIÓN</td>';
			$salida.= '</tr>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<th align = "center">'.$i.'.</th>';
			//Plaza
			$plaza = $row["org_plaza"];
			$salida.= '<td align = "center">'.Agrega_Ceros($plaza).'</td>';
			//desc corta
			$dct = $row["org_desc_ct"];
			$salida.= '<td align = "center">'.$dct.'</td>';
			//desc larga
			$dlg = $row["org_desc_lg"];
			$salida.= '<td align = "center">'.$dlg.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$suc.'</td>';
			//departamento
			$dep = $row["dep_desc_ct"];
			$salida.= '<td align = "center">'.$dep.'</td>';
			//situacion
			$sit = $row["org_situacion"];
			$sit = ($sit == 1)?"ACTIVO":"INACTIVO";
			$salida.= '<td align = "center">'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "8"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}

//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
