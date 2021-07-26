<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

function tabla_push_user($user_id){
	$ClsPush = new ClsPushup();
	$result = $ClsPush->get_push_user($user_id);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "5px" class = "text-center">Editar Usuario</th>';
			$salida.= '<th width = "5px" class = "text-center">Eliminar Usuario</th>';
			$salida.= '<th width = "50px" class = "text-center">Enviar PushUp Especifica</th>';
			$salida.= '<th width = "10px" class = "text-center">user_id</th>';
			$salida.= '<th width = "100px" class = "text-center">device_type</th>';
			$salida.= '<th width = "100px" class = "text-center">updated_at</th>';
			$salida.= '<th width = "120px" class = "text-center">device_id</th>';
			$salida.= '<th width = "100px" class = "text-center">device_token</th>';
			$salida.= '<th width = "100px" class = "text-center">certificate_type</th>';
			$salida.= '<th width = "100px" class = "text-center">status</th>';
			$salida.= '<th width = "100px" class = "text-center">created_at</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$user_id = trim($row["user_id"]);
			$device_id = trim($row["device_id"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Push(\''.$user_id.'\',\''.$device_id.'\');" title = "Seleccionar Usuario" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '</td>';	
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="DeletePush(\''.$user_id.'\',\''.$device_id.'\');" title = "Eliminar Usuario" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';	
			//botones
			$salida.= '<td class = "text-center">';
			$tarea = $row["post_codigo"];
			$salida.= '<a href="FRMpush.php?user_id='.$user_id.'&device_id='.$device_id.'" target = "_blank" class="btn btn-primary btn-xs" title = "Ejecutar Push Individual" ><span class="fa fa-comments"></span></a> ';
			$salida.= '</td>';
			//--
			$user_id = trim($row["user_id"]);
			$salida.= '<td class = "text-center">'.$user_id.'</td>';
			//
			$device_type = utf8_decode($row["device_type"]);
			$salida.= '<td class = "text-center">'.$device_type.'</td>';
			//
			$updated_at = utf8_decode($row["updated_at"]);
			$salida.= '<td class = "text-center">'.$updated_at.'</td>';
			//
			$device_id = trim($row["device_id"]);
			$salida.= '<td class = "text-center">'.$device_id.'</td>';
			//
			$device_token = utf8_decode($row["device_token"]);
			$salida.= '<td class = "text-justify">'.$device_token.'</td>';
			//
			$certificate_type = utf8_decode($row["certificate_type"]);
			$salida.= '<td class = "text-center">'.$certificate_type.'</td>';
			//
			$status = utf8_decode($row["status"]);
			$salida.= '<td class = "text-center">'.$status.'</td>';
			//
			$created_at = utf8_decode($row["created_at"]);
			$salida.= '<td class = "text-center">'.$created_at.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}






?>
