<?php 
include_once('../html_fns.php');

function tabla_sucursales($cod,$nom,$contact){
	$ClsEmp = new ClsEmpresa();
	$result = $ClsEmp->get_sucursal($cod,$nom,$contact);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "50px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE DE LA EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO 1</th>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "200px">CONTACTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["suc_id"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Empresa('.$cod.')" title = "Editar Empresa" ><span class="glyphicon glyphicon-pencil"></span></button>';
			$salida.= '</td>';
			
			//nombre
			$nom = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//codigo
			$tel = $row["suc_tel1"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//codigo
			$mail = $row["suc_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//codigo
			$contact = utf8_decode($row["suc_contacto"]);
			$salida.= '<td class = "text-center">'.$contacto.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}
?>
