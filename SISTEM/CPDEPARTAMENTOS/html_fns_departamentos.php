<?php 
include_once('../html_fns.php');

function tabla_departamentos($cod,$suc,$dct,$dlg,$sit){
	$ClsDep = new ClsDepartamento();
	$result = $ClsDep->get_departamento($cod,$suc,$dct,$dlg,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE DE LA EMPRESA</td>';
			$salida.= '<th class = "text-center" width = "150px">NOMBRE ABREVIADO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE COMPLETO</td>';
			$salida.= '<th class = "text-center" width = "100px">SITUACIÓN</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["dep_id"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Departamento('.$cod.')" title = "Editar Departamento" > <span class="glyphicon glyphicon-pencil"></span> </button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "EliminarDepartamento('.$cod.')" title = "Eliminar Departamento" > <span class="fa fa-trash-o"></span> </button>';
			$salida.= '</td>';
			//empresa
			$emp = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$emp.'</td>';
			//desc corta
			$dct = utf8_decode($row["dep_desc_ct"]);
			$salida.= '<td class = "text-center">'.$dct.'</td>';
			//desc larga
			$dlg = utf8_decode($row["dep_desc_lg"]);
			$salida.= '<td class = "text-center">'.$dlg.'</td>';
			//situacion
			$sit = $row["dep_situacion"];
			$sit = ($sit == 1)?"ACTIVO":"INACTIVO";
			$salida.= '<td class = "text-center">'.$sit.'</td>';
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
