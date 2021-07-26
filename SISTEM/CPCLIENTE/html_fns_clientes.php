<?php 
include_once('../html_fns.php');

function tabla_clientes($cod,$nit,$nom){
	$ClsCli = new ClsCliente();
	$cont = $ClsCli->count_cliente($cod,$nit,$nom);
	
	if($cont>0){
		$result = $ClsCli->get_cliente($cod,$nit,$nom);
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "40px">NIT</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">DIRECCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONOS</td>';
			$salida.= '<th class = "text-center" width = "170px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["cli_id"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Cliente('.$cod.');" title = "Editar Cliente" ><span class="glyphicon glyphicon-pencil"></span></button>';
			$salida.= '</td>';
			//NIT
			$nit = utf8_decode($row["cli_nit"]);
			$salida.= '<td class = "text-center">'.$nit.'</td>';
			//nombre
			$nom = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//Direccion
			$dir = utf8_decode($row["cli_direccion"]);
			$salida.= '<td class = "text-left">'.$dir.'</td>';
			//telefono 1
			$tel1 = $row["cli_tel1"];
			$tel2 = $row["cli_tel2"];
			$salida.= '<td class = "text-center">'.$tel1.' - '.$tel2.'</td>';
			//email
			$mail = $row["cli_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick="Historial_Compras('.$cod.');" title = "Historial de Compras del Cliente" ><span class="fa fa-history"></span></button> ';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick="Lista_Articulos('.$cod.');" title = "Listado de Art&iacute;culos que regularmente compra" ><span class="fa fa-shopping-cart"></span></button> ';
			$salida.= '</td>';
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
