<?php
include_once('../html_fns.php');

function tabla_rep_his_auditoria($dep,$usu,$mod,$acc,$fini,$ffin){
	$ClsBit = new ClsBitacora();
	$result = $ClsBit->get_bitacora($id,$dep,$usu,$mod,$acc,$fini,$ffin);

	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<th class = "encabeza" align = "center" width = "50px" height = "30px">No.</td>';
			$salida.= '<th class = "encabeza" align = "center" width = "100px" ># TRANSACCIÓN</td>';
			$salida.= '<th class = "encabeza" align = "center" width = "150px" >FECHA/HORA DE LA ACCIÓN</td>';
			$salida.= '<th class = "encabeza" align = "center" width = "100px" >CATALOGO</td>';
			$salida.= '<th class = "encabeza" align = "center" width = "200px" >USUARIO</td>';
			$salida.= '<th class = "encabeza" align = "center" width = "150px" >MODULO</td>';
			$salida.= '<th class = "encabeza" align = "center" width = "400px" >DESCRIPCIÓN</td>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//numero
			$salida.= '<th align = "center">'.$i.'</th>';
			//transaccion
			$numero = trim($row["bit_id"]);
			$salida.= '<td class = "celda" align = "center"> # '.$numero.'</td>';
			//fecha
			$fec = $row["bit_fec_hor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celda" align = "center">'.$fec.'</td>';
			//Quien Nombre
			$usu = trim($row["usu_id"]);
			$salida.= '<td class = "celda" align = "center">'.$usu.'</td>';
			//Quien Nombre
			$nom = trim($row["usu_nombre"])." ".trim($row["usu_nom2"])." ".trim($row["usu_ape1"])." ".trim($row["usu_ape2"]);;
			$salida.= '<td class = "celda" align = "left">'.$nom.'</td>';
			//Modulo
			$modu = trim($row["bit_modulo"]);
			switch ($modu){
				case "ING": $moddes = "INGRESOS"; break;
				case "USU": $moddes = "USUARIOS"; break;
				case "REG": $moddes = "REGISTRO DE ACCIONES"; break;
			}
			$salida.= '<td class = "celda" align = "center">'.$moddes.'</td>';
			//descripcion
			$obs = trim($row["bit_obs"]);
			$salida.= '<td class = "celda"  class = "text-justify">'.$obs.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '<br>';
			$salida.= '</div>';
	}

	return $salida;
}

//echo tabla_rep_his_auditoria($dep,$usu,$mod,$acc,$fini,$ffin);

?>
