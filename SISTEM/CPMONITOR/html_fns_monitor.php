<?php 
include_once('../html_fns.php');

//////////////////---- Otros Monitores de Buses -----/////////////////////////////////////////////
function tabla_monitores_buses($cui,$nom,$ape,$sit,$acc){
	$ClsMoni = new ClsMonitorBus();
	$sit = ($acc == 2)?1:"";
	$cont = $ClsMoni->count_monitores_buses($cui,$nom,$ape,1);
	
	if($cont>0){
		$result = $ClsMoni->get_monitores_buses($cui,$nom,$ape,1);
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			if($acc == 1){
			$salida.= '<th width = "30px" colspan = "2"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			}else if($acc == 2){
			$salida.= '<th width = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			}else{
			$salida.= '<th width = "30px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			}
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			if($acc == 1){
			//codigo
			$cui = $row["mbus_cui"];
			$sit = $row["mbus_situacion"];
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Monitor(\''.$cui.'\')" title = "Editar T&eacute;cnico" ><span class="glyphicon glyphicon-pencil"></span></button>';
				$salida.= '</td>';
				if($sit == 1){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Monitor(\''.$cui.'\')" title = "inhabilitar T&eacute;cnico" ><span class="glyphicon glyphicon-trash"></span></button>';
				$salida.= '</td>';
				}else if($sit == 2){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Habilita_Monitor(\''.$cui.'\')" title = "Habilitar T&eacute;cnico" ><span class="glyphicon glyphicon-ok"></span></button>';
				$salida.= '</td>';
				}
			}else if($acc == 2){
			//codigo
			$cui = $row["mbus_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsMoni->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick="window.location=\'FRMmonitorasig.php?hashkey='.$hashkey.'\'" title = "Seleccionar Maestro" ><span class="fa fa-link"></span></button>';
				$salida.= '</td>';
			}else{
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			}
			//nombre
			$nom = utf8_decode($row["mbus_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["mbus_apellido"]);
			$salida.= '<td class = "text-center">'.$ape.'</td>';
			//telefono1
			$tel = $row["mbus_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//correo
			$mail = $row["mbus_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
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
?>
