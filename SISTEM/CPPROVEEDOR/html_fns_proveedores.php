<?php 
include_once('../html_fns.php');

function tabla_proveedores($cod,$nit,$nom,$contact){
	$ClsProv = new ClsProveedor();
	$result = $ClsProv->get_proveedor($cod,$nit,$nom,$contact);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "60px">NIT</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO 1</td>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "200px">CONTACTO</td>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["prov_id"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Proveedor('.$cod.');" title = "Editar Proveedor" ><span class="glyphicon glyphicon-pencil"></span></button> ';
			$salida.= '</td>';
			//nombre
			$nit = $row["prov_nit"];
			$salida.= '<td class = "text-center">'.$nit.'</td>';
			//nombre
			$nom = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//codigo
			$tel = $row["prov_tel1"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//codigo
			$mail = $row["prov_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//codigo
			$contacto = utf8_decode($row["prov_contacto"]);
			$salida.= '<td class = "text-center">'.$contacto.'</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick="Historial_Compras('.$cod.');" title = "Historial de Compras" ><span class="fa fa-history"></span></button> ';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick="Lista_Articulos('.$cod.');" title = "Listado de Art&iacute;culos que Provee" ><span class="fa fa-shopping-cart"></span></button> ';
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
